
<?php

// Generate a CSRF token if one does not already exist
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$csrfToken = $_SESSION['csrf_token'];

// Safely prepare customer information
$customerName = htmlspecialchars($user['name'], ENT_QUOTES, 'UTF-8');
$customerEmail = htmlspecialchars($user['email'], ENT_QUOTES, 'UTF-8');
$customerPhone = htmlspecialchars($user['phone'] ?? '', ENT_QUOTES, 'UTF-8');

$customerRole = ucfirst($user['role']);
$customerStatus = ucfirst($user['status']);

$firstInitial = strtoupper(substr($user['name'], 0, 1));

// Prepare profile photo URL
$profileImageUrl = !empty($user['profile_image'])
    ? APP_URL . '/' . $user['profile_image']
    : null;

// Customer bookings
$bookings = $bookings ?? [];
$bookingCount = count($bookings);

include APP_ROOT . '/app/views/layouts/header.php';

?>

<section class="customer-dashboard">

    <div class="container">

        <!-- DASHBOARD WELCOME -->
        <div class="dashboard-welcome">

            <div>
                <span class="dashboard-eyebrow">
                    <i class="bi bi-grid-1x2"></i>
                    CUSTOMER DASHBOARD
                </span>

                <h1>
                    Welcome,
                    <span id="dashboardWelcomeName"><?= $customerName ?></span>
                </h1>

                <p>
                    Manage your account, discover professionals
                    and keep track of your activity.
                </p>
            </div>

            <div class="dashboard-account-status">
                <span class="status-dot"></span>
                Account <?= htmlspecialchars($customerStatus, ENT_QUOTES, 'UTF-8') ?>
            </div>

        </div>

        <!-- MAIN DASHBOARD ROW -->
        <div class="row g-4">

            <!-- LEFT COLUMN: PROFILE -->
            <div class="col-lg-5">

                <div class="dashboard-card profile-card">

                    <div class="dashboard-card-heading">

                        <div>
                            <span class="section-eyebrow">YOUR ACCOUNT</span>
                            <h2>My profile</h2>
                        </div>

                        <span class="card-heading-icon">
                            <i class="bi bi-person"></i>
                        </span>

                    </div>

                    <!-- PROFILE IDENTITY -->
                    <div class="profile-identity">

                        <div class="profile-avatar profile-avatar-photo">

                            <?php if ($profileImageUrl): ?>

                                <img
                                    src="<?= htmlspecialchars($profileImageUrl, ENT_QUOTES, 'UTF-8') ?>"
                                    id="dashboardProfileImage"
                                    alt="Profile photo"
                                >

                            <?php else: ?>

                                <span id="dashboardProfileInitial">
                                    <?= htmlspecialchars($firstInitial, ENT_QUOTES, 'UTF-8') ?>
                                </span>

                                <img
                                    src=""
                                    id="dashboardProfileImage"
                                    alt="Profile photo"
                                    style="display:none;"
                                >

                            <?php endif; ?>

                        </div>

                        <div class="profile-identity-info">

                            <h3 id="profileDisplayName"><?= $customerName ?></h3>

                            <p id="profileDisplayEmail"><?= $customerEmail ?></p>

                            <span class="profile-verified-label">
                                <i class="bi bi-check-circle-fill"></i>
                                Registered customer
                            </span>

                            <div class="profile-photo-actions">

                                <label for="profileImageInput" class="profile-photo-button">
                                    <i class="bi bi-camera"></i>
                                    Change Photo
                                </label>

                                <input
                                    type="file"
                                    id="profileImageInput"
                                    accept="image/jpeg,image/png,image/webp"
                                    hidden
                                >

                                <small>JPG, PNG or WebP · Max 2 MB</small>

                            </div>

                        </div>

                    </div>

                    <div
                        id="profilePhotoMessage"
                        class="profile-form-message"
                        role="alert"
                    ></div>

                    <div class="profile-divider"></div>

                    <!-- PROFILE INFORMATION -->
                    <div class="profile-information">

                        <div class="profile-information-item">

                            <div class="profile-information-icon">
                                <i class="bi bi-person"></i>
                            </div>

                            <div>
                                <span>Full name</span>
                                <strong id="profileInformationName">
                                    <?= $customerName ?>
                                </strong>
                            </div>

                        </div>

                        <div class="profile-information-item">

                            <div class="profile-information-icon">
                                <i class="bi bi-envelope"></i>
                            </div>

                            <div>
                                <span>Email address</span>
                                <strong id="profileInformationEmail">
                                    <?= $customerEmail ?>
                                </strong>
                            </div>

                        </div>

                        <div class="profile-information-item">

                            <div class="profile-information-icon">
                                <i class="bi bi-telephone"></i>
                            </div>

                            <div>
                                <span>Phone number</span>
                                <strong id="profileInformationPhone">
                                    <?= $customerPhone !== '' ? $customerPhone : 'Not added yet' ?>
                                </strong>
                            </div>

                        </div>

                        <div class="profile-information-item">

                            <div class="profile-information-icon">
                                <i class="bi bi-shield-check"></i>
                            </div>

                            <div>
                                <span>Your account role</span>
                                <strong>
                                    <?= htmlspecialchars($customerRole, ENT_QUOTES, 'UTF-8') ?>
                                </strong>
                            </div>

                        </div>

                    </div>

                    <button
                        type="button"
                        class="btn btn-primary profile-edit-button"
                        data-bs-toggle="modal"
                        data-bs-target="#editProfileModal"
                    >
                        <i class="bi bi-pencil-square me-2"></i>
                        Edit Profile
                    </button>

                </div>

            </div>

            <!-- RIGHT COLUMN -->
            <div class="col-lg-7">

                <div class="dashboard-right-column">

                    <!-- PROVIDER CARD -->
                    <div class="dashboard-card provider-card">

                        <div class="provider-card-content">

                            <?php if (!empty($provider) && $provider['status'] === 'active'): ?>

                                <span class="section-eyebrow provider-eyebrow">
                                    <i class="bi bi-briefcase"></i>
                                    YOUR BUSINESS
                                </span>

                                <h2>
                                    Welcome to your provider workspace.
                                </h2>

                                <p>
                                    Your business
                                    <strong>
                                        <?= htmlspecialchars($provider['business_name'], ENT_QUOTES, 'UTF-8') ?>
                                    </strong>
                                    is active on Servora. Manage your professional
                                    presence and connect with customers.
                                </p>

                                <div class="provider-card-bottom">

                                    <a
                                        href="<?= APP_URL ?>/provider/dashboard"
                                        class="btn btn-primary"
                                    >
                                        Manage Provider Dashboard
                                        <i class="bi bi-arrow-up-right ms-2"></i>
                                    </a>

                                </div>

                            <?php elseif (!empty($provider) && $provider['status'] === 'suspended'): ?>

                                <span class="section-eyebrow provider-eyebrow">
                                    <i class="bi bi-exclamation-circle"></i>
                                    PROVIDER ACCOUNT
                                </span>

                                <h2>Your provider account is suspended.</h2>

                                <p>
                                    Your provider profile is currently unavailable.
                                    Please contact Servora support for assistance.
                                </p>

                            <?php else: ?>

                                <span class="section-eyebrow provider-eyebrow">
                                    <i class="bi bi-briefcase"></i>
                                    FOR PROFESSIONALS
                                </span>

                                <h2>
                                    Turn your skills into opportunities.
                                </h2>

                                <p>
                                    Build your presence on Servora and connect with
                                    customers looking for your services.
                                </p>

                                <div class="provider-card-bottom">

                                    <a
                                        href="<?= APP_URL ?>/dashboard/become-provider"
                                        class="btn btn-primary"
                                    >
                                        Become a Provider
                                        <i class="bi bi-arrow-up-right ms-2"></i>
                                    </a>

                                </div>

                            <?php endif; ?>

                        </div>

                        <div class="provider-card-art">

                            <div class="provider-art-circle">
                                <i class="bi bi-shop-window"></i>
                            </div>

                            <span class="provider-art-star star-one">
                                <i class="bi bi-stars"></i>
                            </span>

                            <span class="provider-art-star star-two">
                                <i class="bi bi-plus-circle-fill"></i>
                            </span>

                        </div>

                    </div>

                    <!-- REFERRAL CARD -->
                    <div class="dashboard-card referral-card">

                        <div class="dashboard-card-heading">

                            <div>
                                <span class="section-eyebrow">
                                    SPREAD THE WORD
                                </span>

                                <h2>Invite friends &amp; unlock perks</h2>
                            </div>

                            <span class="card-heading-icon referral-heading-icon">
                                <i class="bi bi-gift"></i>
                            </span>

                        </div>

                        <p class="referral-description">
                            Share Servora with friends and family.
                            Help more people discover trusted local
                            professionals in their neighbourhood.
                        </p>

                        <div class="referral-benefits">

                            <div class="referral-benefit">

                                <span class="referral-benefit-icon">
                                    <i class="bi bi-stars"></i>
                                </span>

                                <div>
                                    <h3>Community rewards</h3>
                                    <p>
                                        Referral rewards are planned
                                        for a future update.
                                    </p>
                                </div>

                            </div>

                            <div class="referral-benefit">

                                <span class="referral-benefit-icon">
                                    <i class="bi bi-rocket-takeoff"></i>
                                </span>

                                <div>
                                    <h3>Discover what's new</h3>
                                    <p>
                                        Stay informed as Servora
                                        expands into more locations.
                                    </p>
                                </div>

                            </div>

                        </div>

                        <div class="referral-coming-soon">
                            <i class="bi bi-clock"></i>
                            Referral programme coming soon
                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!-- CUSTOMER ACTIVITY -->
        <div class="dashboard-activity-section">

            <div class="activity-section-heading">

                <div>
                    <span class="section-eyebrow">YOUR SERVORA JOURNEY</span>
                    <h2>Your activity</h2>
                    <p>
                        Everything related to your service activity
                        in one place.
                    </p>
                </div>

                <a href="<?= APP_URL ?>/services" class="activity-explore-link">
                    Explore services
                    <i class="bi bi-arrow-up-right"></i>
                </a>

            </div>

            <div class="row g-4">

                <!-- POSTED REQUIREMENTS -->
                <div class="col-md-6">

                    <div class="dashboard-card activity-card">

                        <div class="activity-card-top">
                            <span class="activity-icon activity-blue">
                                <i class="bi bi-clipboard-check"></i>
                            </span>

                            <span class="activity-coming-soon">Coming soon</span>
                        </div>

                        <h3>My posted requirements</h3>

                        <p>
                            Need help with something? Soon you'll be
                            able to post a requirement and hear from
                            multiple service providers.
                        </p>

                    </div>

                </div>

                <!-- MY SERVICE REQUESTS -->
                <div class="col-md-6">

                    <a
                        href="#myServiceRequests"
                        class="dashboard-card activity-card"
                        style="display:block; text-decoration:none; color:inherit;"
                    >

                        <div class="activity-card-top">

                            <span class="activity-icon activity-orange">
                                <i class="bi bi-calendar-check"></i>
                            </span>

                            <span class="activity-coming-soon">
                                <?= $bookingCount ?> bookings
                            </span>

                        </div>

                        <h3>My service requests</h3>

                        <p>
                            View your bookings, check appointment details
                            and track the latest status of your requests.
                        </p>

                        <span style="color:var(--primary); font-weight:600;">
                            View my bookings
                            <i class="bi bi-arrow-right ms-1"></i>
                        </span>

                    </a>

                </div>

                <!-- FAVOURITE PROVIDERS -->
                <div class="col-md-6">

                    <div class="dashboard-card activity-card">

                        <div class="activity-card-top">
                            <span class="activity-icon activity-pink">
                                <i class="bi bi-heart"></i>
                            </span>

                            <span class="activity-coming-soon">Coming soon</span>
                        </div>

                        <h3>Favourite providers</h3>

                        <p>
                            Save professionals you like and quickly
                            find them again whenever you need a service.
                        </p>

                    </div>

                </div>

               <!-- MY REVIEWS -->
<div class="col-md-6">

    <a
        href="<?= APP_URL ?>/dashboard/my-reviews"
        class="dashboard-card activity-card"
        style="display:block; text-decoration:none; color:inherit;"
    >

        <div class="activity-card-top">

            <span class="activity-icon activity-green">
                <i class="bi bi-star"></i>
            </span>

            <span class="activity-coming-soon">
                View reviews
            </span>

        </div>

        <h3>My reviews</h3>

        <p>
            View all the ratings and reviews you've shared
            about your completed services.
        </p>

        <span style="color:var(--primary); font-weight:600;">
            View my reviews
            <i class="bi bi-arrow-right ms-1"></i>
        </span>

    </a>

</div>

            </div>

            <!-- MY SERVICE REQUESTS LIST -->
            <div id="myServiceRequests" style="margin-top:45px;">

                <div class="activity-section-heading">

                    <div>
                        <span class="section-eyebrow">BOOKING MANAGEMENT</span>
                        <h2>My service requests</h2>
                        <p>
                            Track your appointments and booking updates.
                        </p>
                    </div>

                    <span class="activity-explore-link">
                        <?= $bookingCount ?> total bookings
                    </span>

                </div>

                <?php if (!empty($bookings)): ?>

                    <div class="row g-4">

                        <?php foreach ($bookings as $booking): ?>

                            <?php

                            $serviceTitle = htmlspecialchars(
                                $booking['service_title'],
                                ENT_QUOTES,
                                'UTF-8'
                            );

                            $businessName = htmlspecialchars(
                                $booking['business_name'] ?: $booking['provider_name'],
                                ENT_QUOTES,
                                'UTF-8'
                            );

                            $bookingNumber = htmlspecialchars(
                                $booking['booking_number'],
                                ENT_QUOTES,
                                'UTF-8'
                            );

                            $bookingStatus = $booking['status'];

                            $statusClass = match ($bookingStatus) {
                                'pending' => 'warning',
                                'accepted' => 'success',
                                'in_progress' => 'primary',
                                'completed' => 'success',
                                'rejected' => 'danger',
                                'cancelled' => 'secondary',
                                default => 'secondary'
                            };

                            $serviceImage = !empty($booking['service_image'])
                                ? APP_URL . '/' . $booking['service_image']
                                : null;

                            ?>

                            <div class="col-lg-6">

                                <div class="dashboard-card" style="height:100%;">

                                    <!-- SERVICE INFORMATION -->
                                    <div style="display:flex; gap:15px; align-items:center; margin-bottom:20px;">

                                        <?php if ($serviceImage): ?>

                                            <img
                                                src="<?= htmlspecialchars($serviceImage, ENT_QUOTES, 'UTF-8') ?>"
                                                alt="<?= $serviceTitle ?>"
                                                style="width:85px; height:75px; object-fit:cover; border-radius:12px;"
                                            >

                                        <?php else: ?>

                                            <div style="width:85px; height:75px; border-radius:12px; background:var(--light); display:flex; align-items:center; justify-content:center;">
                                                <i class="bi bi-tools" style="font-size:28px; color:var(--primary);"></i>
                                            </div>

                                        <?php endif; ?>

                                        <div>

                                            <h3 style="font-size:18px; margin-bottom:5px;">
                                                <?= $serviceTitle ?>
                                            </h3>

                                            <p style="margin:0; color:var(--text);">
                                                <?= $businessName ?>
                                            </p>

                                        </div>

                                    </div>

                                    <div style="border-top:1px solid var(--border); padding-top:15px;">

                                        <div style="display:flex; justify-content:space-between; gap:10px; margin-bottom:12px;">

                                            <span style="color:var(--text);">
                                                Booking number
                                            </span>

                                            <strong>
                                                #<?= $bookingNumber ?>
                                            </strong>

                                        </div>

                                        <div style="display:flex; justify-content:space-between; gap:10px; margin-bottom:12px;">

                                            <span style="color:var(--text);">
                                                Appointment
                                            </span>

                                            <strong>
                                                <?= htmlspecialchars(date('d M Y', strtotime($booking['booking_date'])), ENT_QUOTES, 'UTF-8') ?>
                                            </strong>

                                        </div>

                                        <div style="display:flex; justify-content:space-between; gap:10px; margin-bottom:12px;">

                                            <span style="color:var(--text);">
                                                Time
                                            </span>

                                            <strong>
                                                <?= htmlspecialchars(date('h:i A', strtotime($booking['booking_time'])), ENT_QUOTES, 'UTF-8') ?>
                                            </strong>

                                        </div>

                                        <div style="display:flex; justify-content:space-between; gap:10px; margin-bottom:15px;">

                                            <span style="color:var(--text);">
                                                Amount
                                            </span>

                                            <strong>
                                                ₹<?= number_format((float)$booking['price'], 2) ?>
                                            </strong>

                                        </div>

                                        <div style="display:flex; justify-content:space-between; align-items:center; gap:10px;">

                                            <span class="badge text-bg-<?= $statusClass ?>" style="padding:8px 12px;">
                                                <?= htmlspecialchars(ucwords(str_replace('_', ' ', $bookingStatus)), ENT_QUOTES, 'UTF-8') ?>
                                            </span>

                                            <a
                                                href="<?= APP_URL ?>/booking/details?number=<?= urlencode($booking['booking_number']) ?>"
                                                class="btn btn-primary btn-sm"
                                            >
                                                View Details
                                                <i class="bi bi-arrow-right ms-1"></i>
                                            </a>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        <?php endforeach; ?>

                    </div>

                <?php else: ?>

                    <!-- EMPTY BOOKINGS STATE -->
                    <div class="dashboard-card" style="text-align:center; padding:45px 20px;">

                        <div style="font-size:45px; color:var(--primary); margin-bottom:15px;">
                            <i class="bi bi-calendar2-x"></i>
                        </div>

                        <h3 style="font-size:21px; margin-bottom:10px;">
                            No service requests yet
                        </h3>

                        <p style="color:var(--text); max-width:450px; margin:0 auto 20px;">
                            You haven't booked any services yet.
                            Explore Servora and find professionals
                            who can help you.
                        </p>

                        <a
                            href="<?= APP_URL ?>/services"
                            class="btn btn-primary"
                        >
                            Explore Services
                            <i class="bi bi-arrow-right ms-2"></i>
                        </a>

                    </div>

                <?php endif; ?>

            </div>

        </div>

    </div>

</section>


<!-- EDIT PROFILE MODAL -->
<div
    class="modal fade"
    id="editProfileModal"
    tabindex="-1"
    aria-hidden="true"
>

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content profile-edit-modal">

            <div class="modal-header">

                <div>
                    <span class="section-eyebrow">ACCOUNT SETTINGS</span>
                    <h2 class="modal-title">Edit your profile</h2>
                    <p>Keep your personal information up to date.</p>
                </div>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                ></button>

            </div>

            <div class="modal-body">

                <div
                    id="profileUpdateMessage"
                    class="profile-form-message"
                    role="alert"
                ></div>

                <form id="editProfileForm">

                    <input
                        type="hidden"
                        name="csrf_token"
                        value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8') ?>"
                    >

                    <div class="mb-3">

                        <label for="editProfileName" class="form-label">
                            Full name
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            id="editProfileName"
                            name="name"
                            value="<?= $customerName ?>"
                            maxlength="100"
                            required
                        >

                    </div>

                    <div class="mb-3">

                        <label for="editProfileEmail" class="form-label">
                            Email address
                        </label>

                        <input
                            type="email"
                            class="form-control"
                            id="editProfileEmail"
                            name="email"
                            value="<?= $customerEmail ?>"
                            maxlength="255"
                            required
                        >

                    </div>

                    <div class="mb-3">

                        <label for="editProfilePhone" class="form-label">
                            Phone number
                        </label>

                        <input
                            type="tel"
                            class="form-control"
                            id="editProfilePhone"
                            name="phone"
                            value="<?= $customerPhone ?>"
                            maxlength="20"
                            placeholder="Enter your phone number"
                        >

                    </div>

                    <div class="profile-modal-actions">

                        <button
                            type="button"
                            class="btn btn-light"
                            data-bs-dismiss="modal"
                        >
                            Cancel
                        </button>

                        <button
                            type="submit"
                            class="btn btn-primary"
                            id="saveProfileButton"
                        >
                            <i class="bi bi-check2 me-1"></i>
                            Save Changes
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>


<script>

document.addEventListener('DOMContentLoaded', function () {

    // =====================================
    // DISPLAY SUCCESS OR ERROR MESSAGES
    // =====================================

    function showMessage(element, message, success) {

        if (!element) {
            return;
        }

        element.className = 'profile-form-message ' +
            (success ? 'success' : 'error');

        element.textContent = message;
        element.style.display = 'block';

    }


    // =====================================
    // UPDATE CUSTOMER PROFILE
    // =====================================

    const profileForm = document.getElementById('editProfileForm');

    if (profileForm) {

        profileForm.addEventListener('submit', async function (event) {

            event.preventDefault();

            const button = document.getElementById('saveProfileButton');
            const message = document.getElementById('profileUpdateMessage');

            const originalButtonText = button.innerHTML;

            button.disabled = true;
            button.textContent = 'Saving...';

            try {

                const formData = new URLSearchParams(
                    new FormData(profileForm)
                );

                const response = await fetch(
                    '<?= APP_URL ?>/dashboard/profile/update',
                    {
                        method: 'POST',

                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                            'Accept': 'application/json'
                        },

                        body: formData
                    }
                );

                const result = await response.json();

                if (!response.ok || !result.success) {

                    throw new Error(
                        result.message || 'Unable to update profile.'
                    );

                }

                const name = result.user.name;
                const email = result.user.email;
                const phone = result.user.phone || 'Not added yet';
                const initial = name.charAt(0).toUpperCase();

                // Update profile identity
                document.getElementById('profileDisplayName').textContent = name;
                document.getElementById('profileDisplayEmail').textContent = email;

                // Update profile information
                document.getElementById('profileInformationName').textContent = name;
                document.getElementById('profileInformationEmail').textContent = email;
                document.getElementById('profileInformationPhone').textContent = phone;

                // Update dashboard welcome heading
                document.getElementById('dashboardWelcomeName').textContent = name;

                // Update profile initial
                const initialElement = document.getElementById('dashboardProfileInitial');

                if (initialElement) {
                    initialElement.textContent = initial;
                }

                // Update header profile names
                document.querySelectorAll('.user-profile-name').forEach(function (element) {
                    element.textContent = name;
                });

                // Update header profile avatars
                document.querySelectorAll('.user-profile-avatar').forEach(function (element) {

                    if (element.tagName !== 'IMG') {
                        element.textContent = initial;
                    }

                });

                showMessage(message, result.message, true);

                // Close modal after successful update
                setTimeout(function () {

                    const modalElement = document.getElementById('editProfileModal');

                    if (window.bootstrap) {

                        const modal = bootstrap.Modal.getInstance(modalElement);

                        if (modal) {
                            modal.hide();
                        }

                    }

                    message.style.display = 'none';

                }, 1200);

            } catch (error) {

                showMessage(message, error.message, false);

            } finally {

                button.disabled = false;
                button.innerHTML = originalButtonText;

            }

        });

    }


    // =====================================
    // UPLOAD PROFILE PHOTO
    // =====================================

    const imageInput = document.getElementById('profileImageInput');

    if (imageInput) {

        imageInput.addEventListener('change', async function () {

            const file = this.files[0];

            if (!file) {
                return;
            }

            const message = document.getElementById('profilePhotoMessage');

            const allowedTypes = [
                'image/jpeg',
                'image/png',
                'image/webp'
            ];

            // Validate image format
            if (!allowedTypes.includes(file.type)) {

                showMessage(
                    message,
                    'Please select a JPG, PNG or WebP image.',
                    false
                );

                this.value = '';
                return;

            }

            // Validate image size
            if (file.size > 2 * 1024 * 1024) {

                showMessage(
                    message,
                    'Image size must not exceed 2 MB.',
                    false
                );

                this.value = '';
                return;

            }

            const formData = new FormData();

            formData.append('profile_image', file);

            formData.append(
                'csrf_token',
                '<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8') ?>'
            );

            showMessage(
                message,
                'Uploading your photo...',
                true
            );

            try {

                const response = await fetch(
                    '<?= APP_URL ?>/dashboard/profile/upload-image',
                    {
                        method: 'POST',

                        headers: {
                            'Accept': 'application/json'
                        },

                        body: formData
                    }
                );

                const result = await response.json();

                if (!response.ok || !result.success) {

                    throw new Error(
                        result.message || 'Photo upload failed.'
                    );

                }

                // Update profile image
                const image = document.getElementById('dashboardProfileImage');
                const initial = document.getElementById('dashboardProfileInitial');

                image.src = result.image + '?t=' + Date.now();
                image.style.display = 'block';

                if (initial) {
                    initial.style.display = 'none';
                }

                showMessage(
                    message,
                    result.message,
                    true
                );

            } catch (error) {

                showMessage(
                    message,
                    error.message,
                    false
                );

            } finally {

                this.value = '';

            }

        });

    }

});

</script>

<?php include APP_ROOT . '/app/views/layouts/footer.php'; ?>
