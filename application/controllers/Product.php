<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Product extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Product_model'); // Ürün modeli
        $this->load->library('session');     // Session kütüphanesi

        // Kullanıcı giriş kontrolü
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    }

    // Ürün ekleme formunu yükle
    public function add()
    {
        $this->load->view('product_form'); // Ürün ekleme formu
    }

    // Ürün ekleme işlemi
    public function add_action()
    {
        // Formdan gelen verileri al
        $data = [
            'user_id'    => $this->session->userdata('id'), // Giriş yapan kullanıcı ID
            'name'       => $this->input->post('name'),
            'description' => $this->input->post('description'),
            'price'      => $this->input->post('price'),
            'created_at' => date('Y-m-d H:i:s'),
        ];

        // Model aracılığıyla veritabanına kaydet
        if ($this->Product_model->add_product($data)) {
            $this->session->set_flashdata('success', 'Ürün başarıyla eklendi.');
            redirect('product/list'); // Ürün listeleme sayfasına yönlendirme
        } else {
            $this->session->set_flashdata('error', 'Ürün eklenemedi.');
            redirect('product/add'); // Ürün ekleme sayfasına geri dön
        }
    }
}
