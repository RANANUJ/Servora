
<?php

require APP_ROOT . '/app/views/layouts/header.php';

if (!function_exists('bookingEscape')) {
    function bookingEscape($value)
    {
        return htmlspecialchars(
            (string) ($value ?? ''),
            ENT_QUOTES,
            'UTF-8'
        );
    }
}

// Booking statistics
$totalBookings = count($bookings);
$pendingBookings = 0;
$activeBookings = 0;
$completedBookings = 0;

foreach ($bookings as $booking) {

    if ($booking['status'] === 'pending') {
        $pendingBookings++;
    }

    if (
        $booking['status'] === 'accepted' ||
        $booking['status'] === 'in_progress'
    ) {
        $activeBookings++;
    }

    if ($booking['status'] === 'completed') {
        $completedBookings++;
    }
}

$statusLabels = [
    'pending' => 'Pending',
    'accepted' => 'Accepted',
    'rejected' => 'Rejected',
    'in_progress' => 'In Progress',
    'completed' => 'Completed',
    'cancelled' => 'Cancelled'
];

?>

<style>

/* ======================================
   PROVIDER BOOKINGS PAGE
====================================== */

.provider-bookings-page {
    background: #F6F8FC;
    padding: 55px 0 75px;
    min-height: 650px;
    color: #17243A;
}

.provider-bookings-page * {
    box-sizing: border-box;
}

/* Page heading */

.provider-bookings-page .pbl-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 20px;
    margin-bottom: 32px;
}

.provider-bookings-page .pbl-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: #2457D6;
    font-size: 11px;
    font-weight: 800;
    letter-spacing: 1.3px;
    margin-bottom: 12px;
}

.provider-bookings-page .pbl-header h1 {
    color: #17243A;
    font-size: 32px;
    font-weight: 800;
    margin: 0 0 9px;
}

.provider-bookings-page .pbl-header p {
    color: #64748B;
    font-size: 14px;
    margin: 0;
}

.provider-bookings-page .pbl-active-label {
    display: inline-flex;
    align-items: center;
    gap: 9px;
    background: #EAF8F0;
    color: #198754;
    padding: 10px 15px;
    border-radius: 30px;
    font-size: 12px;
    font-weight: 700;
    white-space: nowrap;
}

.provider-bookings-page .pbl-active-dot {
    width: 8px;
    height: 8px;
    background: #198754;
    border-radius: 50%;
}

/* Statistics */

.provider-bookings-page .pbl-stat-card {
    background: #FFFFFF;
    border: 1px solid #E8EDF5;
    border-radius: 15px;
    padding: 22px;
    height: 100%;
    box-shadow: 0 8px 28px rgba(23, 36, 58, 0.04);
}

.provider-bookings-page .pbl-stat-top {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 10px;
}

.provider-bookings-page .pbl-stat-label {
    color: #8491A4;
    font-size: 10px;
    font-weight: 800;
    letter-spacing: 1px;
}

.provider-bookings-page .pbl-stat-icon {
    width: 38px;
    height: 38px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 11px;
    font-size: 17px;
}

.provider-bookings-page .pbl-stat-icon.blue {
    color: #2457D6;
    background: #EEF3FF;
}

.provider-bookings-page .pbl-stat-icon.orange {
    color: #C98218;
    background: #FFF4DF;
}

.provider-bookings-page .pbl-stat-icon.cyan {
    color: #087C9E;
    background: #E5F6FC;
}

.provider-bookings-page .pbl-stat-icon.green {
    color: #198754;
    background: #E8F7EF;
}

.provider-bookings-page .pbl-stat-number {
    display: block;
    color: #17243A;
    font-size: 29px;
    font-weight: 800;
    margin-top: 13px;
}

/* Main list panel */

.provider-bookings-page .pbl-list-panel {
    background: #FFFFFF;
    border: 1px solid #E8EDF5;
    border-radius: 17px;
    padding: 27px;
    margin-top: 30px;
    box-shadow: 0 8px 28px rgba(23, 36, 58, 0.045);
}

.provider-bookings-page .pbl-list-heading {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 15px;
    margin-bottom: 25px;
}

.provider-bookings-page .pbl-section-label {
    display: block;
    color: #8A96A8;
    font-size: 10px;
    font-weight: 800;
    letter-spacing: 1.2px;
    margin-bottom: 8px;
}

.provider-bookings-page .pbl-list-heading h2 {
    color: #17243A;
    font-size: 20px;
    font-weight: 750;
    margin: 0;
}

.provider-bookings-page .pbl-total-label {
    background: #EEF3FF;
    color: #2457D6;
    border-radius: 30px;
    padding: 8px 13px;
    font-size: 11px;
    font-weight: 750;
    white-space: nowrap;
}

/* Booking cards */

.provider-bookings-page .pbl-booking-card {
    border: 1px solid #E8EDF5;
    border-radius: 14px;
    padding: 21px;
    margin-bottom: 16px;
    transition: border-color 0.2s ease, box-shadow 0.2s ease;
}

.provider-bookings-page .pbl-booking-card:last-child {
    margin-bottom: 0;
}

.provider-bookings-page .pbl-booking-card:hover {
    border-color: #C8D6F7;
    box-shadow: 0 8px 22px rgba(23, 36, 58, 0.055);
}

.provider-bookings-page .pbl-booking-top {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 15px;
    margin-bottom: 20px;
}

.provider-bookings-page .pbl-booking-reference {
    color: #2457D6;
    font-size: 11px;
    font-weight: 800;
    letter-spacing: 0.5px;
    margin-bottom: 6px;
}

.provider-bookings-page .pbl-service-title {
    color: #17243A;
    font-size: 17px;
    font-weight: 750;
    margin: 0;
    overflow-wrap: anywhere;
}

/* Status badges */

.provider-bookings-page .pbl-status {
    display: inline-flex;
    align-items: center;
    padding: 7px 12px;
    border-radius: 30px;
    font-size: 10px;
    font-weight: 750;
    white-space: nowrap;
}

.provider-bookings-page .pbl-status.pending {
    background: #FFF4DC;
    color: #A66B00;
}

.provider-bookings-page .pbl-status.accepted {
    background: #EAF0FF;
    color: #2457D6;
}

.provider-bookings-page .pbl-status.rejected,
.provider-bookings-page .pbl-status.cancelled {
    background: #FDECEC;
    color: #C43D3D;
}

.provider-bookings-page .pbl-status.in_progress {
    background: #E5F6FC;
    color: #087C9E;
}

.provider-bookings-page .pbl-status.completed {
    background: #E8F7EF;
    color: #198754;
}

/* Customer and appointment information */

.provider-bookings-page .pbl-booking-information {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 18px;
    padding: 17px 0;
    border-top: 1px solid #EDF0F5;
    border-bottom: 1px solid #EDF0F5;
}

.provider-bookings-page .pbl-info-item {
    display: flex;
    align-items: flex-start;
    gap: 11px;
    min-width: 0;
}

.provider-bookings-page .pbl-info-icon {
    width: 35px;
    height: 35px;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 10px;
    background: #F0F4FF;
    color: #2457D6;
    font-size: 15px;
}

.provider-bookings-page .pbl-info-item div:last-child {
    min-width: 0;
}

.provider-bookings-page .pbl-info-item span {
    display: block;
    color: #8A96A8;
    font-size: 11px;
    margin-bottom: 5px;
}

.provider-bookings-page .pbl-info-item strong {
    display: block;
    color: #34445C;
    font-size: 12px;
    font-weight: 700;
    overflow-wrap: anywhere;
}

/* Booking footer */

.provider-bookings-page .pbl-booking-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 15px;
    padding-top: 17px;
}

.provider-bookings-page .pbl-amount-label {
    display: block;
    color: #8A96A8;
    font-size: 11px;
    margin-bottom: 4px;
}

.provider-bookings-page .pbl-amount {
    color: #17243A;
    font-size: 18px;
    font-weight: 800;
}

.provider-bookings-page .pbl-view-button {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    background: #2457D6;
    color: #FFFFFF;
    text-decoration: none;
    border-radius: 9px;
    padding: 11px 16px;
    font-size: 12px;
    font-weight: 700;
    transition: all 0.2s ease;
}

.provider-bookings-page .pbl-view-button:hover {
    background: #1744B5;
    color: #FFFFFF;
    transform: translateY(-2px);
}

/* Empty state */

.provider-bookings-page .pbl-empty-state {
    text-align: center;
    padding: 55px 20px;
}

.provider-bookings-page .pbl-empty-icon {
    width: 75px;
    height: 75px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
    background: #EEF3FF;
    color: #2457D6;
    border-radius: 22px;
    font-size: 30px;
}

.provider-bookings-page .pbl-empty-state h3 {
    color: #17243A;
    font-size: 20px;
    font-weight: 750;
    margin-bottom: 10px;
}

.provider-bookings-page .pbl-empty-state p {
    color: #8491A4;
    font-size: 13px;
    line-height: 1.7;
    max-width: 430px;
    margin: 0 auto 20px;
}

/* Back link */

.provider-bookings-page .pbl-back-link {
    display: inline-flex;
    align-items: center;
    gap: 9px;
    color: #2457D6;
    text-decoration: none;
    font-size: 13px;
    font-weight: 700;
    margin-top: 24px;
}

.provider-bookings-page .pbl-back-link:hover {
    color: #1744B5;
}

/* Alerts */

.provider-bookings-page .pbl-alert {
    border-radius: 11px;
    margin-bottom: 20px;
}

/* Responsive */

@media (max-width: 991px) {
    .provider-bookings-page {
        padding: 40px 0 55px;
    }

    .provider-bookings-page .pbl-booking-information {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
}

@media (max-width: 576px) {
    .provider-bookings-page {
        padding: 30px 0 45px;
    }

    .provider-bookings-page .pbl-header {
        flex-direction: column;
    }

    .provider-bookings-page .pbl-header h1 {
        font-size: 26px;
    }

    .provider-bookings-page .pbl-list-panel {
        padding: 17px;
    }

    .provider-bookings-page .pbl-list-heading h2 {
        font-size: 17px;
    }

    .provider-bookings-page .pbl-booking-card {
        padding: 16px;
    }

    .provider-bookings-page .pbl-booking-information {
        grid-template-columns: 1fr;
        gap: 15px;
    }

    .provider-bookings-page .pbl-booking-top {
        flex-direction: column;
    }

    .provider-bookings-page .pbl-booking-footer {
        align-items: flex-start;
    }

    .provider-bookings-page .pbl-view-button {
        padding: 10px 12px;
        font-size: 11px;
    }

    .provider-bookings-page .pbl-stat-card {
        padding: 16px;
    }

    .provider-bookings-page .pbl-stat-number {
        font-size: 25px;
    }
}

</style>


<section class="provider-bookings-page">

    <div class="container">

        <!-- PAGE HEADER -->
        <div class="pbl-header">

            <div>

                <span class="pbl-eyebrow">
                    <i class="bi bi-calendar-check"></i>
                    PROVIDER DASHBOARD
                </span>

                <h1>Customer Bookings</h1>

                <p>
                    Manage customer requests and keep track of your appointments.
                </p>

            </div>

            <div class="pbl-active-label">
                <span class="pbl-active-dot"></span>
                Provider Active
            </div>

        </div>


        <!-- ALERT MESSAGES -->
        <?php if (!empty($bookingMessage)): ?>

            <div class="alert alert-success pbl-alert">
                <?= bookingEscape($bookingMessage) ?>
            </div>

        <?php endif; ?>


        <?php if (!empty($bookingError)): ?>

            <div class="alert alert-danger pbl-alert">
                <?= bookingEscape($bookingError) ?>
            </div>

        <?php endif; ?>


        <!-- BOOKING STATISTICS -->
        <div class="row g-3">

            <div class="col-lg-3 col-6">
                <div class="pbl-stat-card">

                    <div class="pbl-stat-top">
                        <span class="pbl-stat-label">TOTAL BOOKINGS</span>

                        <span class="pbl-stat-icon blue">
                            <i class="bi bi-calendar2-week"></i>
                        </span>
                    </div>

                    <span class="pbl-stat-number">
                        <?= $totalBookings ?>
                    </span>

                </div>
            </div>


            <div class="col-lg-3 col-6">
                <div class="pbl-stat-card">

                    <div class="pbl-stat-top">
                        <span class="pbl-stat-label">PENDING</span>

                        <span class="pbl-stat-icon orange">
                            <i class="bi bi-hourglass-split"></i>
                        </span>
                    </div>

                    <span class="pbl-stat-number">
                        <?= $pendingBookings ?>
                    </span>

                </div>
            </div>


            <div class="col-lg-3 col-6">
                <div class="pbl-stat-card">

                    <div class="pbl-stat-top">
                        <span class="pbl-stat-label">ACTIVE</span>

                        <span class="pbl-stat-icon cyan">
                            <i class="bi bi-activity"></i>
                        </span>
                    </div>

                    <span class="pbl-stat-number">
                        <?= $activeBookings ?>
                    </span>

                </div>
            </div>


            <div class="col-lg-3 col-6">
                <div class="pbl-stat-card">

                    <div class="pbl-stat-top">
                        <span class="pbl-stat-label">COMPLETED</span>

                        <span class="pbl-stat-icon green">
                            <i class="bi bi-check-circle"></i>
                        </span>
                    </div>

                    <span class="pbl-stat-number">
                        <?= $completedBookings ?>
                    </span>

                </div>
            </div>

        </div>


        <!-- BOOKINGS LIST -->
        <div class="pbl-list-panel">

            <div class="pbl-list-heading">

                <div>
                    <span class="pbl-section-label">
                        BOOKING MANAGEMENT
                    </span>

                    <h2>All Customer Requests</h2>
                </div>

                <span class="pbl-total-label">
                    <?= $totalBookings ?> Bookings
                </span>

            </div>


            <?php if (empty($bookings)): ?>

                <!-- EMPTY STATE -->
                <div class="pbl-empty-state">

                    <div class="pbl-empty-icon">
                        <i class="bi bi-calendar-x"></i>
                    </div>

                    <h3>No bookings yet</h3>

                    <p>
                        Customer booking requests will appear here
                        when someone books one of your services.
                    </p>

                    <a
                        href="<?= APP_URL ?>/provider/services"
                        class="btn btn-primary"
                    >
                        <i class="bi bi-tools me-2"></i>
                        View My Services
                    </a>

                </div>

            <?php else: ?>

                <?php foreach ($bookings as $booking): ?>

                    <?php

                    $status = $booking['status'] ?? 'pending';
                    $statusLabel = $statusLabels[$status] ?? ucfirst($status);

                    // Only known status names are used as CSS classes.
                    $allowedStatuses = [
                        'pending',
                        'accepted',
                        'rejected',
                        'in_progress',
                        'completed',
                        'cancelled'
                    ];

                    $statusClass = in_array($status, $allowedStatuses, true)
                        ? $status
                        : 'pending';

                    ?>

                    <article class="pbl-booking-card">

                        <!-- BOOKING HEADING -->
                        <div class="pbl-booking-top">

                            <div>

                                <div class="pbl-booking-reference">
                                    BOOKING #<?= bookingEscape($booking['booking_number']) ?>
                                </div>

                                <h3 class="pbl-service-title">
                                    <?= bookingEscape($booking['service_title']) ?>
                                </h3>

                            </div>

                            <span class="pbl-status <?= bookingEscape($statusClass) ?>">
                                <?= bookingEscape($statusLabel) ?>
                            </span>

                        </div>


                        <!-- BOOKING INFORMATION -->
                        <div class="pbl-booking-information">

                            <div class="pbl-info-item">

                                <div class="pbl-info-icon">
                                    <i class="bi bi-person"></i>
                                </div>

                                <div>
                                    <span>Customer</span>

                                    <strong>
                                        <?= bookingEscape($booking['customer_name']) ?>
                                    </strong>
                                </div>

                            </div>


                            <div class="pbl-info-item">

                                <div class="pbl-info-icon">
                                    <i class="bi bi-calendar-event"></i>
                                </div>

                                <div>
                                    <span>Appointment Date</span>

                                    <strong>
                                        <?= date(
                                            'd M Y',
                                            strtotime($booking['booking_date'])
                                        ) ?>
                                    </strong>
                                </div>

                            </div>


                            <div class="pbl-info-item">

                                <div class="pbl-info-icon">
                                    <i class="bi bi-clock"></i>
                                </div>

                                <div>
                                    <span>Appointment Time</span>

                                    <strong>
                                        <?= date(
                                            'h:i A',
                                            strtotime($booking['booking_time'])
                                        ) ?>
                                    </strong>
                                </div>

                            </div>

                        </div>


                        <!-- BOOKING FOOTER -->
                        <div class="pbl-booking-footer">

                            <div>
                                <span class="pbl-amount-label">
                                    Booking Amount
                                </span>

                                <strong class="pbl-amount">
                                    ₹<?= number_format(
                                        (float) $booking['price'],
                                        2
                                    ) ?>
                                </strong>
                            </div>


                            <a
                                href="<?= APP_URL ?>/provider/bookings/details?id=<?= (int) $booking['id'] ?>"
                                class="pbl-view-button"
                            >
                                View Details
                                <i class="bi bi-arrow-right"></i>
                            </a>

                        </div>

                    </article>

                <?php endforeach; ?>

            <?php endif; ?>

        </div>


        <!-- BACK TO DASHBOARD -->
        <a
            href="<?= APP_URL ?>/provider/dashboard"
            class="pbl-back-link"
        >
            <i class="bi bi-arrow-left"></i>
            Back to Provider Dashboard
        </a>

    </div>

</section>


<?php require APP_ROOT . '/app/views/layouts/footer.php'; ?>
