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

        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') != 'user') {
            redirect('login');
        }
    }

    public function index()
    {
        // Admin'in eklediği ürünleri al
        $data['products'] = $this->Product_model->get_all_products();

        // Dashboard sayfasını ve ürünleri gönder
        $this->load->view('dashboard', $data);
    }
}
