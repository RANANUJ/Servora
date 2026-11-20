
<?php

require APP_ROOT . '/app/views/layouts/header.php';

function providerBookingEscape($value)
{
    return htmlspecialchars(
        (string) ($value ?? ''),
        ENT_QUOTES,
        'UTF-8'
    );
}

$statusColors = [
    'pending' => 'warning',
    'accepted' => 'primary',
    'rejected' => 'danger',
    'in_progress' => 'info',
    'completed' => 'success',
    'cancelled' => 'secondary'
];

$statusColor = $statusColors[$booking['status']] ?? 'secondary';

?>

<style>

/* =========================================
   PROVIDER BOOKING DETAILS PAGE
========================================= */

.provider-booking-details-page {
    display: block;
    width: 100%;
    min-height: 100vh;
    height: auto !important;
    padding: 42px 0 75px;
    background: #F5F7FB;
    font-family: 'DM Sans', sans-serif;
    color: #17243A;
    overflow: visible;
    box-sizing: border-box;
}

.provider-booking-details-page > .container {
    width: 100%;
    max-width: 1160px;
    margin-left: auto;
    margin-right: auto;
}

/* =========================================
   IMPORTANT: FIX CARD HEIGHT
========================================= */

.provider-booking-details-page .dashboard-card {
    display: block !important;
    width: 100%;
    height: auto !important;
    min-height: 0 !important;
    max-height: none !important;
    flex: 0 0 auto !important;
    align-self: flex-start;
    box-sizing: border-box;
}

/* Keep cards at their natural content height */

.provider-booking-details-page .col-lg-8 > .dashboard-card,
.provider-booking-details-page .col-lg-4 > .dashboard-card {
    height: auto !important;
    min-height: 0 !important;
}

/* Prevent information sections from stretching */

.provider-booking-details-page .dashboard-card-heading {
    height: auto !important;
    min-height: 0 !important;
    flex: 0 0 auto !important;
}

.provider-booking-details-page .profile-information-item {
    height: auto !important;
    min-height: 0 !important;
    flex: 0 0 auto !important;
    align-items: center;
}

/* Keep columns aligned from the top */

.provider-booking-details-page > .container > .row {
    align-items: flex-start;
}

.provider-booking-details-page .col-lg-8,
.provider-booking-details-page .col-lg-4 {
    align-self: flex-start;
}

/* =========================================
   CUSTOMER REVIEW CARD
========================================= */

.provider-review-card {
    display: block;
    width: 100%;
    height: auto !important;
    min-height: 0 !important;
    flex: 0 0 auto !important;
    background: #FFFFFF;
    border: 1px solid #E8EDF5;
    border-radius: 15px;
    padding: 25px;
    margin-top: 22px;
    box-shadow: 0 15px 45px rgba(23, 36, 58, 0.06);
    box-sizing: border-box;
}

.provider-review-heading {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 15px;
    margin-bottom: 20px;
}

.provider-review-heading h3 {
    color: #17243A;
    font-size: 18px;
    font-weight: 700;
    margin: 0;
}

.provider-review-heading-icon {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #FFF5DF;
    color: #E5A01A;
    border-radius: 11px;
    font-size: 18px;
}

.provider-review-rating {
    display: flex;
    gap: 4px;
    color: #F5A623;
    font-size: 23px;
    margin-bottom: 13px;
}

.provider-review-customer {
    color: #17243A;
    font-size: 14px;
    font-weight: 700;
    margin-bottom: 5px;
}

.provider-review-date {
    color: #64748B;
    font-size: 12px;
    margin-bottom: 15px;
}

.provider-review-comment {
    background: #F8FAFD;
    border: 1px solid #E8EDF5;
    border-radius: 10px;
    padding: 16px;
    color: #64748B;
    font-size: 14px;
    line-height: 1.7;
    overflow-wrap: anywhere;
}

.provider-review-empty {
    background: #F8FAFD;
    border: 1px solid #E8EDF5;
    border-radius: 10px;
    padding: 18px;
    text-align: center;
}

.provider-review-empty i {
    color: #E5A01A;
    font-size: 27px;
    margin-bottom: 10px;
}

.provider-review-empty p {
    color: #64748B;
    font-size: 13px;
    margin: 0;
}

/* =========================================
   RESPONSIVE
========================================= */

@media (max-width: 767px) {

    .provider-booking-details-page {
        padding: 30px 0 50px;
    }

    .provider-review-card {
        padding: 20px;
    }

}

</style>

<section class="customer-dashboard provider-booking-details-page">

    <div class="container">

        <!-- PAGE HEADER -->
        <div class="dashboard-welcome">

            <div>

                <span class="dashboard-eyebrow">
                    <i class="bi bi-calendar-check"></i>
                    BOOKING MANAGEMENT
                </span>

                <h1>Booking Details</h1>

                <p>
                    Review the customer information and manage
                    this service appointment.
                </p>

            </div>

            <div class="dashboard-account-status">
                <span class="status-dot"></span>
                Provider Active
            </div>

        </div>

        <!-- ALERT MESSAGES -->
        <?php if (!empty($bookingMessage)): ?>

            <div class="alert alert-success">
                <?= providerBookingEscape($bookingMessage) ?>
            </div>

        <?php endif; ?>

        <?php if (!empty($bookingError)): ?>

            <div class="alert alert-danger">
                <?= providerBookingEscape($bookingError) ?>
            </div>

        <?php endif; ?>

        <div class="row g-4">

            <!-- MAIN BOOKING INFORMATION -->
            <div class="col-lg-8">

                <!-- BOOKING INFORMATION -->
                <div class="dashboard-card p-4 mb-4">

                    <div class="dashboard-card-heading mb-4">

                        <div>

                            <span class="section-eyebrow">
                                BOOKING INFORMATION
                            </span>

                            <h2>
                                <?= providerBookingEscape($booking['booking_number']) ?>
                            </h2>

                        </div>

                        <span class="badge text-bg-<?= $statusColor ?>">
                            <?= providerBookingEscape(
                                ucfirst(str_replace('_', ' ', $booking['status']))
                            ) ?>
                        </span>

                    </div>

                    <div class="row g-4">

                        <div class="col-md-6">

                            <div class="profile-information-item">

                                <div class="profile-information-icon">
                                    <i class="bi bi-tools"></i>
                                </div>

                                <div>
                                    <span>Service</span>

                                    <strong>
                                        <?= providerBookingEscape($booking['service_title']) ?>
                                    </strong>
                                </div>

                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="profile-information-item">

                                <div class="profile-information-icon">
                                    <i class="bi bi-currency-rupee"></i>
                                </div>

                                <div>
                                    <span>Booking amount</span>

                                    <strong>
                                        ₹<?= number_format((float) $booking['price'], 2) ?>
                                    </strong>
                                </div>

                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="profile-information-item">

                                <div class="profile-information-icon">
                                    <i class="bi bi-calendar-event"></i>
                                </div>

                                <div>
                                    <span>Appointment date</span>

                                    <strong>
                                        <?= date('d M Y', strtotime($booking['booking_date'])) ?>
                                    </strong>
                                </div>

                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="profile-information-item">

                                <div class="profile-information-icon">
                                    <i class="bi bi-clock"></i>
                                </div>

                                <div>
                                    <span>Appointment time</span>

                                    <strong>
                                        <?= date('h:i A', strtotime($booking['booking_time'])) ?>
                                    </strong>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                <!-- CUSTOMER INFORMATION -->
                <div class="dashboard-card p-4 mb-4">

                    <div class="dashboard-card-heading mb-4">

                        <div>

                            <span class="section-eyebrow">
                                CUSTOMER INFORMATION
                            </span>

                            <h2>Customer details</h2>

                        </div>

                        <span class="card-heading-icon">
                            <i class="bi bi-person"></i>
                        </span>

                    </div>

                    <div class="profile-information">

                        <div class="profile-information-item">

                            <div class="profile-information-icon">
                                <i class="bi bi-person"></i>
                            </div>

                            <div>
                                <span>Customer name</span>

                                <strong>
                                    <?= providerBookingEscape($booking['customer_name']) ?>
                                </strong>
                            </div>

                        </div>

                        <div class="profile-information-item">

                            <div class="profile-information-icon">
                                <i class="bi bi-envelope"></i>
                            </div>

                            <div>
                                <span>Email address</span>

                                <strong>
                                    <?= providerBookingEscape($booking['customer_email']) ?>
                                </strong>
                            </div>

                        </div>

                        <div class="profile-information-item">

                            <div class="profile-information-icon">
                                <i class="bi bi-telephone"></i>
                            </div>

                            <div>
                                <span>Phone number</span>

                                <strong>
                                    <?= providerBookingEscape(
                                        $booking['customer_phone'] ?: 'Not provided'
                                    ) ?>
                                </strong>
                            </div>

                        </div>

                    </div>

                </div>

                <!-- SERVICE ADDRESS -->
                <div class="dashboard-card p-4 mb-4">

                    <div class="dashboard-card-heading mb-4">

                        <div>

                            <span class="section-eyebrow">
                                SERVICE LOCATION
                            </span>

                            <h2>Customer address</h2>

                        </div>

                        <span class="card-heading-icon">
                            <i class="bi bi-geo-alt"></i>
                        </span>

                    </div>

                    <p class="mb-2">
                        <?= nl2br(providerBookingEscape($booking['service_address'])) ?>
                    </p>

                    <p class="text-muted mb-0">
                        <?= providerBookingEscape($booking['city']) ?>
                        -
                        <?= providerBookingEscape($booking['pincode']) ?>
                    </p>

                </div>

                <!-- CUSTOMER MESSAGE -->
                <div class="dashboard-card p-4">

                    <div class="dashboard-card-heading mb-3">

                        <div>

                            <span class="section-eyebrow">
                                CUSTOMER MESSAGE
                            </span>

                            <h2>Additional instructions</h2>

                        </div>

                        <span class="card-heading-icon">
                            <i class="bi bi-chat-left-text"></i>
                        </span>

                    </div>

                    <?php if (!empty($booking['customer_message'])): ?>

                        <p class="mb-0">
                            <?= nl2br(providerBookingEscape($booking['customer_message'])) ?>
                        </p>

                    <?php else: ?>

                        <p class="text-muted mb-0">
                            The customer has not provided any additional instructions.
                        </p>

                    <?php endif; ?>

                </div>

                <!-- CUSTOMER REVIEW -->
                <?php if ($booking['status'] === 'completed'): ?>

                    <div class="provider-review-card">

                        <div class="provider-review-heading">

                            <div>

                                <span class="section-eyebrow">
                                    CUSTOMER FEEDBACK
                                </span>

                                <h3>Service Review</h3>

                            </div>

                            <span class="provider-review-heading-icon">
                                <i class="bi bi-star-fill"></i>
                            </span>

                        </div>

                        <?php if (!empty($review)): ?>

                            <div class="provider-review-rating"
                                 aria-label="<?= (int) $review['rating'] ?> out of 5 stars">

                                <?php for ($i = 1; $i <= 5; $i++): ?>

                                    <?php if ($i <= (int) $review['rating']): ?>
                                        <i class="bi bi-star-fill"></i>
                                    <?php else: ?>
                                        <i class="bi bi-star"></i>
                                    <?php endif; ?>

                                <?php endfor; ?>

                            </div>

                            <div class="provider-review-customer">
                                <?= providerBookingEscape($review['customer_name'] ?? $booking['customer_name']) ?>
                            </div>

                            <?php if (!empty($review['created_at'])): ?>

                                <div class="provider-review-date">
                                    <i class="bi bi-calendar3 me-1"></i>
                                    Reviewed on
                                    <?= date('d M Y', strtotime($review['created_at'])) ?>
                                </div>

                            <?php endif; ?>

                            <div class="provider-review-comment">
                                <?= nl2br(providerBookingEscape($review['comment'])) ?>
                            </div>

                        <?php else: ?>

                            <div class="provider-review-empty">

                                <i class="bi bi-chat-square-heart"></i>

                                <p>
                                    The service has been completed.
                                    The customer has not submitted a review yet.
                                </p>

                            </div>

                        <?php endif; ?>

                    </div>

                <?php endif; ?>

            </div>

            <!-- BOOKING ACTIONS -->
            <div class="col-lg-4">

                <div class="dashboard-card p-4">

                    <span class="section-eyebrow">
                        BOOKING ACTIONS
                    </span>

                    <h2 class="mb-3">Manage request</h2>

                    <?php if ($booking['status'] === 'pending'): ?>

                        <p class="text-muted">
                            Review this request and decide whether
                            you can provide the requested service.
                        </p>

                        <form
                            method="POST"
                            action="<?= APP_URL ?>/provider/bookings/update-status"
                            class="mb-3"
                        >

                            <input
                                type="hidden"
                                name="csrf_token"
                                value="<?= providerBookingEscape($csrfToken) ?>"
                            >

                            <input
                                type="hidden"
                                name="booking_id"
                                value="<?= (int) $booking['id'] ?>"
                            >

                            <input
                                type="hidden"
                                name="status"
                                value="accepted"
                            >

                            <button
                                type="submit"
                                class="btn btn-primary w-100"
                            >
                                <i class="bi bi-check-circle me-2"></i>
                                Accept Booking
                            </button>

                        </form>

                        <form
                            method="POST"
                            action="<?= APP_URL ?>/provider/bookings/update-status"
                        >

                            <input
                                type="hidden"
                                name="csrf_token"
                                value="<?= providerBookingEscape($csrfToken) ?>"
                            >

                            <input
                                type="hidden"
                                name="booking_id"
                                value="<?= (int) $booking['id'] ?>"
                            >

                            <input
                                type="hidden"
                                name="status"
                                value="rejected"
                            >

                            <button
                                type="submit"
                                class="btn btn-outline-danger w-100"
                            >
                                <i class="bi bi-x-circle me-2"></i>
                                Reject Booking
                            </button>

                        </form>

                    <?php elseif ($booking['status'] === 'accepted'): ?>

                        <p class="text-muted">
                            You have accepted this booking.
                            Once you begin the service, update its status.
                        </p>

                        <form
                            method="POST"
                            action="<?= APP_URL ?>/provider/bookings/update-status"
                        >

                            <input
                                type="hidden"
                                name="csrf_token"
                                value="<?= providerBookingEscape($csrfToken) ?>"
                            >

                            <input
                                type="hidden"
                                name="booking_id"
                                value="<?= (int) $booking['id'] ?>"
                            >

                            <input
                                type="hidden"
                                name="status"
                                value="in_progress"
                            >

                            <button
                                type="submit"
                                class="btn btn-primary w-100"
                            >
                                <i class="bi bi-play-circle me-2"></i>
                                Start Service
                            </button>

                        </form>

                    <?php elseif ($booking['status'] === 'in_progress'): ?>

                        <p class="text-muted">
                            This service is currently in progress.
                            Mark it as completed once the work is finished.
                        </p>

                        <form
                            method="POST"
                            action="<?= APP_URL ?>/provider/bookings/update-status"
                        >

                            <input
                                type="hidden"
                                name="csrf_token"
                                value="<?= providerBookingEscape($csrfToken) ?>"
                            >

                            <input
                                type="hidden"
                                name="booking_id"
                                value="<?= (int) $booking['id'] ?>"
                            >

                            <input
                                type="hidden"
                                name="status"
                                value="completed"
                            >

                            <button
                                type="submit"
                                class="btn btn-success w-100"
                            >
                                <i class="bi bi-check-circle me-2"></i>
                                Complete Service
                            </button>

                        </form>

                    <?php elseif ($booking['status'] === 'completed'): ?>

                        <div class="alert alert-success mb-0">
                            <i class="bi bi-check-circle me-2"></i>
                            This booking has been completed successfully.
                        </div>

                    <?php elseif ($booking['status'] === 'rejected'): ?>

                        <div class="alert alert-danger mb-0">
                            This booking has been rejected.
                        </div>

                    <?php elseif ($booking['status'] === 'cancelled'): ?>

                        <div class="alert alert-secondary mb-0">
                            This booking has been cancelled.
                        </div>

                    <?php endif; ?>

                </div>

                <div class="mt-3">

                    <a
                        href="<?= APP_URL ?>/provider/bookings"
                        class="activity-explore-link"
                    >
                        <i class="bi bi-arrow-left"></i>
                        Back to Bookings
                    </a>

                </div>

            </div>

        </div>

    </div>

</section>

<?php require APP_ROOT . '/app/views/layouts/footer.php'; ?>
