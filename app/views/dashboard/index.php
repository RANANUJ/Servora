
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

                <h1>Welcome, <span id="dashboardWelcomeName"><?= $customerName ?></span></h1>

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

                    <div id="profilePhotoMessage" class="profile-form-message" role="alert"></div>

                    <div class="profile-divider"></div>

                    <!-- PROFILE INFORMATION -->
                    <div class="profile-information">

                        <div class="profile-information-item">

                            <div class="profile-information-icon">
                                <i class="bi bi-person"></i>
                            </div>

                            <div>
                                <span>Full name</span>
                                <strong id="profileInformationName"><?= $customerName ?></strong>
                            </div>

                        </div>

                        <div class="profile-information-item">

                            <div class="profile-information-icon">
                                <i class="bi bi-envelope"></i>
                            </div>

                            <div>
                                <span>Email address</span>
                                <strong id="profileInformationEmail"><?= $customerEmail ?></strong>
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
                                <strong><?= htmlspecialchars($customerRole, ENT_QUOTES, 'UTF-8') ?></strong>
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

                    <!-- BECOME A PROVIDER -->
                    
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


                    </div>

                    <!-- REFERRAL CARD -->
                    <div class="dashboard-card referral-card">

                        <div class="dashboard-card-heading">

                            <div>
                                <span class="section-eyebrow">
                                    SPREAD THE WORD
                                </span>

                                <h2>Invite friends & unlock perks</h2>
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

                <div class="col-md-6">

                    <div class="dashboard-card activity-card">

                        <div class="activity-card-top">
                            <span class="activity-icon activity-orange">
                                <i class="bi bi-calendar-check"></i>
                            </span>

                            <span class="activity-coming-soon">Coming soon</span>
                        </div>

                        <h3>My service requests</h3>

                        <p>
                            Your bookings, callback requests and
                            service enquiries will be organised here.
                        </p>

                    </div>

                </div>

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

                <div class="col-md-6">

                    <div class="dashboard-card activity-card">

                        <div class="activity-card-top">
                            <span class="activity-icon activity-green">
                                <i class="bi bi-star"></i>
                            </span>

                            <span class="activity-coming-soon">Coming soon</span>
                        </div>

                        <h3>My reviews</h3>

                        <p>
                            Share your experience and help other
                            customers choose trusted professionals.
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>


<!-- EDIT PROFILE MODAL -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content profile-edit-modal">

            <div class="modal-header">

                <div>
                    <span class="section-eyebrow">ACCOUNT SETTINGS</span>
                    <h2 class="modal-title">Edit your profile</h2>
                    <p>Keep your personal information up to date.</p>
                </div>

                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>

            </div>

            <div class="modal-body">

                <div id="profileUpdateMessage" class="profile-form-message" role="alert"></div>

                <form id="editProfileForm">

                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8') ?>">

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

                        <button type="submit" class="btn btn-primary" id="saveProfileButton">
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

    // Display success or error messages
    function showMessage(element, message, success) {
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
                            'Content-Type': 'application/x-www-form-urlencoded'
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

                document.getElementById('profileDisplayName').textContent = name;
                document.getElementById('profileDisplayEmail').textContent = email;

                document.getElementById('profileInformationName').textContent = name;
                document.getElementById('profileInformationEmail').textContent = email;
                document.getElementById('profileInformationPhone').textContent = phone;

                document.getElementById('dashboardWelcomeName').textContent = name;

                const initialElement = document.getElementById('dashboardProfileInitial');

                if (initialElement) {
                    initialElement.textContent = initial;
                }

                document.querySelectorAll('.user-profile-name').forEach(function (element) {
                    element.textContent = name;
                });

                document.querySelectorAll('.user-profile-avatar').forEach(function (element) {
                    if (element.tagName !== 'IMG') {
                        element.textContent = initial;
                    }
                });

                showMessage(message, result.message, true);

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

            if (!allowedTypes.includes(file.type)) {

                showMessage(
                    message,
                    'Please select a JPG, PNG or WebP image.',
                    false
                );

                this.value = '';
                return;

            }

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

            showMessage(message, 'Uploading your photo...', true);

            try {

                const response = await fetch(
                    '<?= APP_URL ?>/dashboard/profile/upload-image',
                    {
                        method: 'POST',
                        body: formData
                    }
                );

                const result = await response.json();

                if (!response.ok || !result.success) {
                    throw new Error(
                        result.message || 'Photo upload failed.'
                    );
                }

                const image = document.getElementById('dashboardProfileImage');
                const initial = document.getElementById('dashboardProfileInitial');

                image.src = result.image + '?t=' + Date.now();
                image.style.display = 'block';

                if (initial) {
                    initial.style.display = 'none';
                }

                showMessage(message, result.message, true);

            } catch (error) {

                showMessage(message, error.message, false);

            } finally {

                this.value = '';

            }

        });

    }


    // =====================================
    // BECOME A PROVIDER
    // =====================================



</script>

<?php include APP_ROOT . '/app/views/layouts/footer.php'; ?>
