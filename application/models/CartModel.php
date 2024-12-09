<?php
class CartModel extends CI_Model
{

    // Ödeme Sayfasını Göster
    public function index()
    {
        $user_id = $this->session->userdata('logged_in'); // Kullanıcı ID'sini oturumdan alıyoruz

        // Kullanıcı adreslerini veritabanından al
        $data['addresses'] = $this->AddressModel->getUserAddresses($user_id);

        // Sepet verilerini al
        $data['cart_items'] = $this->CartModel->getCartItems();
        $data['total_price'] = $this->CartModel->getTotalPrice(); // Sepetteki toplam fiyatı al

        // Checkout sayfasını yükle
        $this->load->view('checkout', $data);
    }

    public function getCartItemsCount()
    {
        $userId = $this->session->userdata('user_id');
        $this->db->where('user_id', $userId);
        $query = $this->db->get('cart');
        return $query->num_rows(); // Sepetteki ürün sayısını döndürür
    }
    public function getCartItems()
    {
        $userId = $this->session->userdata('user_id');
        $this->db->select('c.*, p.name, p.price');
        $this->db->from('cart c');
        $this->db->join('products p', 'c.product_id = p.id');
        $this->db->where('c.user_id', $userId);
        return $this->db->get()->result_array();
    }

    public function getTotalPrice()
    {
        $userId = $this->session->userdata('user_id');
        // select_sum yerine select ile manuel ifade yazıyoruz.
        $this->db->select('SUM(p.price * c.quantity) AS total');
        $this->db->from('cart c');
        $this->db->join('products p', 'c.product_id = p.id');
        $this->db->where('c.user_id', $userId);
        $query = $this->db->get();

        // Eğer sonuç dönerse toplam değeri döndür.
        if ($query->num_rows() > 0) {
            return $query->row()->total;
        }

        return 0; // Sepet boş ise toplam 0 döndür.
    }

    public function clearCart($userId)
    {
        $this->db->where('user_id', $userId);
        $this->db->delete('cart');
    }
}
