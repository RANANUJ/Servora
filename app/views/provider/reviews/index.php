
<?php

// Prepare rating summary
$averageRating = (float) ($ratingSummary['average_rating'] ?? 0);
$totalReviews = (int) ($ratingSummary['review_count'] ?? 0);

?>

<?php require APP_ROOT . '/app/views/layouts/header.php'; ?>

<style>
/* CUSTOMER REVIEWS PAGE */

.provider-reviews-page {
    min-height: 100vh;
    padding: 45px 0 70px;
    background: #F6F8FC;
}

.provider-reviews-page .reviews-container {
    max-width: 1100px;
    margin: auto;
}

.provider-reviews-page .reviews-heading {
    margin-bottom: 30px;
}

.provider-reviews-page .reviews-heading h1 {
    color: #17243A;
    font-size: 30px;
    font-weight: 700;
    margin-bottom: 8px;
}

.provider-reviews-page .reviews-heading p {
    color: #64748B;
    margin-bottom: 0;
}

.provider-reviews-page .back-link {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: #2457D6;
    text-decoration: none;
    font-weight: 600;
    margin-bottom: 22px;
}

.provider-reviews-page .back-link:hover {
    color: #1744B5;
}

.provider-reviews-page .rating-summary {
    background: #FFFFFF;
    border: 1px solid #E8EDF5;
    border-radius: 18px;
    padding: 28px;
    margin-bottom: 30px;
    box-shadow: 0 15px 45px rgba(23, 36, 58, 0.05);
}

.provider-reviews-page .rating-number {
    color: #17243A;
    font-size: 44px;
    font-weight: 750;
    line-height: 1.2;
}

.provider-reviews-page .rating-stars {
    color: #F49A38;
    font-size: 20px;
    letter-spacing: 2px;
    margin: 8px 0;
}

.provider-reviews-page .rating-caption {
    color: #64748B;
    font-size: 14px;
}

.provider-reviews-page .summary-divider {
    width: 1px;
    min-height: 75px;
    background: #E8EDF5;
}

.provider-reviews-page .review-count {
    color: #17243A;
    font-size: 30px;
    font-weight: 700;
}

.provider-reviews-page .review-count-label {
    color: #64748B;
    font-size: 14px;
}

.provider-reviews-page .section-heading {
    color: #17243A;
    font-size: 21px;
    font-weight: 700;
    margin-bottom: 18px;
}

.provider-reviews-page .review-card {
    background: #FFFFFF;
    border: 1px solid #E8EDF5;
    border-radius: 16px;
    padding: 24px;
    margin-bottom: 16px;
    box-shadow: 0 8px 25px rgba(23, 36, 58, 0.04);
}

.provider-reviews-page .review-top {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 15px;
    margin-bottom: 15px;
}

.provider-reviews-page .customer-info {
    display: flex;
    align-items: center;
    gap: 13px;
}

.provider-reviews-page .customer-avatar {
    width: 46px;
    height: 46px;
    border-radius: 50%;
    background: #EAF0FF;
    color: #2457D6;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    font-weight: 700;
    flex-shrink: 0;
}

.provider-reviews-page .customer-name {
    color: #17243A;
    font-size: 15px;
    font-weight: 700;
    margin-bottom: 3px;
}

.provider-reviews-page .review-date {
    color: #94A3B8;
    font-size: 12px;
}

.provider-reviews-page .review-stars {
    color: #F49A38;
    font-size: 15px;
    letter-spacing: 2px;
    white-space: nowrap;
}

.provider-reviews-page .service-label {
    display: inline-block;
    background: #F1F5FF;
    color: #2457D6;
    border-radius: 7px;
    padding: 6px 10px;
    font-size: 12px;
    font-weight: 600;
    margin-bottom: 13px;
}

.provider-reviews-page .review-comment {
    color: #475569;
    font-size: 14px;
    line-height: 1.8;
    margin: 0;
    overflow-wrap: anywhere;
}

.provider-reviews-page .empty-reviews {
    background: #FFFFFF;
    border: 1px solid #E8EDF5;
    border-radius: 18px;
    padding: 55px 25px;
    text-align: center;
}

.provider-reviews-page .empty-icon {
    width: 65px;
    height: 65px;
    border-radius: 18px;
    background: #FFF5E9;
    color: #F49A38;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 27px;
    margin: 0 auto 18px;
}

.provider-reviews-page .empty-reviews h3 {
    color: #17243A;
    font-size: 19px;
    font-weight: 700;
    margin-bottom: 8px;
}

.provider-reviews-page .empty-reviews p {
    color: #64748B;
    font-size: 14px;
    margin: 0;
}

@media (max-width: 576px) {
    .provider-reviews-page {
        padding: 30px 0 50px;
    }

    .provider-reviews-page .reviews-heading h1 {
        font-size: 25px;
    }

    .provider-reviews-page .rating-summary {
        padding: 22px;
    }

    .provider-reviews-page .review-card {
        padding: 19px;
    }

    .provider-reviews-page .review-top {
        flex-direction: column;
    }

    .provider-reviews-page .summary-divider {
        display: none;
    }
}
</style>

<main class="provider-reviews-page">

    <div class="container reviews-container">

        <!-- BACK LINK -->
        <a href="<?= APP_URL ?>/provider/dashboard" class="back-link">
            <i class="bi bi-arrow-left"></i>
            Back to Dashboard
        </a>

        <!-- PAGE HEADING -->
        <div class="reviews-heading">
            <h1>Customer Reviews</h1>
            <p>
                See what your customers think about your services
                and the experience you provide.
            </p>
        </div>

        <!-- RATING SUMMARY -->
        <div class="rating-summary">

            <div class="row align-items-center g-4">

                <div class="col-md-5">

                    <div class="rating-number">
                        <?= number_format($averageRating, 1) ?>
                        <span style="font-size: 17px; color: #94A3B8;">
                            / 5
                        </span>
                    </div>

                    <div class="rating-stars">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <i class="bi <?= $i <= round($averageRating) ? 'bi-star-fill' : 'bi-star' ?>"></i>
                        <?php endfor; ?>
                    </div>

                    <div class="rating-caption">
                        Average customer rating
                    </div>

                </div>

                <div class="col-md-1 d-none d-md-flex justify-content-center">
                    <div class="summary-divider"></div>
                </div>

                <div class="col-md-5">

                    <div class="review-count">
                        <?= number_format($totalReviews) ?>
                    </div>

                    <div class="review-count-label">
                        Published customer reviews
                    </div>

                </div>

            </div>

        </div>

        <!-- REVIEW LIST -->
        <div class="reviews-list-section">

            <h2 class="section-heading">
                All Customer Reviews
            </h2>

            <?php if (!empty($reviews)): ?>

                <?php foreach ($reviews as $review): ?>

                    <?php
                    $customerName = $review['customer_name'] ?? 'Customer';
                    $initial = strtoupper(substr(trim($customerName), 0, 1));
                    $rating = (int) $review['rating'];
                    ?>

                    <article class="review-card">

                        <div class="review-top">

                            <div class="customer-info">

                                <div class="customer-avatar">
                                    <?= htmlspecialchars($initial, ENT_QUOTES, 'UTF-8') ?>
                                </div>

                                <div>

                                    <div class="customer-name">
                                        <?= htmlspecialchars($customerName, ENT_QUOTES, 'UTF-8') ?>
                                    </div>

                                    <div class="review-date">
                                        <?= date('d M Y', strtotime($review['created_at'])) ?>
                                    </div>

                                </div>

                            </div>

                            <div class="review-stars">

                                <?php for ($i = 1; $i <= 5; $i++): ?>

                                    <i class="bi <?= $i <= $rating ? 'bi-star-fill' : 'bi-star' ?>"></i>

                                <?php endfor; ?>

                            </div>

                        </div>

                        <div>

                            <span class="service-label">
                                <i class="bi bi-briefcase me-1"></i>

                                <?= htmlspecialchars(
                                    $review['service_title'] ?? 'Service',
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>
                            </span>

                        </div>

                        <p class="review-comment">
                            <?= nl2br(htmlspecialchars(
                                $review['comment'] ?? '',
                                ENT_QUOTES,
                                'UTF-8'
                            )) ?>
                        </p>

                    </article>

                <?php endforeach; ?>

            <?php else: ?>

                <!-- EMPTY STATE -->
                <div class="empty-reviews">

                    <div class="empty-icon">
                        <i class="bi bi-chat-square-heart"></i>
                    </div>

                    <h3>No Customer Reviews Yet</h3>

                    <p>
                        Once customers complete their bookings and
                        share their feedback, their reviews will
                        appear here.
                    </p>

                </div>

            <?php endif; ?>

        </div>

    </div>

</main>

<?php require APP_ROOT . '/app/views/layouts/footer.php'; ?>
