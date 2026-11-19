
<?php

class ServiceController extends Controller
{
    public function index()
    {
        $this->view('services.index', [
            'pageTitle' => 'Browse Services'
        ]);
    }
}
