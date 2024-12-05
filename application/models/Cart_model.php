<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cart_model extends CI_Model
{
    // Kullanıcı ve ürün ID'sine göre sepetteki ürünü kontrol et
    public function getCartItem($user_id, $product_id)
    {
        $this->db->where('user_id', $user_id);
        $this->db->where('product_id', $product_id);
        $query = $this->db->get('cart');
        return $query->row_array(); // Tek bir ürün döner
    }

    // Sepete yeni ürün eklemek
    public function addItemToCart($user_id, $product_id)
    {
        $data = [
            'user_id' => $user_id,
            'product_id' => $product_id,
            'quantity' => 1, // Varsayılan olarak 1
        ];

        return $this->db->insert('cart', $data); // Yeni öğe ekle
    }

    // Sepetteki ürünlerin listesini al
    public function getCartItems($user_id)
    {
        $this->db->select('cart.id, cart.quantity, products.name, products.price');
        $this->db->from('cart');
        $this->db->join('products', 'products.id = cart.product_id');
        $this->db->where('cart.user_id', $user_id);
        $query = $this->db->get();
        return $query->result_array(); // Tüm sepet öğelerini döner
    }

    // Sepetteki bir ürünün miktarını arttırmak
    public function increaseQuantity($cart_id)
    {
        $this->db->set('quantity', 'quantity+1', FALSE); // Miktarı 1 arttır
        $this->db->where('id', $cart_id);
        return $this->db->update('cart'); // Miktarı güncelle
    }

    // Sepet öğesinin miktarını güncellemek
    public function updateProductQuantity($cart_id, $quantity)
    {
        $this->db->set('quantity', $quantity); // Miktarı belirle
        $this->db->where('id', $cart_id);
        return $this->db->update('cart'); // Miktarı güncelle
    }

    // Sepetten ürün silmek
    public function removeProductFromCart($cart_id)
    {
        $this->db->where('id', $cart_id);
        return $this->db->delete('cart'); // Ürünü sepetten sil
    }
}
