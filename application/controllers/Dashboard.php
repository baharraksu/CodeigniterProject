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
        $this->load->model('Trendyol_model');
        $this->load->model('AddressModel');
        $this->load->model('CartModel');
        $this->load->model('OrderModel');

        // Kullanıcı oturum kontrolü
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') != 'user') {
            redirect('login');
        }
    }

    // Dashboard Anasayfası
    public function index()
    {
        $data = [];

        // Admin ürünlerini al
        $data['products'] = $this->Product_model->get_all_products();

        // Trendyol kategorilerini al
        $categoriesData = $this->Trendyol_model->getCategories();
        $data['categories'] = $categoriesData['status_code'] == 200 ? $categoriesData['response'] : [];

        // Dashboard sayfasını yükle
        $this->load->view('dashboard', $data);
    }

    // Checkout Sayfası
    public function checkout()
    {
        $user_id = $this->session->userdata('user_id'); // Kullanıcı ID'sini oturumdan al

        $data['addresses'] = $this->AddressModel->getUserAddresses($user_id);
        $data['cart_items'] = $this->CartModel->getCartItems($user_id);
        $data['total_price'] = $this->CartModel->getTotalPrice($user_id);

        $this->load->view('checkout', $data);
    }

    // Ödeme Tamamlama
    public function completeOrder()
    {
        $user_id = $this->session->userdata('user_id'); // Kullanıcı ID'si

        if (!$user_id) {
            $this->session->set_flashdata('error', 'Giriş yapmalısınız!');
            redirect('login');
        }

        // Formdan gelen veriler
        $address_id = $this->input->post('address');
        $payment_method = $this->input->post('payment_method');

        // Gerekli alanların kontrolü
        if (!$address_id || !$payment_method) {
            $this->session->set_flashdata('error', 'Adres ve ödeme yöntemi seçmelisiniz!');
            redirect('checkout');
        }

        // Sepet kontrolü
        if ($this->CartModel->getCartItemsCount($user_id) == 0) {
            $this->session->set_flashdata('error', 'Sepetiniz boş!');
            redirect('cart');
        }

        // Sipariş oluşturma
        $total_price = $this->CartModel->getTotalPrice($user_id);
        $order_id = $this->OrderModel->createOrder($user_id, $total_price, $address_id);

        if ($order_id) {
            $this->OrderModel->createOrderItems($order_id, $this->CartModel->getCartItems($user_id));
            $this->OrderModel->createPaymentTransaction($order_id, $payment_method, 'pending');
            $this->CartModel->clearCart($user_id);

            $this->session->set_flashdata('success', 'Siparişiniz başarıyla tamamlandı.');
            redirect('orders');
        } else {
            $this->session->set_flashdata('error', 'Sipariş tamamlanamadı. Lütfen tekrar deneyin.');
            redirect('checkout');
        }
    }
}
