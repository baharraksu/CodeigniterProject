<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->model('Product_model');
        $this->load->model('Trendyol_model'); // Trendyol modelini yükleyin

        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') != 'user') {
            redirect('login');
        }
    }

    public function index()
    {
        // Admin'in eklediği ürünleri al
        $data['products'] = $this->Product_model->get_all_products();

        // Trendyol API'den kategorileri al
        $categoriesData = $this->Trendyol_model->getCategories();

        if ($categoriesData['status_code'] == 200) {
            $data['categories'] = $categoriesData['response']; // Kategorileri veri olarak gönder
        } else {
            $data['categories'] = []; // Kategoriler alınamazsa boş bir array gönder
        }

        // Dashboard sayfasını ve ürünleri gönder
        $this->load->view('dashboard', $data);
    }
}
