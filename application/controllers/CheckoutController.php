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
    public function index()
    {
        $user_id = $this->session->userdata('logged_in'); // Kullanıcı ID'sini oturumdan alıyoruz

        // Kullanıcı adreslerini veritabanından al
        $data['addresses'] = $this->AddressModel->getUserAddresses($user_id);

        // Sepet verilerini al
        $data['cart_items'] = $this->CartModel->getCartItems();
        $data['total_price'] = $this->CartModel->getTotalPrice();

        // Checkout sayfasını yükle
        $this->load->view('checkout', $data);
    }

    // Ödemeyi Tamamla
    public function completeOrder()
    {
        $user_id = $this->session->userdata('logged_in'); // Kullanıcı ID'si

        // Kullanıcı giriş yapmamışsa, giriş sayfasına yönlendir
        if (!$user_id) {
            $this->session->set_flashdata('error', 'Giriş yapmalısınız!');
            redirect('login'); // Giriş yapmayan kullanıcıyı login sayfasına yönlendir
        }
        // Adres ve ödeme yöntemini alıyoruz
        $address_id = $this->input->post('address');
        $payment_method = $this->input->post('payment_method');


        // Seçilen adresi alıyoruz
        $address_id = $this->input->post('address'); // 'address' form elemanındaki seçilen değeri alıyoruz

        // Ödeme yöntemini alıyoruz
        $payment_method = $this->input->post('payment_method');

        // Adres ve ödeme yöntemi kontrolü
        if (!$address_id) {
            $this->session->set_flashdata('error', 'Adres seçilmedi!');
            redirect('checkout');
        }

        if (!$payment_method) {
            $this->session->set_flashdata('error', 'Ödeme yöntemi seçilmedi!');
            redirect('checkout');
        }

        // Sepet kontrolü
        if ($this->CartModel->getCartItemsCount() == 0) {
            $this->session->set_flashdata('error', 'Sepetiniz boş!');
            redirect('cart');
        }

        // Sipariş Oluşturma
        $total_price = $this->CartModel->getTotalPrice();
        $order_id = $this->OrderModel->createOrder($user_id, $total_price, $address_id);

        if ($order_id) {
            // Sipariş detaylarını oluşturuyoruz
            $this->OrderModel->createOrderItems($order_id, $this->CartModel->getCartItems());

            // Ödeme işlemini kaydediyoruz (başlangıçta 'pending' olarak)
            $payment_status = 'pending';
            $this->OrderModel->createPaymentTransaction($order_id, $payment_method, $payment_status);

            // Sepeti temizliyoruz
            $this->CartModel->clearCart($user_id);

            // Başarılı mesajını gösteriyoruz
            $this->session->set_flashdata('success', 'Siparişiniz başarıyla tamamlandı.');
            redirect('orders');
        } else {
            // Sipariş oluşturulamazsa hata mesajı
            $this->session->set_flashdata('error', 'Sipariş tamamlanamadı. Lütfen tekrar deneyin.');
            redirect('checkout');
        }
    }
}
