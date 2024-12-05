<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cart extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Cart_model');  // Cart_model'i yükle
        $this->load->library('session');   // Session kütüphanesini yükle
    }

    // Sepete ürün eklemek
    public function addToCart($product_id)
    {
        // Kullanıcı id'sini al
        $user_id = $this->session->userdata('user_id');

        // Model ile sepetteki ürünü kontrol et
        $cart = $this->Cart_model->getCartItem($user_id, $product_id);

        // Sepetteki ürünü ekle ya da miktarını arttır
        if ($cart) {
            $this->Cart_model->increaseQuantity($cart['id']); // Miktarı arttır
        } else {
            $this->Cart_model->addItemToCart($user_id, $product_id); // Yeni ürün ekle
        }

        // Sepete eklenen ürün sonrası sepete git
        redirect('cart/viewCart');
    }

    // Sepeti görüntüleme
    public function viewCart()
    {
        $user_id = $this->session->userdata('user_id');
        $data['cart_items'] = $this->Cart_model->getCartItems($user_id); // Sepetteki ürünler
        $data['cart_item_count'] = count($data['cart_items']); // Sepetteki ürün sayısı

        // View dosyasını yükle
        $this->load->view('cart_view', $data);
    }

    // Sepet güncelleme işlemi
    public function updateCart()
    {
        $quantities = $this->input->post('quantity'); // Formdan gelen ürün miktarları

        // Her bir ürün için güncelleme yap
        foreach ($quantities as $cart_id => $quantity) {
            if ($quantity >= 1) {
                // Sepet öğesinin miktarını güncelle
                $this->Cart_model->updateProductQuantity($cart_id, $quantity);
            }
        }

        // Sepet sayfasına geri dön
        redirect('cart/viewCart');
    }

    // Sepetten ürün silme işlemi
    // Sepetten ürün silme işlemi
    public function removeItem($cart_id)
    {
        // Sepetten ürünü sil
        $this->Cart_model->removeProductFromCart($cart_id);

        // Silme işlemi sonrası sayfayı yenileyerek aynı sepete geri dön
        $this->load->view('cart_view', ['cart_items' => $this->Cart_model->getCartItems($this->session->userdata('user_id'))]);
    }
}
