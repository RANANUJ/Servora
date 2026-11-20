
<?php

class Review extends Model
{
    /**
     * Get the review submitted for a booking.
     */
    public function getByBookingId($bookingId)
    {
        $sql = "
            SELECT
                reviews.*,
                users.name AS customer_name
            FROM reviews
            INNER JOIN users
                ON users.id = reviews.customer_id
            WHERE reviews.booking_id = :booking_id
            LIMIT 1
        ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':booking_id' => $bookingId
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    /**
     * Get all reviews submitted by a particular customer.
     */
    public function getByCustomerId($customerId)
    {
        $sql = "
            SELECT
                reviews.*,
                services.title AS service_title,
                services.service_image,
                provider_profiles.business_name,
                provider_users.name AS provider_name

            FROM reviews

            INNER JOIN services
                ON services.id = reviews.service_id

            INNER JOIN provider_profiles
                ON provider_profiles.id = reviews.provider_id

            INNER JOIN users AS provider_users
                ON provider_users.id = provider_profiles.user_id

            WHERE reviews.customer_id = :customer_id

            ORDER BY reviews.created_at DESC
        ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':customer_id' => $customerId
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    /**
     * Get all published reviews for one service.
     */
    public function getPublishedByServiceId($serviceId)
    {
        $sql = "
            SELECT
                reviews.id,
                reviews.rating,
                reviews.comment,
                reviews.created_at,
                users.name AS customer_name

            FROM reviews

            INNER JOIN users
                ON users.id = reviews.customer_id

            WHERE reviews.service_id = :service_id
              AND reviews.status = 'published'

            ORDER BY reviews.created_at DESC
        ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':service_id' => $serviceId
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    /**
     * Get average rating and total published reviews
     * for one service.
     */
    public function getServiceRatingSummary($serviceId)
    {
        $sql = "
            SELECT
                ROUND(AVG(rating), 1) AS average_rating,
                COUNT(*) AS review_count

            FROM reviews

            WHERE service_id = :service_id
              AND status = 'published'
        ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':service_id' => $serviceId
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    /**
     * Get all published reviews received by a provider.
     */
    public function getPublishedByProviderId($providerId)
    {
        $sql = "
            SELECT
                reviews.id,
                reviews.rating,
                reviews.comment,
                reviews.created_at,

                users.name AS customer_name,

                services.id AS service_id,
                services.title AS service_title

            FROM reviews

            INNER JOIN users
                ON users.id = reviews.customer_id

            INNER JOIN services
                ON services.id = reviews.service_id

            WHERE reviews.provider_id = :provider_id
              AND reviews.status = 'published'

            ORDER BY reviews.created_at DESC
        ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':provider_id' => $providerId
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    /**
     * Get overall rating summary for one provider.
     */
    public function getProviderRatingSummary($providerId)
    {
        $sql = "
            SELECT
                ROUND(AVG(rating), 1) AS average_rating,
                COUNT(*) AS review_count

            FROM reviews

            WHERE provider_id = :provider_id
              AND status = 'published'
        ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':provider_id' => $providerId
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    /**
     * Create a review only if the booking:
     * - Belongs to the customer.
     * - Has been completed.
     * - Does not already have a review.
     */
    public function createForCompletedBooking(
        $bookingId,
        $customerId,
        $rating,
        $comment
    ) {
        $sql = "
            INSERT INTO reviews (
                booking_id,
                customer_id,
                provider_id,
                service_id,
                rating,
                comment,
                status,
                created_at,
                updated_at
            )

            SELECT
                bookings.id,
                bookings.customer_id,
                bookings.provider_id,
                bookings.service_id,
                :rating,
                :comment,
                'published',
                NOW(),
                NOW()

            FROM bookings

            WHERE bookings.id = :booking_id
              AND bookings.customer_id = :customer_id
              AND bookings.status = 'completed'

              AND NOT EXISTS (
                  SELECT 1
                  FROM reviews
                  WHERE reviews.booking_id = bookings.id
              )
        ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':rating' => $rating,
            ':comment' => $comment,
            ':booking_id' => $bookingId,
            ':customer_id' => $customerId
        ]);

        return $stmt->rowCount() === 1;
    }
}
