<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CheckoutController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('CartModel');
        $this->load->model('OrderModel');
        $this->load->model('AddressModel'); // AddressModel'i yükle
        $this->load->library('session');
    }

    // Ödeme Sayfasını Göster

}
