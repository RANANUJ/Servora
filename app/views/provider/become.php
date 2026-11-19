
<?php

require APP_ROOT . '/app/views/layouts/header.php';

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$csrfToken = $_SESSION['csrf_token'];

?>

<section class="container py-5">

    <div class="row justify-content-center">

        <div class="col-lg-8 col-xl-7">

            <div class="mb-4">

                <span class="badge bg-primary-subtle text-primary mb-3">
                    SERVORA PARTNER
                </span>

                <h1 class="fw-bold mb-2">
                    Become a Service Provider
                </h1>

                <p class="text-muted">
                    Introduce your business to customers and start
                    offering your services through Servora.
                </p>

            </div>


            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body p-4 p-md-5">

                    <div class="mb-4">

                        <h4 class="fw-bold">
                            Business Information
                        </h4>

                        <p class="text-muted small">
                            Enter accurate details about your business.
                        </p>

                    </div>


                    <form id="becomeProviderForm">

                        <input
                            type="hidden"
                            name="csrf_token"
                            value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8') ?>"
                        >


                        <!-- BUSINESS NAME -->
                        <div class="mb-3">

                            <label class="form-label fw-semibold">
                                Business Name
                            </label>

                            <input
                                type="text"
                                name="business_name"
                                class="form-control form-control-lg"
                                placeholder="Example: Sharma Home Services"
                                maxlength="150"
                                required
                            >

                        </div>


                        <!-- MAIN BUSINESS CATEGORY -->
                        <div class="mb-3">

                            <label class="form-label fw-semibold">
                                Business Category
                            </label>

                            <select
                                name="main_category_id"
                                id="mainCategory"
                                class="form-select form-select-lg"
                                required
                            >

                                <option value="">
                                    Select Main Category
                                </option>

                                <?php foreach ($categories as $category): ?>

                                    <option value="<?= (int) $category['id'] ?>">
                                        <?= htmlspecialchars($category['name'], ENT_QUOTES, 'UTF-8') ?>
                                    </option>

                                <?php endforeach; ?>

                            </select>

                            <div class="form-text">
                                Select the main category that describes your business.
                            </div>

                        </div>


                        <!-- BUSINESS SUBCATEGORY -->
                        <div class="mb-3">

                            <label class="form-label fw-semibold">
                                Business Subcategory
                            </label>

                            <select
                                name="category_id"
                                id="subCategory"
                                class="form-select form-select-lg"
                                required
                                disabled
                            >

                                <option value="">
                                    Select a main category first
                                </option>

                            </select>

                            <div class="form-text">
                                Choose the specific type of business you operate.
                            </div>

                        </div>


                        <!-- BUSINESS DESCRIPTION -->
                        <div class="mb-3">

                            <label class="form-label fw-semibold">
                                Business Description
                            </label>

                            <textarea
                                name="description"
                                class="form-control"
                                rows="5"
                                minlength="30"
                                maxlength="2000"
                                placeholder="Tell customers about your business and the services you provide..."
                                required
                            ></textarea>

                            <div class="form-text">
                                Minimum 30 characters.
                            </div>

                        </div>


                        <!-- BUSINESS ADDRESS -->
                        <div class="mb-3">

                            <label class="form-label fw-semibold">
                                Business Address
                            </label>

                            <textarea
                                name="address"
                                class="form-control"
                                rows="2"
                                maxlength="255"
                                placeholder="Enter your complete business address"
                                required
                            ></textarea>

                        </div>


                        <!-- CITY AND STATE -->
                        <div class="row">

                            <div class="col-md-6 mb-3">

                                <label class="form-label fw-semibold">
                                    City
                                </label>

                                <input
                                    type="text"
                                    name="city"
                                    class="form-control form-control-lg"
                                    placeholder="Enter city"
                                    maxlength="100"
                                    required
                                >

                            </div>


                            <div class="col-md-6 mb-3">

                                <label class="form-label fw-semibold">
                                    State
                                </label>

                                <input
                                    type="text"
                                    name="state"
                                    class="form-control form-control-lg"
                                    placeholder="Enter state"
                                    maxlength="100"
                                    required
                                >

                            </div>

                        </div>


                        <!-- PIN CODE -->
                        <div class="mb-4">

                            <label class="form-label fw-semibold">
                                PIN Code
                            </label>

                            <input
                                type="text"
                                name="pincode"
                                class="form-control form-control-lg"
                                placeholder="6-digit PIN code"
                                maxlength="6"
                                pattern="[0-9]{6}"
                                inputmode="numeric"
                                required
                            >

                        </div>


                        <!-- RESPONSE MESSAGE -->
                        <div
                            id="providerFormMessage"
                            class="alert d-none"
                            role="alert"
                        ></div>


                        <!-- SUBMIT BUTTON -->
                        <button
                            type="submit"
                            id="providerSubmitButton"
                            class="btn btn-primary btn-lg w-100"
                        >
                            Create Provider Profile
                            <i class="bi bi-arrow-right ms-2"></i>
                        </button>


                        <p class="text-muted small text-center mt-3 mb-0">
                            Your customer account will remain active.
                        </p>

                    </form>

                </div>

            </div>

        </div>

    </div>

</section>


<script>
document.addEventListener('DOMContentLoaded', function () {

    const form = document.getElementById('becomeProviderForm');

    const messageBox = document.getElementById('providerFormMessage');

    const submitButton = document.getElementById('providerSubmitButton');

    const mainCategory = document.getElementById('mainCategory');

    const subCategory = document.getElementById('subCategory');


    // Load subcategories when main category changes
    mainCategory.addEventListener('change', async function () {

        const parentId = this.value;

        // Reset the subcategory dropdown
        subCategory.innerHTML = '';

        const defaultOption = document.createElement('option');

        defaultOption.value = '';
        defaultOption.textContent = 'Loading subcategories...';

        subCategory.appendChild(defaultOption);

        subCategory.disabled = true;


        // Stop if no main category is selected
        if (!parentId) {

            defaultOption.textContent = 'Select a main category first';

            return;

        }


        try {

            const response = await fetch(
                '<?= APP_URL ?>/dashboard/provider-subcategories?parent_id=' +
                encodeURIComponent(parentId)
            );

            const result = await response.json();


            if (!response.ok || !result.success) {

                throw new Error(
                    result.message || 'Unable to load subcategories.'
                );

            }


            // Clear loading option
            subCategory.innerHTML = '';


            if (result.subcategories.length === 0) {

                const option = document.createElement('option');

                option.value = '';
                option.textContent = 'No subcategories available';

                subCategory.appendChild(option);

                return;

            }


            // Add default option
            const placeholder = document.createElement('option');

            placeholder.value = '';
            placeholder.textContent = 'Select Business Subcategory';

            subCategory.appendChild(placeholder);


            // Add subcategories from database
            result.subcategories.forEach(function (category) {

                const option = document.createElement('option');

                option.value = category.id;

                option.textContent = category.name;

                subCategory.appendChild(option);

            });


            subCategory.disabled = false;


        } catch (error) {

            subCategory.innerHTML = '';

            const option = document.createElement('option');

            option.value = '';
            option.textContent = 'Unable to load subcategories';

            subCategory.appendChild(option);

            console.error(error);

        }

    });


    // Submit provider form
    form.addEventListener('submit', async function (event) {

        event.preventDefault();

        messageBox.classList.add('d-none');

        submitButton.disabled = true;

        submitButton.innerHTML = 'Creating your profile...';


        try {

            const formData = new FormData(form);

            const response = await fetch(
                '<?= APP_URL ?>/dashboard/become-provider',
                {
                    method: 'POST',
                    body: formData
                }
            );


            const result = await response.json();

            messageBox.textContent = result.message;

            messageBox.classList.remove('d-none');


            if (result.success) {

                messageBox.className = 'alert alert-success';

                submitButton.innerHTML = 'Profile Created';

                setTimeout(function () {

                    window.location.href = '<?= APP_URL ?>/dashboard';

                }, 1500);

            } else {

                messageBox.className = 'alert alert-danger';

                submitButton.disabled = false;

                submitButton.innerHTML =
                    'Create Provider Profile <i class="bi bi-arrow-right ms-2"></i>';

            }


        } catch (error) {

            messageBox.textContent =
                'Something went wrong. Please try again.';

            messageBox.className = 'alert alert-danger';

            submitButton.disabled = false;

            submitButton.innerHTML =
                'Create Provider Profile <i class="bi bi-arrow-right ms-2"></i>';

            console.error(error);

        }

    });

});
</script>


<?php require APP_ROOT . '/app/views/layouts/footer.php'; ?>
