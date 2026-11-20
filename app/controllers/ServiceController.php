
<?php

class ServiceController extends Controller
{
    // Display services belonging to a selected category
    public function index()
    {
        $categorySlug = trim($_GET['category'] ?? '');

        if ($categorySlug === '') {
            $this->view('services.index', [
                'pageTitle' => 'Browse Services',
                'category' => null,
                'services' => []
            ]);

            return;
        }

        $categoryModel = new Category();

        $category = $categoryModel->findMainCategoryBySlug(
            $categorySlug
        );

        if (!$category) {
            http_response_code(404);

            $this->view('services.not-found', [
                'pageTitle' => 'Category Not Found'
            ]);

            return;
        }

        $serviceModel = new Service();

        $services = $serviceModel->getServicesByMainCategory(
            $category['id']
        );

        $this->view('services.index', [
            'pageTitle' => $category['name'] . ' Services',
            'category' => $category,
            'services' => $services
        ]);
    }


    // Display complete details of one service
    public function details()
    {
        $serviceId = filter_var(
            $_GET['id'] ?? null,
            FILTER_VALIDATE_INT
        );

        if (!$serviceId || $serviceId < 1) {
            http_response_code(404);

            $this->view('services.not-found', [
                'pageTitle' => 'Service Not Found'
            ]);

            return;
        }

        $serviceModel = new Service();

        $service = $serviceModel->findActiveById($serviceId);

        if (!$service) {
            http_response_code(404);

            $this->view('services.not-found', [
                'pageTitle' => 'Service Not Found'
            ]);

            return;
        }

        // Fetch published customer reviews
        $reviewModel = new Review();

        $reviews = $reviewModel->getPublishedByServiceId(
            $serviceId
        );

        // Fetch average rating and review count
        $ratingSummary = $reviewModel->getServiceRatingSummary(
            $serviceId
        );

        // Display service details and customer reviews
        $this->view('services.details', [
            'pageTitle' => $service['title'],
            'service' => $service,
            'reviews' => $reviews,
            'ratingSummary' => $ratingSummary,
            'csrfToken' => Csrf::token()
        ]);
    }
}
