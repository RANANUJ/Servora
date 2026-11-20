
<?php require APP_ROOT . '/app/views/layouts/header.php'; ?>

<?php
$categoryName = $category['name'] ?? 'Explore Services';
$hasCategory = !empty($category);
$hasServices = !empty($services);

function servicePriceLabel($service)
{
    if ($service['price_type'] === 'negotiable') {
        return 'Negotiable';
    }

    $price = '₹' . number_format((float) $service['price'], 0);

    if ($service['price_type'] === 'starting_from') {
        return 'Starting from ' . $price;
    }

    if ($service['price_type'] === 'hourly') {
        return $price . ' / hour';
    }

    return $price;
}
?>

<style>
.services-listing-section {
    background: #F7F8FC;
    min-height: 70vh;
}

.service-cards-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(175px, 195px));
    justify-content: center;
    gap: 18px;
}

.service-mini-card {
    width: 100%;
    background: #FFFFFF;
    border: 1px solid #E8EDF5;
    border-radius: 12px;
    overflow: hidden;
    transition: all 0.2s ease;
}

.service-mini-card:hover {
    transform: translateY(-3px);
    border-color: #C9D8FF;
    box-shadow: 0 8px 20px rgba(23, 36, 58, 0.08);
}

.service-mini-image,
.service-mini-image-placeholder {
    width: 100%;
    height: 105px;
    object-fit: cover;
    display: block;
}

.service-mini-image-placeholder {
    display: flex;
    align-items: center;
    justify-content: center;
    background: #F1F4F9;
    color: #94A3B8;
    font-size: 25px;
}

.service-mini-content {
    padding: 12px;
}

.service-mini-tag {
    display: inline-block;
    background: #EEF3FF;
    color: #2457D6;
    font-size: 9px;
    font-weight: 700;
    padding: 4px 7px;
    border-radius: 4px;
    margin-bottom: 8px;
}

.service-mini-title {
    font-size: 13px;
    line-height: 1.4;
    font-weight: 700;
    color: #17243A;
    margin: 0 0 7px;
    min-height: 36px;
}

/* CUSTOMER RATINGS */
.service-mini-rating {
    display: flex;
    align-items: center;
    gap: 4px;
    margin-bottom: 10px;
    font-size: 11px;
}

.service-mini-rating .rating-star {
    color: #F59E0B;
    font-size: 12px;
}

.service-mini-rating .rating-value {
    color: #17243A;
    font-weight: 700;
}

.service-mini-rating .rating-count {
    color: #64748B;
}

.service-mini-no-rating {
    color: #94A3B8;
    font-size: 10px;
    margin-bottom: 10px;
}

.service-mini-price {
    font-size: 14px;
    font-weight: 800;
    color: #2457D6;
    margin-bottom: 11px;
}

.service-mini-button {
    display: block;
    width: 100%;
    background: #2457D6;
    color: #FFFFFF;
    text-decoration: none;
    text-align: center;
    padding: 8px;
    border-radius: 6px;
    font-size: 10px;
    font-weight: 700;
    transition: background 0.2s ease;
}

.service-mini-button:hover {
    background: #1744B5;
    color: #FFFFFF;
}

@media (max-width: 480px) {
    .service-cards-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 12px;
    }

    .service-mini-content {
        padding: 10px;
    }

    .service-mini-title {
        font-size: 12px;
    }
}
</style>

<section class="services-listing-section py-5">

    <div class="container">

        <!-- PAGE HEADING -->
        <div class="mb-5">

            <span class="section-label">EXPLORE SERVORA</span>

            <h1 class="mt-2">
                <?= htmlspecialchars($categoryName, ENT_QUOTES, 'UTF-8') ?>
                <span>Services</span>
            </h1>

            <p class="text-muted">
                Discover local professionals and find the right service
                for your everyday needs.
            </p>

            <a href="<?= APP_URL ?>/#services"
               class="text-decoration-none">
                <i class="bi bi-arrow-left"></i>
                Back to Categories
            </a>

        </div>

        <?php if (!$hasCategory): ?>

            <div class="text-center py-5">

                <i class="bi bi-grid display-3 text-primary"></i>

                <h3 class="mt-3">Explore Our Categories</h3>

                <p class="text-muted">
                    Please select a category from our homepage.
                </p>

                <a href="<?= APP_URL ?>/#services"
                   class="btn btn-primary mt-2">
                    Browse Categories
                </a>

            </div>

        <?php elseif ($hasServices): ?>

            <!-- SERVICE COUNT -->
            <div class="d-flex justify-content-between align-items-center mb-4">

                <h5 class="fw-bold mb-0">Available Services</h5>

                <span class="text-muted small">
                    <?= count($services) ?>
                    <?= count($services) === 1 ? 'service' : 'services' ?>
                    found
                </span>

            </div>

            <!-- SERVICE CARDS -->
            <div class="service-cards-grid">

                <?php foreach ($services as $service): ?>

                    <div class="service-mini-card">

                        <!-- SERVICE IMAGE -->
                        <?php if (!empty($service['service_image'])): ?>

                            <img
                                src="<?= APP_URL . '/' . htmlspecialchars(ltrim($service['service_image'], '/'), ENT_QUOTES, 'UTF-8') ?>"
                                class="service-mini-image"
                                alt="<?= htmlspecialchars($service['title'], ENT_QUOTES, 'UTF-8') ?>"
                            >

                        <?php else: ?>

                            <div class="service-mini-image-placeholder">
                                <i class="bi bi-tools"></i>
                            </div>

                        <?php endif; ?>

                        <!-- SERVICE CONTENT -->
                        <div class="service-mini-content">

                            <span class="service-mini-tag">
                                <?= htmlspecialchars($service['subcategory_name'] ?? 'Service', ENT_QUOTES, 'UTF-8') ?>
                            </span>

                            <h3 class="service-mini-title">
                                <?= htmlspecialchars($service['title'], ENT_QUOTES, 'UTF-8') ?>
                            </h3>

                            <!-- CUSTOMER RATING -->
                            <?php
                            $averageRating = $service['average_rating'] ?? null;
                            $reviewCount = (int) ($service['review_count'] ?? 0);
                            ?>

                            <?php if ($reviewCount > 0 && $averageRating !== null): ?>

                                <div class="service-mini-rating">

                                    <i class="bi bi-star-fill rating-star"></i>

                                    <span class="rating-value">
                                        <?= number_format((float) $averageRating, 1) ?>
                                    </span>

                                    <span class="rating-count">
                                        (<?= $reviewCount ?>
                                        <?= $reviewCount === 1 ? 'review' : 'reviews' ?>)
                                    </span>

                                </div>

                            <?php else: ?>

                                <div class="service-mini-no-rating">
                                    No reviews yet
                                </div>

                            <?php endif; ?>

                            <!-- PRICE -->
                            <div class="service-mini-price">
                                <?= htmlspecialchars(servicePriceLabel($service), ENT_QUOTES, 'UTF-8') ?>
                            </div>

                            <!-- DETAILS BUTTON -->
                            <a
                                href="<?= APP_URL ?>/service/details?id=<?= (int) $service['id'] ?>"
                                class="service-mini-button"
                            >
                                View Details
                                <i class="bi bi-arrow-right ms-1"></i>
                            </a>

                        </div>

                    </div>

                <?php endforeach; ?>

            </div>

        <?php else: ?>

            <!-- NO SERVICES FOUND -->
            <div class="text-center py-5">

                <i class="bi bi-search display-1 text-secondary"></i>

                <h3 class="fw-bold mt-3">No Services Found</h3>

                <p class="text-muted mx-auto" style="max-width:500px;">

                    We haven't received any service listings under
                    <?= htmlspecialchars($categoryName, ENT_QUOTES, 'UTF-8') ?> yet.

                    Please check back later.

                </p>

                <a href="<?= APP_URL ?>/#services"
                   class="btn btn-primary mt-3">
                    <i class="bi bi-grid me-2"></i>
                    Explore Other Categories
                </a>

            </div>

        <?php endif; ?>

    </div>

</section>

<?php require APP_ROOT . '/app/views/layouts/footer.php'; ?>
