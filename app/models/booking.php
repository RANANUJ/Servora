
<?php

class Booking extends Model
{
    // Create a booking and notify the selected provider
    public function createBooking($data)
    {
        try {
            $this->db->beginTransaction();

            $bookingNumber = 'SVR-' .
                date('Ymd') . '-' .
                strtoupper(bin2hex(random_bytes(4)));

            $sql = "INSERT INTO bookings
                    (
                        booking_number,
                        customer_id,
                        provider_id,
                        service_id,
                        booking_date,
                        booking_time,
                        service_address,
                        city,
                        pincode,
                        customer_message,
                        price,
                        status
                    )
                    VALUES
                    (
                        :booking_number,
                        :customer_id,
                        :provider_id,
                        :service_id,
                        :booking_date,
                        :booking_time,
                        :service_address,
                        :city,
                        :pincode,
                        :customer_message,
                        :price,
                        'pending'
                    )";

            $stmt = $this->db->prepare($sql);

            $stmt->execute([
                ':booking_number' => $bookingNumber,
                ':customer_id' => $data['customer_id'],
                ':provider_id' => $data['provider_id'],
                ':service_id' => $data['service_id'],
                ':booking_date' => $data['booking_date'],
                ':booking_time' => $data['booking_time'],
                ':service_address' => $data['service_address'],
                ':city' => $data['city'],
                ':pincode' => $data['pincode'],
                ':customer_message' => $data['customer_message'],
                ':price' => $data['price']
            ]);

            $bookingId = (int) $this->db->lastInsertId();

            // Notify provider
            $notificationSql = "INSERT INTO notifications
                                (
                                    user_id,
                                    title,
                                    message,
                                    type,
                                    related_booking_id,
                                    is_read
                                )
                                VALUES
                                (
                                    :user_id,
                                    :title,
                                    :message,
                                    'booking',
                                    :booking_id,
                                    0
                                )";

            $notificationStmt = $this->db->prepare($notificationSql);

            $notificationStmt->execute([
                ':user_id' => $data['provider_user_id'],
                ':title' => 'New Booking Request',
                ':message' => 'You have received a new booking request for ' .
                    $data['service_title'] .
                    '. Booking number: ' .
                    $bookingNumber,
                ':booking_id' => $bookingId
            ]);

            $this->db->commit();

            return [
                'id' => $bookingId,
                'booking_number' => $bookingNumber
            ];

        } catch (Throwable $exception) {

            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }

            throw $exception;
        }
    }


    // Get all bookings belonging to a particular customer
    public function getBookingsByCustomer($customerId)
    {
        $sql = "SELECT
                    bookings.*,

                    services.title AS service_title,
                    services.service_image,

                    provider_profiles.business_name,
                    provider_profiles.city AS provider_city,

                    provider_user.name AS provider_name

                FROM bookings

                INNER JOIN services
                    ON bookings.service_id = services.id

                INNER JOIN provider_profiles
                    ON bookings.provider_id = provider_profiles.id

                INNER JOIN users AS provider_user
                    ON provider_profiles.user_id = provider_user.id

                WHERE bookings.customer_id = :customer_id

                ORDER BY bookings.created_at DESC";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':customer_id' => $customerId
        ]);

        return $stmt->fetchAll();
    }


    // Find a booking belonging to a particular customer
    public function findForCustomer($bookingNumber, $customerId)
    {
        $sql = "SELECT
                    bookings.*,
                    services.title AS service_title,
                    services.service_image,
                    provider_profiles.business_name,
                    provider_profiles.city AS provider_city,
                    provider_user.name AS provider_name

                FROM bookings

                INNER JOIN services
                    ON bookings.service_id = services.id

                INNER JOIN provider_profiles
                    ON bookings.provider_id = provider_profiles.id

                INNER JOIN users AS provider_user
                    ON provider_profiles.user_id = provider_user.id

                WHERE bookings.booking_number = :booking_number
                AND bookings.customer_id = :customer_id

                LIMIT 1";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':booking_number' => $bookingNumber,
            ':customer_id' => $customerId
        ]);

        return $stmt->fetch();
    }


    // Get all bookings received by a particular provider
    public function getBookingsByProvider($providerId)
    {
        $sql = "SELECT
                    bookings.*,

                    services.title AS service_title,
                    services.service_image,

                    customer.name AS customer_name,
                    customer.email AS customer_email,
                    customer.phone AS customer_phone

                FROM bookings

                INNER JOIN services
                    ON bookings.service_id = services.id

                INNER JOIN users AS customer
                    ON bookings.customer_id = customer.id

                WHERE bookings.provider_id = :provider_id

                ORDER BY bookings.created_at DESC";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':provider_id' => $providerId
        ]);

        return $stmt->fetchAll();
    }


    // Find one booking belonging to a particular provider
    public function findForProvider($bookingId, $providerId)
    {
        $sql = "SELECT
                    bookings.*,

                    services.title AS service_title,
                    services.service_image,

                    customer.name AS customer_name,
                    customer.email AS customer_email,
                    customer.phone AS customer_phone

                FROM bookings

                INNER JOIN services
                    ON bookings.service_id = services.id

                INNER JOIN users AS customer
                    ON bookings.customer_id = customer.id

                WHERE bookings.id = :booking_id
                AND bookings.provider_id = :provider_id

                LIMIT 1";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':booking_id' => $bookingId,
            ':provider_id' => $providerId
        ]);

        return $stmt->fetch();
    }


    // Update booking status and notify the customer
    public function updateStatus($bookingId, $providerId, $newStatus)
    {
        $allowedTransitions = [
            'accepted' => [
                'current' => 'pending',
                'message' => 'Your booking request has been accepted.'
            ],

            'rejected' => [
                'current' => 'pending',
                'message' => 'Your booking request has been rejected.'
            ],

            'in_progress' => [
                'current' => 'accepted',
                'message' => 'Your service is now in progress.'
            ],

            'completed' => [
                'current' => 'in_progress',
                'message' => 'Your service has been completed.'
            ]
        ];

        if (!isset($allowedTransitions[$newStatus])) {
            return false;
        }

        try {
            $this->db->beginTransaction();

            // Lock the booking while checking its current status
            $sql = "SELECT
                        id,
                        customer_id,
                        status

                    FROM bookings

                    WHERE id = :booking_id
                    AND provider_id = :provider_id

                    LIMIT 1

                    FOR UPDATE";

            $stmt = $this->db->prepare($sql);

            $stmt->execute([
                ':booking_id' => $bookingId,
                ':provider_id' => $providerId
            ]);

            $booking = $stmt->fetch();

            if (!$booking) {
                $this->db->rollBack();
                return false;
            }

            $transition = $allowedTransitions[$newStatus];

            // Verify the requested status transition
            if ($booking['status'] !== $transition['current']) {
                $this->db->rollBack();
                return false;
            }

            // Update the booking
            $updateSql = "UPDATE bookings

                          SET status = :new_status,
                              updated_at = CURRENT_TIMESTAMP

                          WHERE id = :booking_id
                          AND provider_id = :provider_id
                          AND status = :current_status";

            $updateStmt = $this->db->prepare($updateSql);

            $updateStmt->execute([
                ':new_status' => $newStatus,
                ':booking_id' => $bookingId,
                ':provider_id' => $providerId,
                ':current_status' => $transition['current']
            ]);

            if ($updateStmt->rowCount() !== 1) {
                $this->db->rollBack();
                return false;
            }

            // Notify the customer
            $notificationSql = "INSERT INTO notifications
                                (
                                    user_id,
                                    title,
                                    message,
                                    type,
                                    related_booking_id,
                                    is_read
                                )
                                VALUES
                                (
                                    :user_id,
                                    :title,
                                    :message,
                                    'booking',
                                    :booking_id,
                                    0
                                )";

            $notificationStmt = $this->db->prepare($notificationSql);

            $notificationStmt->execute([
                ':user_id' => $booking['customer_id'],
                ':title' => 'Booking Status Updated',
                ':message' => $transition['message'],
                ':booking_id' => $bookingId
            ]);

            $this->db->commit();

            return true;

        } catch (Throwable $exception) {

            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }

            throw $exception;
        }
    }
}
