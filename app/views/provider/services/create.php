
<?php

// Load website header
require APP_ROOT . '/app/views/layouts/header.php';

// CSRF token
$csrfToken = $csrfToken ?? '';

?>

<div class="container py-4">

    <!-- PAGE HEADER -->
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

        <div>
            <h2 class="fw-bold mb-1">Create New Service</h2>

            <p class="text-muted mb-0">
                Add a service to your Servora business profile.
            </p>
        </div>

        <a href="<?= APP_URL ?>/provider/services"
           class="btn btn-outline-secondary">

            <i class="bi bi-arrow-left me-2"></i>
            Back to My Services

        </a>

    </div>


    <!-- SERVICE FORM CARD -->
    <div class="card border-0 shadow-sm rounded-4">

        <div class="card-body p-4 p-md-5">

            <form
                action="<?= APP_URL ?>/provider/services/store"
                method="POST"
                enctype="multipart/form-data"
                id="createServiceForm"
            >

                <!-- CSRF TOKEN -->
                <input
                    type="hidden"
                    name="csrf_token"
                    value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8') ?>"
                >


                <!-- SERVICE TITLE -->
                <div class="mb-4">

                    <label for="title" class="form-label fw-semibold">
                        Service Title
                    </label>

                    <input
                        type="text"
                        class="form-control"
                        id="title"
                        name="title"
                        placeholder="Example: Professional Home Electrical Repair"
                        maxlength="150"
                        required
                    >

                    <small class="text-muted">
                        Enter a clear title describing your service.
                    </small>

                </div>


                <!-- CATEGORY SELECTION -->
                <div class="row g-4 mb-4">

                    <!-- MAIN CATEGORY -->
                    <div class="col-md-6">

                        <label for="mainCategory" class="form-label fw-semibold">
                            Main Category
                        </label>

                        <select
                            class="form-select"
                            id="mainCategory"
                            name="main_category_id"
                            required
                        >

                            <option value="">Select Main Category</option>

                            <?php foreach ($categories as $category): ?>

                                <option value="<?= (int) $category['id'] ?>">
                                    <?= htmlspecialchars($category['name'], ENT_QUOTES, 'UTF-8') ?>
                                </option>

                            <?php endforeach; ?>

                        </select>

                    </div>


                    <!-- SUBCATEGORY -->
                    <div class="col-md-6">

                        <label for="subcategory" class="form-label fw-semibold">
                            Subcategory
                        </label>

                        <select
                            class="form-select"
                            id="subcategory"
                            name="category_id"
                            required
                            disabled
                        >

                            <option value="">
                                Select Main Category First
                            </option>

                        </select>

                    </div>

                </div>


                <!-- DESCRIPTION -->
                <div class="mb-4">

                    <label for="description" class="form-label fw-semibold">
                        Service Description
                    </label>

                    <textarea
                        class="form-control"
                        id="description"
                        name="description"
                        rows="5"
                        placeholder="Describe your service, experience, and what customers can expect..."
                        required
                    ></textarea>

                </div>


                <!-- PRICE DETAILS -->
                <div class="row g-4 mb-4">

                    <!-- PRICE -->
                    <div class="col-md-6">

                        <label for="price" class="form-label fw-semibold">
                            Price (₹)
                        </label>

                        <input
                            type="number"
                            class="form-control"
                            id="price"
                            name="price"
                            min="0"
                            max="99999999.99"
                            step="0.01"
                            placeholder="Enter service price"
                            required
                        >

                    </div>


                    <!-- PRICE TYPE -->
                    <div class="col-md-6">

                        <label for="price_type" class="form-label fw-semibold">
                            Price Type
                        </label>

                        <select
                            class="form-select"
                            id="price_type"
                            name="price_type"
                            required
                        >

                            <option value="fixed">Fixed Price</option>

                            <option value="starting_from">Starting From</option>

                            <option value="hourly">Hourly</option>

                            <option value="negotiable">Negotiable</option>

                        </select>

                    </div>

                </div>


                <!-- SERVICE IMAGE -->
                <div class="mb-4">

                    <label for="serviceImage" class="form-label fw-semibold">
                        Service Image
                    </label>

                    <input
                        type="file"
                        class="form-control"
                        id="serviceImage"
                        name="service_image"
                        accept="image/jpeg,image/png,image/webp"
                    >

                    <small class="text-muted">
                        Upload one JPG, PNG, or WEBP image. Maximum size 3 MB.
                    </small>


                    <!-- IMAGE PREVIEW -->
                    <div class="mt-3" id="imagePreviewContainer" style="display: none;">

                        <img
                            id="imagePreview"
                            src=""
                            alt="Service image preview"
                            style="
                                width: 220px;
                                height: 150px;
                                object-fit: cover;
                                border-radius: 12px;
                                border: 1px solid #e8edf5;
                            "
                        >

                    </div>

                </div>


                <!-- SUBMIT BUTTON -->
                <div class="d-flex justify-content-end gap-3 flex-wrap pt-3 border-top">

                    <a
                        href="<?= APP_URL ?>/provider/services"
                        class="btn btn-light px-4"
                    >
                        Cancel
                    </a>

                    <button
                        type="submit"
                        class="btn btn-primary px-4"
                    >

                        <i class="bi bi-plus-lg me-2"></i>
                        Create Service

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>


<!-- CATEGORY AND IMAGE JAVASCRIPT -->
<script>

document.addEventListener('DOMContentLoaded', function () {

    // Get dropdown elements
    const mainCategory = document.getElementById('mainCategory');

    const subcategory = document.getElementById('subcategory');


    // Load subcategories when main category changes
    mainCategory.addEventListener('change', function () {

        const parentId = this.value;

        // Reset subcategory dropdown
        subcategory.innerHTML = '';

        subcategory.disabled = true;


        // Check whether a category is selected
        if (!parentId) {

            subcategory.innerHTML =
                '<option value="">Select Main Category First</option>';

            return;
        }


        // Display loading message
        subcategory.innerHTML =
            '<option value="">Loading subcategories...</option>';


        // Fetch subcategories from server
        fetch(
            '<?= APP_URL ?>/dashboard/provider-subcategories?parent_id='
            + encodeURIComponent(parentId)
        )

        .then(function (response) {

            if (!response.ok) {
                throw new Error('Unable to load subcategories.');
            }

            return response.json();

        })

        .then(function (data) {

            // Clear dropdown
            subcategory.innerHTML = '';


            // Check response
            if (!data.success || !Array.isArray(data.subcategories)) {

                subcategory.innerHTML =
                    '<option value="">No subcategories available</option>';

                return;
            }


            // Default option
            const defaultOption = document.createElement('option');

            defaultOption.value = '';

            defaultOption.textContent = 'Select Subcategory';

            subcategory.appendChild(defaultOption);


            // Add subcategories
            data.subcategories.forEach(function (item) {

                const option = document.createElement('option');

                option.value = item.id;

                option.textContent = item.name;

                subcategory.appendChild(option);

            });


            // Enable dropdown when options are available
            subcategory.disabled = data.subcategories.length === 0;

        })

        .catch(function (error) {

            console.error('Subcategory error:', error);

            subcategory.innerHTML =
                '<option value="">Unable to load subcategories</option>';

        });

    });


    // IMAGE PREVIEW
    const serviceImage = document.getElementById('serviceImage');

    const imagePreview = document.getElementById('imagePreview');

    const imagePreviewContainer =
        document.getElementById('imagePreviewContainer');

    let previousImageUrl = null;


    serviceImage.addEventListener('change', function () {

        const file = this.files[0];


        // Hide preview if no image is selected
        if (!file) {

            imagePreview.src = '';

            imagePreviewContainer.style.display = 'none';

            return;
        }


        // Allowed image types
        const allowedTypes = [
            'image/jpeg',
            'image/png',
            'image/webp'
        ];


        // Validate image type
        if (!allowedTypes.includes(file.type)) {

            alert('Please select a JPG, PNG, or WEBP image.');

            this.value = '';

            imagePreviewContainer.style.display = 'none';

            return;
        }


        // Maximum image size: 3 MB
        if (file.size > 3 * 1024 * 1024) {

            alert('Image size must not exceed 3 MB.');

            this.value = '';

            imagePreviewContainer.style.display = 'none';

            return;
        }


        // Release previous preview URL
        if (previousImageUrl) {
            URL.revokeObjectURL(previousImageUrl);
        }


        // Create and display new preview
        previousImageUrl = URL.createObjectURL(file);

        imagePreview.src = previousImageUrl;

        imagePreviewContainer.style.display = 'block';

    });

});

</script>


<?php

// Load website footer
require APP_ROOT . '/app/views/layouts/footer.php';

?>
