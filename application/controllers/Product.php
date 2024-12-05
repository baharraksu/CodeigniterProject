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
        if ($this->Product_model->insert_product($data)) {
            $this->session->set_flashdata('success', 'Ürün başarıyla eklendi.');
            redirect('product/list'); // Ürün listeleme sayfasına yönlendirme
        } else {
            $this->session->set_flashdata('error', 'Ürün eklenemedi.');
            redirect('product/add'); // Ürün ekleme sayfasına geri dön
        }
    }

    // Ürünleri listele
    public function list()
    {
        $data['products'] = $this->Product_model->get_all_products(); // Ürünleri al
        $this->load->view('product_list', $data); // Ürün listeleme sayfasını yükle
    }

    // Ürün düzenleme formunu yükle
    public function edit($id)
    {
        $data['product'] = $this->Product_model->get_product_by_id($id); // ID'ye göre ürünü al
        if (empty($data['product'])) {
            $this->session->set_flashdata('error', 'Ürün bulunamadı.');
            redirect('product/list');
        }
        $this->load->view('product_edit', $data); // Ürün düzenleme formunu yükle
    }

    // Ürün güncelleme işlemi
    public function update($id)
    {
        // Formdan gelen verileri al
        $data = [
            'name'       => $this->input->post('name'),
            'description' => $this->input->post('description'),
            'price'      => $this->input->post('price'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        // Model aracılığıyla ürünü güncelle
        if ($this->Product_model->update_product($id, $data)) {
            $this->session->set_flashdata('success', 'Ürün başarıyla güncellendi.');
            redirect('product/list');
        } else {
            $this->session->set_flashdata('error', 'Ürün güncellenemedi.');
            redirect('product/edit/' . $id);
        }
    }

    // Ürün silme işlemi
    public function delete($id)
    {
        // Model aracılığıyla ürünü sil
        if ($this->Product_model->delete_product($id)) {
            $this->session->set_flashdata('success', 'Ürün başarıyla silindi.');
        } else {
            $this->session->set_flashdata('error', 'Ürün silinemedi.');
        }
        redirect('product/list');
    }
}
