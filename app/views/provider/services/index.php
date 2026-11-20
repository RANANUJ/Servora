
<?php require APP_ROOT . '/app/views/layouts/header.php'; ?>

<section class="customer-dashboard py-5">
    <div class="container">

        <!-- PAGE HEADING -->
        <div class="dashboard-welcome mb-4">
            <div>
                <span class="dashboard-eyebrow">
                    <i class="bi bi-tools"></i>
                    BUSINESS MANAGEMENT
                </span>

                <h1>My Services</h1>

                <p>
                    Add, edit and manage the services your business
                    offers to customers.
                </p>
            </div>

            <a href="<?= APP_URL ?>/provider/dashboard"
               class="btn btn-outline-primary">
                <i class="bi bi-arrow-left me-2"></i>
                Dashboard
            </a>
        </div>

        <!-- SERVICE SUMMARY -->
        <div class="dashboard-card p-4">

            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                <div>
                    <h3 class="mb-1">Your service listings</h3>

                    <p class="text-muted mb-0">
                        Manage all the services listed by your business.
                    </p>
                </div>

                <a href="<?= APP_URL ?>/provider/services/create"
   class="btn btn-primary">
    <i class="bi bi-plus-lg me-2"></i>
    Add New Service
</a>
            </div>

            <hr class="my-4">

            <?php if (empty($services)): ?>

                <div class="text-center py-5">

                    <i class="bi bi-tools display-3 text-secondary"></i>

                    <h4 class="mt-3">No Services Listed Yet</h4>

                    <p class="text-muted">
                        You haven't added any services to your business.
                        Start by creating your first service listing.
                    </p>

                </div>

            <?php else: ?>

                <div class="row g-4">

                    <?php foreach ($services as $service): ?>

                        <div class="col-lg-4 col-md-6">

                            <div class="card h-100 border-0 shadow-sm">

                                <?php if (!empty($service['service_image'])): ?>

                                    <img
                                        src="<?= APP_URL . '/' . htmlspecialchars(ltrim($service['service_image'], '/'), ENT_QUOTES, 'UTF-8') ?>"
                                        class="card-img-top"
                                        alt="<?= htmlspecialchars($service['title'], ENT_QUOTES, 'UTF-8') ?>"
                                        style="height:200px; object-fit:cover;"
                                    >

                                <?php else: ?>

                                    <div class="bg-light d-flex align-items-center justify-content-center"
                                         style="height:200px;">
                                        <i class="bi bi-image display-3 text-secondary"></i>
                                    </div>

                                <?php endif; ?>

                                <div class="card-body p-4">

                                    <span class="badge bg-light text-primary mb-2">
                                        <?= htmlspecialchars($service['subcategory_name'] ?? 'Category unavailable') ?>
                                    </span>

                                    <h5 class="fw-bold">
                                        <?= htmlspecialchars($service['title']) ?>
                                    </h5>

                                    <p class="text-muted">
                                        <?= htmlspecialchars($service['description']) ?>
                                    </p>

                                    <h5 class="text-primary">
                                        ₹<?= number_format((float) $service['price'], 2) ?>
                                    </h5>

                                    <span class="badge <?= $service['status'] === 'active' ? 'bg-success' : 'bg-secondary' ?>">
                                        <?= htmlspecialchars(ucfirst($service['status'])) ?>
                                    </span>

                                </div>

                            </div>

                        </div>

                    <?php endforeach; ?>

                </div>

            <?php endif; ?>

        </div>

    </div>
</section>

<?php require APP_ROOT . '/app/views/layouts/footer.php'; ?>
