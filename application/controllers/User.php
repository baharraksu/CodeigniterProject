<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Product_model');  // Ürün modelini yükle
    }

    // Kullanıcı dashboardu
    public function index()
    {
        $data['products'] = $this->Product_model->get_all_products();
        $this->load->view('dashboard', $data);  // Kullanıcıya ürünleri göster
    }
}
