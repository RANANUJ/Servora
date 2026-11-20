
<?php require APP_ROOT . '/app/views/layouts/header.php'; ?>

<?php
$statusLabels = [
    'pending' => 'Pending',
    'accepted' => 'Accepted',
    'rejected' => 'Rejected',
    'in_progress' => 'In Progress',
    'completed' => 'Completed',
    'cancelled' => 'Cancelled'
];

$status = $booking['status'] ?? 'pending';
$statusLabel = $statusLabels[$status] ?? 'Unknown';

$statusClass = match ($status) {
    'pending' => 'pending',
    'accepted' => 'accepted',
    'in_progress' => 'in-progress',
    'completed' => 'completed',
    'rejected', 'cancelled' => 'cancelled',
    default => 'pending'
};

$bookingDate = date('d M Y', strtotime($booking['booking_date']));
$bookingTime = date('h:i A', strtotime($booking['booking_time']));

$serviceImage = !empty($booking['service_image'])
    ? APP_URL . '/uploads/services/' . rawurlencode(basename($booking['service_image']))
    : null;

$e = static function ($value) {
    return htmlspecialchars((string) ($value ?? ''), ENT_QUOTES, 'UTF-8');
};

$steps = [
    'pending' => 1,
    'accepted' => 2,
    'in_progress' => 3,
    'completed' => 4
];

$currentStep = $steps[$status] ?? 0;
?>

<style>
.booking-details-page {
    background: var(--light);
    min-height: 100vh;
    padding: 45px 0 70px;
}

.booking-page-header {
    margin-bottom: 28px;
}

.booking-back-link {
    display: inline-flex;
    align-items: center;
    gap: 9px;
    color: var(--text);
    text-decoration: none;
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 25px;
}

.booking-back-link:hover {
    color: var(--primary);
}

.booking-heading {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 20px;
}

.booking-eyebrow {
    color: var(--primary);
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 1.5px;
}

.booking-heading h1 {
    color: var(--dark);
    font-size: 32px;
    font-weight: 700;
    margin: 8px 0;
}

.booking-heading p {
    color: var(--text);
    font-size: 14px;
    margin: 0;
}

.booking-status {
    display: inline-flex;
    justify-content: center;
    padding: 9px 17px;
    border-radius: 30px;
    font-size: 12px;
    font-weight: 700;
    white-space: nowrap;
}

.booking-status.pending {
    background: #FFF3D9;
    color: #A66B00;
}

.booking-status.accepted {
    background: #E6F0FF;
    color: #2457D6;
}

.booking-status.in-progress {
    background: #EDE9FF;
    color: #7045C5;
}

.booking-status.completed {
    background: #E3F7EC;
    color: #16834A;
}

.booking-status.cancelled {
    background: #FDE8E8;
    color: #C43D3D;
}

.booking-number-card {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: 14px;
    padding: 20px 24px;
    margin-bottom: 25px;
    box-shadow: var(--shadow);
}

.booking-number-card span {
    color: var(--text);
    font-size: 12px;
    font-weight: 600;
}

.booking-number-card h3 {
    color: var(--dark);
    font-size: 19px;
    font-weight: 700;
    margin: 7px 0 0;
}

.booking-reference-icon,
.booking-heading-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    background: #EDF3FF;
    color: var(--primary);
    border-radius: 12px;
}

.booking-reference-icon {
    width: 48px;
    height: 48px;
    font-size: 21px;
}

.booking-heading-icon {
    width: 38px;
    height: 38px;
    font-size: 17px;
}

.booking-info-card,
.booking-summary-card {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: 15px;
    padding: 25px;
    margin-bottom: 22px;
    box-shadow: var(--shadow);
}

.booking-card-heading {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 23px;
}

.booking-card-heading h3 {
    color: var(--dark);
    font-size: 17px;
    font-weight: 700;
    margin: 0;
}

.booking-service-info {
    display: flex;
    align-items: center;
    gap: 20px;
}

.booking-service-image,
.booking-service-placeholder {
    width: 115px;
    height: 105px;
    flex-shrink: 0;
    border-radius: 12px;
    object-fit: cover;
}

.booking-service-placeholder {
    display: flex;
    align-items: center;
    justify-content: center;
    background: #EDF3FF;
    color: var(--primary);
    font-size: 30px;
}

.booking-small-label {
    color: var(--text);
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 1px;
}

.booking-service-info h2 {
    color: var(--dark);
    font-size: 19px;
    font-weight: 700;
    margin: 7px 0 10px;
}

.booking-service-info p {
    color: var(--text);
    font-size: 13px;
    margin: 5px 0;
}

.booking-service-info p i {
    color: var(--primary);
    margin-right: 6px;
}

.booking-detail-item {
    padding: 16px;
    background: #F8FAFD;
    border: 1px solid var(--border);
    border-radius: 11px;
}

.booking-detail-item span {
    display: block;
    color: var(--text);
    font-size: 12px;
    margin-bottom: 9px;
}

.booking-detail-item span i {
    color: var(--primary);
    margin-right: 5px;
}

.booking-detail-item strong {
    color: var(--dark);
    font-size: 15px;
}

.booking-address {
    display: flex;
    align-items: flex-start;
    gap: 15px;
}

.booking-address > i {
    color: var(--primary);
    font-size: 23px;
}

.booking-address strong {
    display: block;
    color: var(--dark);
    font-size: 14px;
    margin-bottom: 8px;
}

.booking-address p {
    color: var(--text);
    font-size: 13px;
    line-height: 1.7;
    margin: 0 0 3px;
}

.booking-customer-message {
    background: #F8FAFD;
    border: 1px solid var(--border);
    border-radius: 10px;
    padding: 16px;
    color: var(--text);
    font-size: 14px;
    line-height: 1.7;
}

.booking-progress {
    display: flex;
    justify-content: space-between;
    position: relative;
    gap: 10px;
    margin: 30px 0 20px;
}

.booking-progress::before {
    content: "";
    position: absolute;
    top: 19px;
    left: 10%;
    right: 10%;
    height: 3px;
    background: var(--border);
}

.booking-progress-step {
    position: relative;
    z-index: 1;
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 10px;
    text-align: center;
}

.booking-progress-icon {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #EDF0F5;
    color: #8994A5;
    border: 3px solid var(--white);
    border-radius: 50%;
}

.booking-progress-step.active .booking-progress-icon {
    background: var(--primary);
    color: white;
}

.booking-progress-step span {
    color: var(--text);
    font-size: 11px;
    font-weight: 600;
}

.booking-progress-step.active span {
    color: var(--primary);
}

.booking-progress-note {
    background: #F5F8FF;
    color: var(--text);
    padding: 13px 15px;
    border-radius: 9px;
    font-size: 12px;
    line-height: 1.6;
    margin: 20px 0 0;
}

.booking-terminal-message {
    display: flex;
    gap: 13px;
    background: #FFF1F1;
    border: 1px solid #F8DADA;
    padding: 17px;
    border-radius: 11px;
}

.booking-terminal-message > i {
    color: #C43D3D;
    font-size: 21px;
}

.booking-terminal-message strong {
    color: #A52E2E;
    font-size: 14px;
}

.booking-terminal-message p {
    color: var(--text);
    font-size: 13px;
    margin: 6px 0 0;
}

.booking-summary-header {
    display: flex;
    justify-content: space-between;
    color: var(--text);
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 1px;
}

.booking-summary-header i {
    color: var(--primary);
    font-size: 20px;
}

.booking-price {
    margin: 25px 0;
}

.booking-price span,
.booking-total-row span {
    color: var(--text);
    font-size: 13px;
}

.booking-price h2 {
    color: var(--dark);
    font-size: 30px;
    font-weight: 700;
    margin: 8px 0 0;
}

.booking-summary-divider {
    height: 1px;
    background: var(--border);
    margin: 20px 0;
}

.booking-summary-row,
.booking-total-row {
    display: flex;
    justify-content: space-between;
    gap: 12px;
    margin: 15px 0;
}

.booking-summary-row span {
    color: var(--text);
    font-size: 12px;
}

.booking-summary-row strong {
    color: var(--dark);
    font-size: 12px;
    text-align: right;
}

.booking-total-row strong {
    color: var(--primary);
    font-size: 19px;
}

.booking-payment-note {
    display: flex;
    gap: 8px;
    color: var(--text);
    font-size: 11px;
    line-height: 1.6;
    margin: 20px 0 0;
}

.booking-help-card {
    background: var(--dark);
    border-radius: 15px;
    padding: 25px;
    color: white;
}

.booking-help-icon {
    width: 43px;
    height: 43px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(255,255,255,.12);
    color: #FFB45F;
    border-radius: 11px;
    font-size: 20px;
    margin-bottom: 17px;
}

.booking-help-card h3 {
    color: white;
    font-size: 17px;
    font-weight: 700;
}

.booking-help-card p {
    color: #C3CDDC;
    font-size: 12px;
    line-height: 1.7;
}

.booking-help-link {
    display: inline-flex;
    gap: 9px;
    color: #FFB45F;
    font-size: 13px;
    font-weight: 700;
    text-decoration: none;
}

.booking-help-link:hover {
    color: white;
}

/* CUSTOMER REVIEW SECTION */

.booking-review-card {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: 15px;
    padding: 25px;
    margin-bottom: 22px;
    box-shadow: var(--shadow);
}

.booking-review-card h3 {
    color: var(--dark);
    font-size: 18px;
    font-weight: 700;
    margin-bottom: 8px;
}

.booking-review-description {
    color: var(--text);
    font-size: 13px;
    margin-bottom: 22px;
}

.booking-review-stars {
    display: flex;
    flex-direction: row-reverse;
    justify-content: flex-end;
    gap: 7px;
    margin: 12px 0 20px;
}

.booking-review-stars input {
    position: absolute;
    opacity: 0;
    pointer-events: none;
}

.booking-review-stars label {
    color: #D5DCE7;
    font-size: 32px;
    cursor: pointer;
    transition: color .2s ease;
}

.booking-review-stars label:hover,
.booking-review-stars label:hover ~ label,
.booking-review-stars input:checked ~ label {
    color: #F5A623;
}

.booking-review-stars input:focus-visible + label {
    outline: 2px solid var(--primary);
    outline-offset: 3px;
    border-radius: 4px;
}

.booking-review-card textarea {
    width: 100%;
    min-height: 125px;
    padding: 14px;
    border: 1px solid var(--border);
    border-radius: 10px;
    outline: none;
    resize: vertical;
    font-size: 14px;
    color: var(--dark);
}

.booking-review-card textarea:focus {
    border-color: var(--primary);
}

.booking-review-submit {
    border: none;
    background: var(--primary);
    color: white;
    padding: 12px 23px;
    border-radius: 9px;
    font-weight: 600;
    margin-top: 16px;
    transition: background .2s ease;
}

.booking-review-submit:hover {
    background: var(--primary-dark);
}

.booking-review-alert {
    padding: 13px 15px;
    border-radius: 9px;
    font-size: 13px;
    margin-bottom: 18px;
}

.booking-review-alert.success {
    background: #E3F7EC;
    color: #16834A;
}

.booking-review-alert.error {
    background: #FDE8E8;
    color: #C43D3D;
}

.booking-review-existing-stars {
    color: #F5A623;
    font-size: 23px;
    letter-spacing: 2px;
    margin: 12px 0;
}

.booking-review-existing-comment {
    background: #F8FAFD;
    padding: 16px;
    border-radius: 10px;
    color: var(--text);
    font-size: 14px;
    line-height: 1.7;
}

.booking-review-customer {
    color: var(--dark);
    font-size: 13px;
    font-weight: 600;
    margin-bottom: 10px;
}

@media (max-width: 767px) {
    .booking-details-page {
        padding: 30px 0 45px;
    }

    .booking-heading {
        align-items: flex-start;
        flex-direction: column;
    }

    .booking-heading h1 {
        font-size: 26px;
    }

    .booking-number-card {
        padding: 17px;
    }

    .booking-number-card h3 {
        font-size: 16px;
    }

    .booking-info-card,
    .booking-summary-card,
    .booking-review-card {
        padding: 19px;
    }

    .booking-service-info {
        align-items: flex-start;
        gap: 13px;
    }

    .booking-service-image,
    .booking-service-placeholder {
        width: 90px;
        height: 90px;
    }

    .booking-service-info h2 {
        font-size: 16px;
    }

    .booking-progress {
        gap: 3px;
    }

    .booking-progress-step span {
        font-size: 9px;
    }

    .booking-progress-icon {
        width: 35px;
        height: 35px;
        font-size: 13px;
    }

    .booking-progress::before {
        top: 16px;
    }
}
</style>

<div class="booking-details-page">
    <div class="container">

        <div class="booking-page-header">

            <a href="<?= APP_URL ?>/dashboard#myServiceRequests" class="booking-back-link">
                <i class="bi bi-arrow-left"></i>
                Back to My Bookings
            </a>

            <div class="booking-heading">

                <div>
                    <span class="booking-eyebrow">BOOKING INFORMATION</span>
                    <h1>Booking Details</h1>
                    <p>View your service request and appointment information.</p>
                </div>

                <span class="booking-status <?= $e($statusClass) ?>">
                    <?= $e($statusLabel) ?>
                </span>

            </div>

        </div>

        <div class="booking-number-card">

            <div>
                <span>Booking Reference</span>
                <h3><?= $e($booking['booking_number']) ?></h3>
            </div>

            <div class="booking-reference-icon">
                <i class="bi bi-receipt"></i>
            </div>

        </div>

        <div class="row g-4">

            <div class="col-lg-8">

                <!-- SERVICE INFORMATION -->

                <div class="booking-info-card">

                    <div class="booking-card-heading">
                        <h3>Service Information</h3>

                        <span class="booking-heading-icon">
                            <i class="bi bi-tools"></i>
                        </span>
                    </div>

                    <div class="booking-service-info">

                        <?php if ($serviceImage): ?>

                            <img
                                src="<?= $e($serviceImage) ?>"
                                alt="<?= $e($booking['service_title']) ?>"
                                class="booking-service-image"
                            >

                        <?php else: ?>

                            <div class="booking-service-placeholder">
                                <i class="bi bi-tools"></i>
                            </div>

                        <?php endif; ?>

                        <div>

                            <span class="booking-small-label">
                                BOOKED SERVICE
                            </span>

                            <h2><?= $e($booking['service_title']) ?></h2>

                            <p>
                                <i class="bi bi-building"></i>
                                <?= $e($booking['business_name']) ?>
                            </p>

                            <p>
                                <i class="bi bi-person"></i>
                                <?= $e($booking['provider_name']) ?>
                            </p>

                        </div>

                    </div>

                </div>

                <!-- APPOINTMENT INFORMATION -->

                <div class="booking-info-card">

                    <div class="booking-card-heading">
                        <h3>Appointment Information</h3>

                        <span class="booking-heading-icon">
                            <i class="bi bi-calendar-check"></i>
                        </span>
                    </div>

                    <div class="row g-4">

                        <div class="col-md-6">

                            <div class="booking-detail-item">

                                <span>
                                    <i class="bi bi-calendar3"></i>
                                    Appointment Date
                                </span>

                                <strong><?= $e($bookingDate) ?></strong>

                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="booking-detail-item">

                                <span>
                                    <i class="bi bi-clock"></i>
                                    Appointment Time
                                </span>

                                <strong><?= $e($bookingTime) ?></strong>

                            </div>

                        </div>

                    </div>

                </div>

                <!-- SERVICE LOCATION -->

                <div class="booking-info-card">

                    <div class="booking-card-heading">
                        <h3>Service Location</h3>

                        <span class="booking-heading-icon">
                            <i class="bi bi-geo-alt"></i>
                        </span>
                    </div>

                    <div class="booking-address">

                        <i class="bi bi-geo-alt-fill"></i>

                        <div>

                            <strong>Service Address</strong>

                            <p>
                                <?= nl2br($e($booking['service_address'])) ?>
                            </p>

                            <p>
                                <?= $e($booking['city']) ?>
                                -
                                <?= $e($booking['pincode']) ?>
                            </p>

                        </div>

                    </div>

                </div>

                <!-- CUSTOMER MESSAGE -->

                <?php if (!empty($booking['customer_message'])): ?>

                    <div class="booking-info-card">

                        <div class="booking-card-heading">
                            <h3>Your Message</h3>

                            <span class="booking-heading-icon">
                                <i class="bi bi-chat-left-text"></i>
                            </span>
                        </div>

                        <p class="booking-customer-message">
                            <?= nl2br($e($booking['customer_message'])) ?>
                        </p>

                    </div>

                <?php endif; ?>

                <!-- BOOKING PROGRESS -->

                <div class="booking-info-card">

                    <div class="booking-card-heading">
                        <h3>Booking Progress</h3>
                    </div>

                    <?php if (in_array($status, ['rejected', 'cancelled'], true)): ?>

                        <div class="booking-terminal-message">

                            <i class="bi bi-exclamation-circle"></i>

                            <div>

                                <strong>
                                    Booking <?= $e($statusLabel) ?>
                                </strong>

                                <p>
                                    <?= $status === 'rejected'
                                        ? 'The service provider has rejected this booking request.'
                                        : 'This booking has been cancelled.' ?>
                                </p>

                            </div>

                        </div>

                    <?php else: ?>

                        <?php
                        $progressSteps = [
                            1 => [
                                'title' => 'Requested',
                                'icon' => 'bi-send'
                            ],
                            2 => [
                                'title' => 'Accepted',
                                'icon' => 'bi-check-circle'
                            ],
                            3 => [
                                'title' => 'In Progress',
                                'icon' => 'bi-tools'
                            ],
                            4 => [
                                'title' => 'Completed',
                                'icon' => 'bi-flag'
                            ]
                        ];
                        ?>

                        <div class="booking-progress">

                            <?php foreach ($progressSteps as $number => $step): ?>

                                <div class="booking-progress-step <?= $number <= $currentStep ? 'active' : '' ?>">

                                    <div class="booking-progress-icon">
                                        <i class="bi <?= $e($step['icon']) ?>"></i>
                                    </div>

                                    <span>
                                        <?= $e($step['title']) ?>
                                    </span>

                                </div>

                            <?php endforeach; ?>

                        </div>

                        <p class="booking-progress-note">

                            <?= match ($status) {
                                'pending' => 'Your request has been submitted and is waiting for the provider.',
                                'accepted' => 'Your booking has been accepted by the provider.',
                                'in_progress' => 'Your service is currently in progress.',
                                'completed' => 'Your service has been successfully completed.',
                                default => ''
                            } ?>

                        </p>

                    <?php endif; ?>

                </div>

                <!-- CUSTOMER REVIEW SECTION -->

                <?php if ($status === 'completed'): ?>

                    <div class="booking-review-card">

                        <?php if (!empty($reviewSuccess)): ?>

                            <div class="booking-review-alert success">
                                <i class="bi bi-check-circle-fill"></i>
                                <?= $e($reviewSuccess) ?>
                            </div>

                        <?php endif; ?>

                        <?php if (!empty($reviewError)): ?>

                            <div class="booking-review-alert error">
                                <i class="bi bi-exclamation-circle-fill"></i>
                                <?= $e($reviewError) ?>
                            </div>

                        <?php endif; ?>

                        <?php if (!empty($review)): ?>

                            <!-- EXISTING REVIEW -->

                            <h3>
                                <i class="bi bi-star-fill text-warning"></i>
                                Your Review
                            </h3>

                            <p class="booking-review-description">
                                Thank you for sharing your experience!
                            </p>

                            <div
                                class="booking-review-existing-stars"
                                aria-label="<?= (int) $review['rating'] ?> out of 5 stars"
                            >

                                <?php for ($i = 1; $i <= 5; $i++): ?>

                                    <?= $i <= (int) $review['rating'] ? '★' : '☆' ?>

                                <?php endfor; ?>

                            </div>

                            <p class="booking-review-customer">
                                <?= $e($review['customer_name'] ?? 'You') ?>
                            </p>

                            <div class="booking-review-existing-comment">
                                <?= nl2br($e($review['comment'])) ?>
                            </div>

                        <?php else: ?>

                            <!-- NEW REVIEW FORM -->

                            <h3>
                                <i class="bi bi-star-fill text-warning"></i>
                                Rate Your Experience
                            </h3>

                            <p class="booking-review-description">
                                Your service is complete! Share your experience
                                to help other customers choose the right service.
                            </p>

                            <form
                                method="POST"
                                action="<?= APP_URL ?>/booking/review"
                            >

                                <input
                                    type="hidden"
                                    name="csrf_token"
                                    value="<?= $e($csrfToken ?? '') ?>"
                                >

                                <input
                                    type="hidden"
                                    name="booking_number"
                                    value="<?= $e($booking['booking_number']) ?>"
                                >

                                <label class="form-label fw-semibold">
                                    How would you rate this service?
                                </label>

                                <div
                                    class="booking-review-stars"
                                    role="radiogroup"
                                    aria-label="Select your rating"
                                >

                                    <?php for ($i = 5; $i >= 1; $i--): ?>

                                        <input
                                            type="radio"
                                            id="booking-star-<?= $i ?>"
                                            name="rating"
                                            value="<?= $i ?>"
                                            required
                                        >

                                        <label
                                            for="booking-star-<?= $i ?>"
                                            title="<?= $i ?> stars"
                                        >
                                            ★
                                        </label>

                                    <?php endfor; ?>

                                </div>

                                <label
                                    for="review-comment"
                                    class="form-label fw-semibold"
                                >
                                    Write Your Review
                                </label>

                                <textarea
                                    id="review-comment"
                                    name="comment"
                                    maxlength="2000"
                                    placeholder="Tell others about your experience with this service..."
                                    required
                                ></textarea>

                                <button
                                    type="submit"
                                    class="booking-review-submit"
                                >
                                    <i class="bi bi-send"></i>
                                    Submit Review
                                </button>

                            </form>

                        <?php endif; ?>

                    </div>

                <?php endif; ?>

            </div>

            <!-- RIGHT COLUMN -->

            <div class="col-lg-4">

                <!-- PAYMENT SUMMARY -->

                <div class="booking-summary-card">

                    <div class="booking-summary-header">

                        <span>PAYMENT SUMMARY</span>

                        <i class="bi bi-wallet2"></i>

                    </div>

                    <div class="booking-price">

                        <span>Service Price</span>

                        <h2>
                            ₹<?= number_format((float) $booking['price'], 2) ?>
                        </h2>

                    </div>

                    <div class="booking-summary-divider"></div>

                    <div class="booking-summary-row">

                        <span>Booking Status</span>

                        <strong><?= $e($statusLabel) ?></strong>

                    </div>

                    <div class="booking-summary-row">

                        <span>Appointment Date</span>

                        <strong><?= $e($bookingDate) ?></strong>

                    </div>

                    <div class="booking-summary-divider"></div>

                    <div class="booking-total-row">

                        <span>Total Amount</span>

                        <strong>
                            ₹<?= number_format((float) $booking['price'], 2) ?>
                        </strong>

                    </div>

                    <p class="booking-payment-note">

                        <i class="bi bi-info-circle"></i>

                        Payment arrangements can be confirmed directly
                        with the service provider.

                    </p>

                </div>

                <!-- SUPPORT CARD -->

                <div class="booking-help-card">

                    <div class="booking-help-icon">
                        <i class="bi bi-headset"></i>
                    </div>

                    <h3>Need Help?</h3>

                    <p>
                        If you have questions about your booking,
                        please contact our support team.
                    </p>

                    <a
                        href="<?= APP_URL ?>/contact"
                        class="booking-help-link"
                    >
                        Contact Support
                        <i class="bi bi-arrow-right"></i>
                    </a>

                </div>

            </div>

        </div>

    </div>
</div>

<?php require APP_ROOT . '/app/views/layouts/footer.php'; ?>
