<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Trendyol extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Trendyol_model');
    }

    // public function products()
    // {
    //     $products = $this->Trendyol_model->getProducts(); // Trendyol API'den ürünleri çek

    //     echo "<pre>";
    //     print_r($products); // Gelen veriyi detaylı olarak görüntüle
    //     echo "</pre>";
    //     exit;
    // }
    public function products()
    {
        $products = $this->Trendyol_model->getProducts(); // Trendyol API'den ürünleri çek
        $categoriesData = $this->Trendyol_model->getCategories(); // Get categories from Trendyol API

        if ($categoriesData['status_code'] == 200) {
            $categories = $categoriesData['response']; // Assuming response contains the categories
        } else {
            $categories = []; // Handle failure in fetching categories
        }

        echo "<pre>";
        print_r($products); // Gelen veriyi detaylı olarak görüntüle
        echo "</pre>";

        $this->load->view('trendyol/products', ['products' => $products['response'], 'categories' => $categories]);
    }


    public function getAddresses()
    {
        $data = $this->Trendyol_model->getAddresses();

        if ($data['status_code'] == 200) {
            $this->load->view('trendyol/addresses', ['addresses' => $data['response']]);
        } else {
            show_error("Trendyol API'den veri çekme başarısız! Status Code: " . $data['status_code']);
        }
    }

    public function getBrands()
    {
        $page = $this->input->get('page') ?: 1;
        $size = $this->input->get('size') ?: 50;

        $data = $this->Trendyol_model->getBrands($page, $size);

        if ($data['status_code'] == 200) {
            $this->load->view('trendyol/brands', ['brands' => $data['response']]);
        } else {
            show_error("Trendyol API'den veri çekme başarısız! Status Code: " . $data['status_code']);
        }
    }

    public function getOrders()
    {
        $status = $this->input->get('status') ?: 'Awaiting';

        $data = $this->Trendyol_model->getOrders($status);

        if ($data['status_code'] == 200) {
            $this->load->view('trendyol/orders', ['orders' => $data['response']]);
        } else {
            show_error("Trendyol API'den veri çekme başarısız! Status Code: " . $data['status_code']);
        }
    }
    public function categories()
    {
        $categoriesData = $this->Trendyol_model->getCategories();

        if ($categoriesData['status_code'] === 200) {
            $categories = $categoriesData['response']['categories']; // API'den gelen kategoriler
        } else {
            $categories = []; // Hata durumunda boş dizi
        }

        // View dosyasını çağırırken yolu doğru ayarlayın
        $this->load->view('trendyol/category_view', ['categories' => $categories]);
    }
}
