
<?php require APP_ROOT . '/app/views/layouts/header.php'; ?>

<?php

$bookingDate = date(
    'd F Y',
    strtotime($booking['booking_date'])
);

$bookingTime = date(
    'h:i A',
    strtotime($booking['booking_time'])
);

$bookingPrice = '₹' . number_format(
    (float) $booking['price'],
    2
);

?>

<style>
.booking-confirmation-section {
    background: #F6F8FC;
    min-height: 80vh;
    padding: 55px 0;
}

.confirmation-container {
    max-width: 850px;
}

.confirmation-card {
    background: #FFFFFF;
    border: 1px solid #E8EDF5;
    border-radius: 18px;
    box-shadow: 0 12px 40px rgba(23, 36, 58, 0.06);
    overflow: hidden;
}

.confirmation-header {
    text-align: center;
    padding: 40px 25px 30px;
    background: #F0FAF4;
    border-bottom: 1px solid #E3F3E9;
}

.confirmation-icon {
    width: 75px;
    height: 75px;
    border-radius: 50%;
    background: #DDF5E6;
    color: #16834A;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 35px;
    margin: 0 auto 18px;
}

.confirmation-header h1 {
    font-size: 27px;
    font-weight: 800;
    color: #17243A;
    margin-bottom: 10px;
}

.confirmation-header p {
    color: #64748B;
    margin-bottom: 0;
    line-height: 1.7;
}

.confirmation-body {
    padding: 30px;
}

.booking-number-box {
    background: #F6F8FC;
    border: 1px dashed #CBD5E1;
    border-radius: 10px;
    padding: 17px;
    text-align: center;
    margin-bottom: 28px;
}

.booking-number-label {
    display: block;
    color: #64748B;
    font-size: 12px;
    font-weight: 700;
    margin-bottom: 7px;
}

.booking-number {
    color: #2457D6;
    font-size: 19px;
    font-weight: 800;
    letter-spacing: 1px;
    overflow-wrap: anywhere;
}

.confirmation-section-title {
    font-size: 17px;
    font-weight: 800;
    color: #17243A;
    margin-bottom: 18px;
}

.booking-detail-row {
    display: flex;
    justify-content: space-between;
    gap: 15px;
    padding: 13px 0;
    border-bottom: 1px solid #EEF2F7;
}

.booking-detail-label {
    color: #64748B;
    font-size: 13px;
}

.booking-detail-value {
    color: #17243A;
    font-size: 13px;
    font-weight: 700;
    text-align: right;
    overflow-wrap: anywhere;
}

.booking-pending-badge {
    background: #FFF5E5;
    color: #B76A08;
    padding: 6px 11px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 800;
}

.confirmation-note {
    background: #F0F5FF;
    color: #45618E;
    padding: 17px;
    border-radius: 10px;
    font-size: 13px;
    line-height: 1.7;
    margin-top: 25px;
}

.confirmation-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    margin-top: 28px;
}

.confirmation-primary-button {
    background: #2457D6;
    color: #FFFFFF;
    padding: 12px 22px;
    border-radius: 8px;
    text-decoration: none;
    font-size: 13px;
    font-weight: 700;
}

.confirmation-primary-button:hover {
    background: #1744B5;
    color: #FFFFFF;
}

.confirmation-secondary-button {
    background: #FFFFFF;
    color: #2457D6;
    border: 1px solid #2457D6;
    padding: 12px 22px;
    border-radius: 8px;
    text-decoration: none;
    font-size: 13px;
    font-weight: 700;
}

.confirmation-secondary-button:hover {
    background: #EEF3FF;
    color: #1744B5;
}

@media (max-width: 576px) {
    .booking-confirmation-section {
        padding: 30px 0;
    }

    .confirmation-header {
        padding: 30px 18px;
    }

    .confirmation-header h1 {
        font-size: 22px;
    }

    .confirmation-body {
        padding: 20px;
    }

    .booking-detail-row {
        flex-direction: column;
        gap: 5px;
    }

    .booking-detail-value {
        text-align: left;
    }

    .confirmation-actions {
        flex-direction: column;
    }

    .confirmation-actions a {
        text-align: center;
    }
}
</style>


<section class="booking-confirmation-section">

    <div class="container confirmation-container">

        <div class="confirmation-card">

            <!-- SUCCESS HEADER -->
            <div class="confirmation-header">

                <div class="confirmation-icon">
                    <i class="bi bi-check-lg"></i>
                </div>

                <h1>Booking Request Sent!</h1>

                <p>
                    Your booking request has been successfully submitted.
                    The service provider will review your request and
                    respond shortly.
                </p>

            </div>


            <div class="confirmation-body">

                <!-- BOOKING NUMBER -->
                <div class="booking-number-box">

                    <span class="booking-number-label">
                        YOUR BOOKING NUMBER
                    </span>

                    <div class="booking-number">
                        <?= htmlspecialchars(
                            $booking['booking_number'],
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>
                    </div>

                </div>


                <!-- BOOKING DETAILS -->
                <h3 class="confirmation-section-title">
                    <i class="bi bi-calendar-check text-primary me-2"></i>
                    Booking Details
                </h3>


                <div class="booking-detail-row">

                    <span class="booking-detail-label">
                        Service
                    </span>

                    <span class="booking-detail-value">
                        <?= htmlspecialchars(
                            $booking['service_title'],
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>
                    </span>

                </div>


                <div class="booking-detail-row">

                    <span class="booking-detail-label">
                        Provider
                    </span>

                    <span class="booking-detail-value">
                        <?= htmlspecialchars(
                            $booking['business_name'],
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>
                    </span>

                </div>


                <div class="booking-detail-row">

                    <span class="booking-detail-label">
                        Provider Name
                    </span>

                    <span class="booking-detail-value">
                        <?= htmlspecialchars(
                            $booking['provider_name'],
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>
                    </span>

                </div>


                <div class="booking-detail-row">

                    <span class="booking-detail-label">
                        Preferred Date
                    </span>

                    <span class="booking-detail-value">
                        <?= htmlspecialchars($bookingDate, ENT_QUOTES, 'UTF-8') ?>
                    </span>

                </div>


                <div class="booking-detail-row">

                    <span class="booking-detail-label">
                        Preferred Time
                    </span>

                    <span class="booking-detail-value">
                        <?= htmlspecialchars($bookingTime, ENT_QUOTES, 'UTF-8') ?>
                    </span>

                </div>


                <div class="booking-detail-row">

                    <span class="booking-detail-label">
                        Service Address
                    </span>

                    <span class="booking-detail-value">
                        <?= htmlspecialchars(
                            $booking['service_address'],
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>
                    </span>

                </div>


                <div class="booking-detail-row">

                    <span class="booking-detail-label">
                        City
                    </span>

                    <span class="booking-detail-value">
                        <?= htmlspecialchars(
                            $booking['city'],
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>
                    </span>

                </div>


                <div class="booking-detail-row">

                    <span class="booking-detail-label">
                        Pincode
                    </span>

                    <span class="booking-detail-value">
                        <?= htmlspecialchars(
                            $booking['pincode'],
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>
                    </span>

                </div>


                <div class="booking-detail-row">

                    <span class="booking-detail-label">
                        Booking Amount
                    </span>

                    <span class="booking-detail-value">
                        <?= htmlspecialchars($bookingPrice, ENT_QUOTES, 'UTF-8') ?>
                    </span>

                </div>


                <!-- STATUS -->
                <div class="booking-detail-row align-items-center">

                    <span class="booking-detail-label">
                        Current Status
                    </span>

                    <span class="booking-pending-badge">
                        PENDING
                    </span>

                </div>


                <!-- INFORMATION -->
                <div class="confirmation-note">

                    <i class="bi bi-info-circle me-2"></i>

                    Your request has been sent to the service provider.
                    You will be able to track its status from your
                    customer dashboard once booking tracking is connected.

                </div>


                <!-- ACTIONS -->
                <div class="confirmation-actions">

                    <a
                        href="<?= APP_URL ?>/dashboard"
                        class="confirmation-primary-button"
                    >
                        <i class="bi bi-grid me-2"></i>
                        Go to Dashboard
                    </a>


                    <a
                        href="<?= APP_URL ?>/services"
                        class="confirmation-secondary-button"
                    >
                        Browse More Services
                    </a>

                </div>

            </div>

        </div>

    </div>

</section>


<?php require APP_ROOT . '/app/views/layouts/footer.php'; ?>
