<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->model('Product_model');

        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') != 'admin') {
            redirect('login');
        }
    }

    public function index()
    {
        $this->load->view('admin');
    }
    public function add_product()
    {
        // Kullanıcı ID'sinin oturumda olup olmadığını kontrol et

        $user_id = $this->session->userdata('logged_in');
        if (empty($user_id)) {
            $this->session->set_flashdata('error', 'Geçerli bir kullanıcı oturumu bulunamadı.');
            redirect('login');
        }
        // Form doğrulama kuralları
        $this->form_validation->set_rules('name', 'Ürün Adı', 'required');
        $this->form_validation->set_rules('description', 'Açıklama', 'required');
        $this->form_validation->set_rules('price', 'Fiyat', 'required|decimal');

        if (!$this->form_validation->run()) {
            // Hata varsa tekrar formu göster
            $this->load->view('admin');
        } else {
            // Form verilerini al

            $data = array(
                'user_id' => $user_id,  // Oturumdan alınan user_id
                'name' => $this->input->post('name'),
                'description' => $this->input->post('description'),
                'price' => $this->input->post('price'),
                'created_at' => date('Y-m-d H:i:s')
            );

            // Ürünü ekle
            $this->Product_model->insert_product($data);

            // Başarı mesajı
            $this->session->set_flashdata('success', 'Ürün başarıyla eklendi.');
            redirect('admin');  // Admin paneline yönlendir
        }
    }
}
