
<?php

require APP_ROOT . '/app/views/layouts/header.php';

$providerName = htmlspecialchars(
    $provider['business_name'],
    ENT_QUOTES,
    'UTF-8'
);

$providerDescription = htmlspecialchars(
    $provider['description'],
    ENT_QUOTES,
    'UTF-8'
);

$providerCity = htmlspecialchars(
    $provider['city'],
    ENT_QUOTES,
    'UTF-8'
);

$providerState = htmlspecialchars(
    $provider['state'],
    ENT_QUOTES,
    'UTF-8'
);

?>

<section class="customer-dashboard">

    <div class="container">

        <!-- DASHBOARD WELCOME -->
        <div class="dashboard-welcome">

            <div>

                <span class="dashboard-eyebrow">
                    <i class="bi bi-briefcase"></i>
                    PROVIDER DASHBOARD
                </span>

                <h1>
                    Welcome, <?= $providerName ?>
                </h1>

                <p>
                    Manage your business, services and customer
                    enquiries from one place.
                </p>

            </div>

            <div class="dashboard-account-status">
                <span class="status-dot"></span>
                Provider Active
            </div>

        </div>


        <!-- BUSINESS OVERVIEW -->
        <div class="row g-4">

            <div class="col-lg-8">

                <div class="dashboard-card profile-card">

                    <div class="dashboard-card-heading">

                        <div>
                            <span class="section-eyebrow">
                                BUSINESS OVERVIEW
                            </span>

                            <h2>
                                Your business profile
                            </h2>
                        </div>

                        <span class="card-heading-icon">
                            <i class="bi bi-shop"></i>
                        </span>

                    </div>


                    <div class="profile-information">

                        <div class="profile-information-item">

                            <div class="profile-information-icon">
                                <i class="bi bi-building"></i>
                            </div>

                            <div>
                                <span>Business name</span>
                                <strong><?= $providerName ?></strong>
                            </div>

                        </div>


                        <div class="profile-information-item">

                            <div class="profile-information-icon">
                                <i class="bi bi-geo-alt"></i>
                            </div>

                            <div>
                                <span>Business location</span>

                                <strong>
                                    <?= $providerCity ?>,
                                    <?= $providerState ?>
                                </strong>
                            </div>

                        </div>


                        <div class="profile-information-item">

                            <div class="profile-information-icon">
                                <i class="bi bi-card-text"></i>
                            </div>

                            <div>
                                <span>Business description</span>

                                <strong>
                                    <?= $providerDescription ?>
                                </strong>
                            </div>

                        </div>


                        <div class="profile-information-item">

                            <div class="profile-information-icon">
                                <i class="bi bi-person"></i>
                            </div>

                            <div>
                                <span>Account owner</span>

                                <strong>
                                    <?= htmlspecialchars(
                                        $user['name'],
                                        ENT_QUOTES,
                                        'UTF-8'
                                    ) ?>
                                </strong>
                            </div>

                        </div>

                    </div>

                </div>

            </div>


            <!-- PROVIDER STATUS -->
            <div class="col-lg-4">

                <div class="dashboard-card activity-card h-100">

                    <div class="activity-card-top">

                        <span class="activity-icon activity-green">
                            <i class="bi bi-shield-check"></i>
                        </span>

                        <span class="activity-coming-soon">
                            Active
                        </span>

                    </div>

                    <h3>
                        Your provider account is active
                    </h3>

                    <p>
                        Your business profile is successfully
                        registered on Servora.
                    </p>

                    <a
                        href="<?= APP_URL ?>/dashboard"
                        class="activity-explore-link"
                    >
                        Go to Customer Dashboard
                        <i class="bi bi-arrow-up-right"></i>
                    </a>

                </div>

            </div>

        </div>


        <!-- PROVIDER MANAGEMENT -->
        <div class="dashboard-activity-section">

            <div class="activity-section-heading">

                <div>

                    <span class="section-eyebrow">
                        BUSINESS MANAGEMENT
                    </span>

                    <h2>
                        Manage your business
                    </h2>

                    <p>
                        Everything you need to grow your business
                        on Servora.
                    </p>

                </div>

            </div>


            <div class="row g-4">

                <!-- SERVICES -->
                <div class="col-md-6">

                    <div class="dashboard-card activity-card">

                        <div class="activity-card-top">

                            <span class="activity-icon activity-blue">
                                <i class="bi bi-tools"></i>
                            </span>

                            <span class="activity-coming-soon">
                                Coming soon
                            </span>

                        </div>

                        <h3>
                            My Services
                        </h3>

                        <p>
                            Add, edit and manage the services
                            your business offers to customers.
                        </p>

                    </div>

                </div>


                <!-- BOOKINGS -->
                <div class="col-md-6">

                    <div class="dashboard-card activity-card">

                        <div class="activity-card-top">

                            <span class="activity-icon activity-orange">
                                <i class="bi bi-calendar-check"></i>
                            </span>

                            <span class="activity-coming-soon">
                                Coming soon
                            </span>

                        </div>

                        <h3>
                            Customer Bookings
                        </h3>

                        <p>
                            View booking requests and manage
                            your upcoming customer appointments.
                        </p>

                    </div>

                </div>


                <!-- EARNINGS -->
                <div class="col-md-6">

                    <div class="dashboard-card activity-card">

                        <div class="activity-card-top">

                            <span class="activity-icon activity-green">
                                <i class="bi bi-wallet2"></i>
                            </span>

                            <span class="activity-coming-soon">
                                Coming soon
                            </span>

                        </div>

                        <h3>
                            Earnings
                        </h3>

                        <p>
                            Track your business income and
                            payment activity.
                        </p>

                    </div>

                </div>


                <!-- REVIEWS -->
                <div class="col-md-6">

                    <div class="dashboard-card activity-card">

                        <div class="activity-card-top">

                            <span class="activity-icon activity-pink">
                                <i class="bi bi-star"></i>
                            </span>

                            <span class="activity-coming-soon">
                                Coming soon
                            </span>

                        </div>

                        <h3>
                            Customer Reviews
                        </h3>

                        <p>
                            Read customer feedback and build
                            trust with your future customers.
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>

<?php require APP_ROOT . '/app/views/layouts/footer.php'; ?>
