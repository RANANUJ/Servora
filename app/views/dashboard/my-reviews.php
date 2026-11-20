
<?php

$reviews = $reviews ?? [];

include APP_ROOT . '/app/views/layouts/header.php';

?>

<style>
.my-reviews-page {
    min-height: 65vh;
    padding: 55px 0 80px;
    background: #F6F8FC;
    font-family: 'DM Sans', sans-serif;
    color: #17243A;
}

.my-reviews-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 20px;
    margin-bottom: 35px;
}

.my-reviews-header h1 {
    font-size: 32px;
    font-weight: 700;
    margin: 8px 0;
}

.my-reviews-header p {
    color: #64748B;
    margin: 0;
}

.my-reviews-eyebrow {
    color: #2457D6;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 1.2px;
}

.my-reviews-count {
    background: #FFFFFF;
    border: 1px solid #E8EDF5;
    padding: 12px 18px;
    border-radius: 12px;
    font-weight: 600;
    white-space: nowrap;
}

.my-review-card {
    background: #FFFFFF;
    border: 1px solid #E8EDF5;
    border-radius: 18px;
    padding: 25px;
    margin-bottom: 20px;
    box-shadow: 0 10px 30px rgba(23, 36, 58, 0.04);
}

.my-review-service {
    display: flex;
    align-items: center;
    gap: 16px;
    margin-bottom: 20px;
}

.my-review-image {
    width: 85px;
    height: 75px;
    border-radius: 12px;
    object-fit: cover;
    background: #F6F8FC;
}

.my-review-image-placeholder {
    width: 85px;
    height: 75px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #EEF3FF;
    color: #2457D6;
    font-size: 27px;
}

.my-review-service h2 {
    font-size: 19px;
    font-weight: 700;
    margin: 0 0 5px;
}

.my-review-service p {
    color: #64748B;
    margin: 0;
    font-size: 14px;
}

.my-review-divider {
    border-top: 1px solid #E8EDF5;
    margin: 18px 0;
}

.my-review-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 15px;
    flex-wrap: wrap;
}

.my-review-stars {
    color: #F49A38;
    font-size: 19px;
    letter-spacing: 2px;
}

.my-review-date {
    color: #64748B;
    font-size: 13px;
}

.my-review-comment {
    color: #475569;
    line-height: 1.8;
    margin: 15px 0 0;
    white-space: pre-wrap;
    overflow-wrap: anywhere;
}

.my-reviews-empty {
    background: #FFFFFF;
    border: 1px solid #E8EDF5;
    border-radius: 18px;
    padding: 65px 25px;
    text-align: center;
    box-shadow: 0 10px 30px rgba(23, 36, 58, 0.04);
}

.my-reviews-empty-icon {
    width: 75px;
    height: 75px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
    border-radius: 22px;
    background: #EEF3FF;
    color: #2457D6;
    font-size: 32px;
}

.my-reviews-empty h2 {
    font-size: 22px;
    font-weight: 700;
    margin-bottom: 10px;
}

.my-reviews-empty p {
    color: #64748B;
    max-width: 440px;
    margin: 0 auto 22px;
    line-height: 1.7;
}

@media (max-width: 576px) {
    .my-reviews-page {
        padding: 35px 0 55px;
    }

    .my-reviews-header {
        align-items: flex-start;
        flex-direction: column;
    }

    .my-reviews-header h1 {
        font-size: 27px;
    }

    .my-review-card {
        padding: 18px;
    }

    .my-review-image,
    .my-review-image-placeholder {
        width: 68px;
        height: 68px;
    }

    .my-review-service h2 {
        font-size: 16px;
    }
}
</style>

<section class="my-reviews-page">

    <div class="container">

        <!-- PAGE HEADER -->
        <div class="my-reviews-header">

            <div>
                <span class="my-reviews-eyebrow">
                    YOUR SERVORA EXPERIENCE
                </span>

                <h1>My Reviews</h1>

                <p>
                    All the experiences and feedback you've shared
                    with Servora professionals.
                </p>
            </div>

            <div class="my-reviews-count">
                <i class="bi bi-star-fill me-2" style="color:#F49A38;"></i>
                <?= count($reviews) ?>
                <?= count($reviews) === 1 ? 'Review' : 'Reviews' ?>
            </div>

        </div>


        <!-- REVIEW LIST -->
        <?php if (!empty($reviews)): ?>

            <?php foreach ($reviews as $review): ?>

                <?php

                $serviceTitle = htmlspecialchars(
                    $review['service_title'] ?? 'Service',
                    ENT_QUOTES,
                    'UTF-8'
                );

                $businessName = htmlspecialchars(
                    !empty($review['business_name'])
                        ? $review['business_name']
                        : ($review['provider_name'] ?? 'Service Provider'),
                    ENT_QUOTES,
                    'UTF-8'
                );

                $comment = htmlspecialchars(
                    $review['comment'] ?? '',
                    ENT_QUOTES,
                    'UTF-8'
                );

                $rating = (int) $review['rating'];
                $rating = max(0, min(5, $rating));

                $reviewDate = !empty($review['created_at'])
                    ? date('d M Y', strtotime($review['created_at']))
                    : 'Date unavailable';

                $serviceImage = !empty($review['service_image'])
                    ? APP_URL . '/' . $review['service_image']
                    : null;

                ?>

                <article class="my-review-card">

                    <!-- SERVICE DETAILS -->
                    <div class="my-review-service">

                        <?php if ($serviceImage): ?>

                            <img
                                src="<?= htmlspecialchars($serviceImage, ENT_QUOTES, 'UTF-8') ?>"
                                alt="<?= $serviceTitle ?>"
                                class="my-review-image"
                            >

                        <?php else: ?>

                            <div class="my-review-image-placeholder">
                                <i class="bi bi-tools"></i>
                            </div>

                        <?php endif; ?>

                        <div>

                            <h2><?= $serviceTitle ?></h2>

                            <p>
                                <i class="bi bi-shop me-1"></i>
                                <?= $businessName ?>
                            </p>

                        </div>

                    </div>

                    <div class="my-review-divider"></div>

                    <!-- RATING AND DATE -->
                    <div class="my-review-meta">

                        <div
                            class="my-review-stars"
                            aria-label="<?= $rating ?> out of 5 stars"
                        >

                            <?php for ($i = 1; $i <= 5; $i++): ?>

                                <?php if ($i <= $rating): ?>
                                    <i class="bi bi-star-fill"></i>
                                <?php else: ?>
                                    <i class="bi bi-star"></i>
                                <?php endif; ?>

                            <?php endfor; ?>

                            <span style="font-size:13px; color:#64748B; letter-spacing:0;">
                                <?= $rating ?>/5
                            </span>

                        </div>

                        <span class="my-review-date">
                            <i class="bi bi-calendar3 me-1"></i>
                            <?= htmlspecialchars($reviewDate, ENT_QUOTES, 'UTF-8') ?>
                        </span>

                    </div>

                    <!-- CUSTOMER COMMENT -->
                    <p class="my-review-comment">
                        <?= $comment ?>
                    </p>

                </article>

            <?php endforeach; ?>

        <?php else: ?>

            <!-- EMPTY STATE -->
            <div class="my-reviews-empty">

                <div class="my-reviews-empty-icon">
                    <i class="bi bi-chat-square-heart"></i>
                </div>

                <h2>You haven't written any reviews yet</h2>

                <p>
                    Once a service provider completes your booking,
                    you can share your experience by giving a rating
                    and writing a review.
                </p>

                <a
                    href="<?= APP_URL ?>/dashboard#myServiceRequests"
                    class="btn btn-primary"
                >
                    View My Bookings
                    <i class="bi bi-arrow-right ms-2"></i>
                </a>

            </div>

        <?php endif; ?>


        <!-- BACK TO DASHBOARD -->
        <div class="mt-4">

            <a
                href="<?= APP_URL ?>/dashboard"
                style="color:#2457D6; font-weight:600; text-decoration:none;"
            >
                <i class="bi bi-arrow-left me-2"></i>
                Back to Dashboard
            </a>

        </div>

    </div>

</section>

<?php include APP_ROOT . '/app/views/layouts/footer.php'; ?>
