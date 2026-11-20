
<?php require APP_ROOT . '/app/views/layouts/header.php'; ?>

<?php

$price = '₹' . number_format((float) $service['price'], 2);

if ($service['price_type'] === 'negotiable') {
    $priceLabel = 'Price negotiable';
} elseif ($service['price_type'] === 'starting_from') {
    $priceLabel = 'Starting from ' . $price;
} elseif ($service['price_type'] === 'hourly') {
    $priceLabel = $price . ' / hour';
} else {
    $priceLabel = $price;
}

$serviceImage = '';

if (!empty($service['service_image'])) {
    $serviceImage = APP_URL . '/' . ltrim(
        $service['service_image'],
        '/'
    );
}

$providerImage = '';

if (!empty($service['provider_image'])) {
    $providerImage = APP_URL . '/' . ltrim(
        $service['provider_image'],
        '/'
    );
}

// Retrieve booking error message, if available
$bookingError = $_SESSION['booking_error'] ?? null;

// Remove the message so it appears only once
unset($_SESSION['booking_error']);

// Reviews and rating summary
$reviews = $reviews ?? [];
$ratingSummary = $ratingSummary ?? [];

$averageRating = $ratingSummary['average_rating'] ?? null;
$reviewCount = (int) ($ratingSummary['review_count'] ?? 0);

?>

<style>
.service-details-section {
    background: #F6F8FC;
    padding: 55px 0;
    min-height: 75vh;
}

.service-details-container {
    max-width: 1100px;
}

.service-main-card,
.service-provider-card,
.booking-form-card,
.service-reviews-card {
    background: #FFFFFF;
    border: 1px solid #E8EDF5;
    border-radius: 16px;
    box-shadow: 0 10px 35px rgba(23, 36, 58, 0.05);
}

.service-details-image {
    width: 100%;
    height: 390px;
    object-fit: cover;
    border-radius: 15px 15px 0 0;
}

.service-image-placeholder {
    height: 300px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #EEF2F8;
    color: #94A3B8;
    font-size: 65px;
    border-radius: 15px 15px 0 0;
}

.service-details-content {
    padding: 30px;
}

.service-category-tag {
    display: inline-block;
    background: #EEF3FF;
    color: #2457D6;
    padding: 7px 12px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 700;
}

.service-details-title {
    color: #17243A;
    font-size: 30px;
    font-weight: 800;
    margin: 17px 0;
}

.service-details-price {
    color: #2457D6;
    font-size: 25px;
    font-weight: 800;
}

.service-description {
    color: #64748B;
    line-height: 1.8;
    white-space: pre-line;
}

.service-provider-card,
.booking-form-card {
    padding: 25px;
}

.provider-profile {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-bottom: 20px;
}

.provider-profile-image {
    width: 65px;
    height: 65px;
    object-fit: cover;
    border-radius: 50%;
    background: #EEF2F8;
}

.provider-profile-placeholder {
    width: 65px;
    height: 65px;
    border-radius: 50%;
    background: #EEF3FF;
    color: #2457D6;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 25px;
}

.provider-name {
    color: #17243A;
    font-size: 17px;
    font-weight: 800;
    margin-bottom: 4px;
}

.provider-detail {
    color: #64748B;
    font-size: 13px;
    margin-bottom: 10px;
    line-height: 1.6;
}

.booking-form-card h3,
.service-provider-card h3 {
    font-size: 19px;
    font-weight: 800;
    color: #17243A;
    margin-bottom: 20px;
}

.booking-form-card label {
    color: #334155;
    font-size: 13px;
    font-weight: 700;
    margin-bottom: 7px;
}

.booking-form-card .form-control {
    min-height: 45px;
    border: 1px solid #E2E8F0;
    border-radius: 8px;
    font-size: 14px;
}

.booking-form-card .form-control:focus {
    border-color: #2457D6;
    box-shadow: 0 0 0 3px rgba(36, 87, 214, 0.10);
}

.booking-submit-button {
    width: 100%;
    padding: 13px;
    border: none;
    border-radius: 8px;
    background: #2457D6;
    color: #FFFFFF;
    font-size: 14px;
    font-weight: 700;
}

.booking-submit-button:hover {
    background: #1744B5;
}

.booking-info {
    background: #F0F5FF;
    color: #45618E;
    padding: 13px;
    border-radius: 8px;
    font-size: 12px;
    line-height: 1.6;
}

/* Booking error message */
.booking-error-message {
    background: #FFF1F0;
    border: 1px solid #FECACA;
    color: #B42318;
    border-radius: 9px;
    padding: 13px 15px;
    margin-bottom: 20px;
    font-size: 13px;
    line-height: 1.6;
}

.booking-error-message i {
    margin-right: 7px;
}

/* CUSTOMER REVIEWS */
.service-reviews-card {
    padding: 25px;
}

.service-reviews-heading {
    color: #17243A;
    font-size: 20px;
    font-weight: 800;
    margin-bottom: 20px;
}

.review-summary {
    background: #F7F8FC;
    border: 1px solid #E8EDF5;
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 25px;
}

.review-average {
    color: #17243A;
    font-size: 34px;
    font-weight: 800;
    line-height: 1.2;
}

.review-stars {
    color: #F59E0B;
    letter-spacing: 2px;
    font-size: 15px;
}

.review-total {
    color: #64748B;
    font-size: 12px;
    margin-top: 5px;
}

.customer-review-item {
    padding: 20px 0;
    border-bottom: 1px solid #E8EDF5;
}

.customer-review-item:first-child {
    padding-top: 0;
}

.customer-review-item:last-child {
    border-bottom: none;
    padding-bottom: 0;
}

.customer-review-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
    margin-bottom: 10px;
}

.customer-review-name {
    color: #17243A;
    font-size: 14px;
    font-weight: 700;
}

.customer-review-date {
    color: #94A3B8;
    font-size: 11px;
}

.customer-review-comment {
    color: #64748B;
    font-size: 13px;
    line-height: 1.8;
    margin: 10px 0 0;
    white-space: pre-line;
}

.customer-review-rating {
    color: #F59E0B;
    font-size: 13px;
    letter-spacing: 2px;
}

.no-reviews-message {
    text-align: center;
    padding: 30px 15px;
    background: #F7F8FC;
    border-radius: 12px;
}

.no-reviews-message i {
    color: #F59E0B;
    font-size: 35px;
}

.no-reviews-message h5 {
    color: #17243A;
    font-size: 15px;
    font-weight: 700;
    margin-top: 12px;
}

.no-reviews-message p {
    color: #64748B;
    font-size: 13px;
    margin-bottom: 0;
}

@media (max-width: 767px) {
    .service-details-section {
        padding: 30px 0;
    }

    .service-details-image {
        height: 240px;
    }

    .service-details-content {
        padding: 20px;
    }

    .service-details-title {
        font-size: 23px;
    }

    .service-details-price {
        font-size: 21px;
    }

    .service-reviews-card {
        padding: 20px;
    }
}
</style>


<section class="service-details-section">

    <div class="container service-details-container">

        <div class="mb-4">

            <a
                href="javascript:history.back()"
                class="text-decoration-none text-primary fw-semibold"
            >
                <i class="bi bi-arrow-left me-2"></i>
                Back to Services
            </a>

        </div>


        <div class="row g-4">

            <!-- LEFT: SERVICE INFORMATION -->
            <div class="col-lg-7">

                <div class="service-main-card overflow-hidden">

                    <?php if ($serviceImage !== ''): ?>

                        <img
                            src="<?= htmlspecialchars($serviceImage, ENT_QUOTES, 'UTF-8') ?>"
                            class="service-details-image"
                            alt="<?= htmlspecialchars($service['title'], ENT_QUOTES, 'UTF-8') ?>"
                        >

                    <?php else: ?>

                        <div class="service-image-placeholder">
                            <i class="bi bi-tools"></i>
                        </div>

                    <?php endif; ?>


                    <div class="service-details-content">

                        <span class="service-category-tag">
                            <?= htmlspecialchars($service['main_category_name'], ENT_QUOTES, 'UTF-8') ?>
                            /
                            <?= htmlspecialchars($service['subcategory_name'], ENT_QUOTES, 'UTF-8') ?>
                        </span>


                        <h1 class="service-details-title">
                            <?= htmlspecialchars($service['title'], ENT_QUOTES, 'UTF-8') ?>
                        </h1>


                        <!-- SERVICE RATING SUMMARY -->
                        <div class="mb-3">

                            <?php if ($reviewCount > 0 && $averageRating !== null): ?>

                                <div class="d-flex align-items-center flex-wrap gap-2">

                                    <span class="review-stars">
                                        <?php
                                        $roundedRating = (int) round((float) $averageRating);
                                        for ($i = 1; $i <= 5; $i++):
                                        ?>
                                            <i class="bi <?= $i <= $roundedRating ? 'bi-star-fill' : 'bi-star' ?>"></i>
                                        <?php endfor; ?>
                                    </span>

                                    <strong class="text-dark">
                                        <?= number_format((float) $averageRating, 1) ?>/5
                                    </strong>

                                    <span class="text-muted small">
                                        (<?= $reviewCount ?>
                                        <?= $reviewCount === 1 ? 'review' : 'reviews' ?>)
                                    </span>

                                </div>

                            <?php else: ?>

                                <span class="text-muted small">
                                    <i class="bi bi-star me-1"></i>
                                    No reviews yet
                                </span>

                            <?php endif; ?>

                        </div>


                        <div class="service-details-price mb-4">
                            <?= htmlspecialchars($priceLabel, ENT_QUOTES, 'UTF-8') ?>
                        </div>


                        <hr class="my-4">


                        <h5 class="fw-bold mb-3">
                            About This Service
                        </h5>

                        <p class="service-description mb-0">
                            <?= htmlspecialchars($service['description'], ENT_QUOTES, 'UTF-8') ?>
                        </p>

                    </div>

                </div>


                <!-- PROVIDER INFORMATION -->
                <div class="service-provider-card mt-4">

                    <h3>
                        <i class="bi bi-person-badge me-2 text-primary"></i>
                        About the Service Provider
                    </h3>


                    <div class="provider-profile">

                        <?php if ($providerImage !== ''): ?>

                            <img
                                src="<?= htmlspecialchars($providerImage, ENT_QUOTES, 'UTF-8') ?>"
                                class="provider-profile-image"
                                alt="Provider profile"
                            >

                        <?php else: ?>

                            <div class="provider-profile-placeholder">
                                <i class="bi bi-person-fill"></i>
                            </div>

                        <?php endif; ?>


                        <div>

                            <div class="provider-name">
                                <?= htmlspecialchars($service['business_name'], ENT_QUOTES, 'UTF-8') ?>
                            </div>

                            <div class="provider-detail mb-0">
                                <?= htmlspecialchars($service['provider_name'], ENT_QUOTES, 'UTF-8') ?>
                            </div>

                        </div>

                    </div>


                    <?php if (!empty($service['provider_description'])): ?>

                        <p class="provider-detail">
                            <?= nl2br(htmlspecialchars($service['provider_description'], ENT_QUOTES, 'UTF-8')) ?>
                        </p>

                    <?php endif; ?>


                    <div class="provider-detail">

                        <i class="bi bi-geo-alt-fill text-primary me-2"></i>

                        <?= htmlspecialchars($service['provider_address'] ?? '', ENT_QUOTES, 'UTF-8') ?>

                        <?php if (!empty($service['provider_city'])): ?>
                            , <?= htmlspecialchars($service['provider_city'], ENT_QUOTES, 'UTF-8') ?>
                        <?php endif; ?>

                        <?php if (!empty($service['provider_state'])): ?>
                            , <?= htmlspecialchars($service['provider_state'], ENT_QUOTES, 'UTF-8') ?>
                        <?php endif; ?>

                        <?php if (!empty($service['provider_pincode'])): ?>
                            - <?= htmlspecialchars($service['provider_pincode'], ENT_QUOTES, 'UTF-8') ?>
                        <?php endif; ?>

                    </div>

                </div>


                <!-- CUSTOMER REVIEWS -->
                <div class="service-reviews-card mt-4">

                    <h3 class="service-reviews-heading">
                        <i class="bi bi-chat-square-text me-2 text-primary"></i>
                        Customer Reviews
                    </h3>


                    <!-- RATING SUMMARY -->
                    <?php if ($reviewCount > 0 && $averageRating !== null): ?>

                        <div class="review-summary">

                            <div class="review-average">
                                <?= number_format((float) $averageRating, 1) ?>
                                <span class="fs-6 text-muted">/ 5</span>
                            </div>

                            <div class="review-stars mt-2">

                                <?php
                                for ($i = 1; $i <= 5; $i++):
                                ?>
                                    <i class="bi <?= $i <= (int) round((float) $averageRating) ? 'bi-star-fill' : 'bi-star' ?>"></i>
                                <?php endfor; ?>

                            </div>

                            <div class="review-total">
                                Based on <?= $reviewCount ?>
                                <?= $reviewCount === 1 ? 'customer review' : 'customer reviews' ?>
                            </div>

                        </div>


                        <!-- INDIVIDUAL REVIEWS -->
                        <?php foreach ($reviews as $review): ?>

                            <div class="customer-review-item">

                                <div class="customer-review-header">

                                    <div class="customer-review-name">

                                        <i class="bi bi-person-circle me-2 text-primary"></i>

                                        <?= htmlspecialchars(
                                            $review['customer_name'],
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>

                                    </div>

                                    <div class="customer-review-date">

                                        <i class="bi bi-calendar3 me-1"></i>

                                        <?php
                                        $reviewDate = !empty($review['created_at'])
                                            ? strtotime($review['created_at'])
                                            : false;

                                        echo $reviewDate
                                            ? date('d M Y', $reviewDate)
                                            : 'Date unavailable';
                                        ?>

                                    </div>

                                </div>


                                <!-- CUSTOMER STAR RATING -->
                                <div class="customer-review-rating">

                                    <?php
                                    $customerRating = (int) $review['rating'];

                                    for ($i = 1; $i <= 5; $i++):
                                    ?>

                                        <i class="bi <?= $i <= $customerRating ? 'bi-star-fill' : 'bi-star' ?>"></i>

                                    <?php endfor; ?>

                                </div>


                                <!-- CUSTOMER COMMENT -->
                                <p class="customer-review-comment">
                                    <?= nl2br(htmlspecialchars(
                                        $review['comment'],
                                        ENT_QUOTES,
                                        'UTF-8'
                                    )) ?>
                                </p>

                            </div>

                        <?php endforeach; ?>


                    <?php else: ?>

                        <!-- EMPTY REVIEWS STATE -->
                        <div class="no-reviews-message">

                            <i class="bi bi-star"></i>

                            <h5>Be the First to Review!</h5>

                            <p>
                                No customers have reviewed this service yet.
                                Complete a booking and share your experience.
                            </p>

                        </div>

                    <?php endif; ?>

                </div>

            </div>


            <!-- RIGHT: BOOKING FORM -->
            <div class="col-lg-5">

                <div class="booking-form-card">

                    <h3>
                        <i class="bi bi-calendar-check me-2 text-primary"></i>
                        Book This Service
                    </h3>


                    <p class="text-muted small mb-4">
                        Choose your preferred date and time and tell the
                        provider where you need the service.
                    </p>


                    <?php if (!empty($bookingError)): ?>

                        <div class="booking-error-message" role="alert">

                            <i class="bi bi-exclamation-circle-fill"></i>

                            <?= htmlspecialchars(
                                $bookingError,
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>

                        </div>

                    <?php endif; ?>


                    <form
                        action="<?= APP_URL ?>/booking/store"
                        method="POST"
                    >

                        <input
                            type="hidden"
                            name="csrf_token"
                            value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8') ?>"
                        >

                        <input
                            type="hidden"
                            name="service_id"
                            value="<?= (int) $service['id'] ?>"
                        >


                        <div class="mb-3">

                            <label for="booking_date">
                                Preferred Date *
                            </label>

                            <input
                                type="date"
                                name="booking_date"
                                id="booking_date"
                                class="form-control"
                                min="<?= date('Y-m-d') ?>"
                                required
                            >

                        </div>


                        <div class="mb-3">

                            <label for="booking_time">
                                Preferred Time *
                            </label>

                            <input
                                type="time"
                                name="booking_time"
                                id="booking_time"
                                class="form-control"
                                required
                            >

                        </div>


                        <div class="mb-3">

                            <label for="service_address">
                                Service Address *
                            </label>

                            <textarea
                                name="service_address"
                                id="service_address"
                                class="form-control"
                                rows="3"
                                placeholder="Enter the complete address where you need the service"
                                required
                            ></textarea>

                        </div>


                        <div class="mb-3">

                            <label for="city">
                                City *
                            </label>

                            <input
                                type="text"
                                name="city"
                                id="city"
                                class="form-control"
                                maxlength="100"
                                placeholder="Enter your city"
                                required
                            >

                        </div>


                        <div class="mb-3">

                            <label for="pincode">
                                Pincode *
                            </label>

                            <input
                                type="text"
                                name="pincode"
                                id="pincode"
                                class="form-control"
                                maxlength="10"
                                placeholder="Enter your pincode"
                                required
                            >

                        </div>


                        <div class="mb-4">

                            <label for="customer_message">
                                Additional Message
                            </label>

                            <textarea
                                name="customer_message"
                                id="customer_message"
                                class="form-control"
                                rows="3"
                                placeholder="Describe your requirements (optional)"
                            ></textarea>

                        </div>


                        <div class="booking-info mb-3">

                            <i class="bi bi-info-circle me-2"></i>

                            Your selected date and time will be shared
                            with the service provider. Your request will
                            initially be marked as Pending.

                        </div>


                        <button
                            type="submit"
                            class="booking-submit-button"
                        >
                            Send Booking Request
                            <i class="bi bi-arrow-right ms-2"></i>
                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</section>


<?php require APP_ROOT . '/app/views/layouts/footer.php'; ?>
