
<?php

class HomeController extends Controller
{
    // Display the homepage
    public function index()
    {
        $categoryModel = new Category();

        // Get all active main categories
        $categories = $categoryModel->getMainCategories();

        // Attach subcategories to each main category
        foreach ($categories as &$category) {
            $category['subcategories'] = $categoryModel->getSubcategories(
                $category['id']
            );
        }

        unset($category);

        // Display homepage with database categories
        $this->view('home.index', [
            'categories' => $categories
        ]);
    }
}
