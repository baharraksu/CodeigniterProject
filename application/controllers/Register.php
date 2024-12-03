<?php
defined('BASEPATH') or exit('No direct script access allowed');
// Kayıt işlemleri için Register Controller

class Register extends CI_Controller
{
    // Yapıcı metod - Controller yüklendiğinde çalışır
    public function __construct()
    {
        parent::__construct();
        // Gerekli model ve kütüphaneleri yüklüyoruz
        $this->load->model('User_model'); // Kullanıcı modelini yüklüyoruz
        $this->load->library('form_validation'); // Form doğrulama kütüphanesini yüklüyoruz
    }

    // Kayıt formunu yükler
    public function index()
    {
        $this->load->view('register_form'); // Kayıt formu görünüm dosyasını yükler
    }

    // Kayıt işlemini gerçekleştirir
    public function store()
    {
        // Form doğrulama kurallarını belirliyoruz
        $this->form_validation->set_rules('username', 'Username', 'required|trim|min_length[5]'); // Kullanıcı adı zorunlu, en az 5 karakter olmalı
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email'); // Email zorunlu ve geçerli bir email formatında olmalı
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]'); // Şifre zorunlu ve en az 8 karakter olmalı
        $this->form_validation->set_rules('role', 'Role', 'required|in_list[user,admin]'); // Rol zorunlu, sadece 'user' veya 'admin' olabilir

        // Form doğrulama başarılı değilse, form tekrar yüklenir
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('register_form'); // Hatalı form verisi ile formu tekrar yükler
        } else {
            // Veritabanına kaydedilecek veriyi toplarız
            $data = [
                'username'   => $this->input->post('username'),  // Formdan kullanıcı adı alınır
                'email'      => $this->input->post('email'),     // Formdan email alınır
                'password'   => password_hash($this->input->post('password'), PASSWORD_BCRYPT), // Şifreyi hash'leyerek alırız
                'role'       => $this->input->post('role'),      // Formdan rol alınır
                'created_at' => date('Y-m-d H:i:s')              // Şu anki zamanı oluşturma tarihi olarak alırız
            ];

            // Kullanıcıyı veritabanına kaydederiz
            if ($this->User_model->register($data)) {
                // Kayıt başarılı olduğunda success mesajını set ederiz ve login sayfasına yönlendiririz
                $this->session->set_flashdata('success', 'Kayıt başarılı! Şimdi giriş yapabilirsiniz.');
                redirect('login'); // Kullanıcıyı login sayfasına yönlendiririz
            } else {
                // Kayıt başarısız olursa hata mesajı gösterilir ve form tekrar yüklenir
                $this->session->set_flashdata('error', 'Kayıt başarısız, tekrar deneyin.');
                $this->load->view('register_form'); // Hatalı durumda formu tekrar yükleriz
            }
        }
    }
}
