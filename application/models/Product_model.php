<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Product_model extends CI_Model
{
    // Ürün Ekleme (Create)
    public function insert_product($data)
    {
        return $this->db->insert('products', $data);  // Veritabanına ürün ekleme
    }

    // Tüm Ürünleri Getirme (Read)
    public function get_all_products()
    {
        return $this->db->get('products')->result_array();  // Bütün ürünleri getir
    }

    // Ürün Bilgilerini Getirme (ID'ye göre)
    public function getProductById($product_id)
    {
        $this->db->select('id, name, price');
        $this->db->from('products');
        $this->db->where('id', $product_id);
        $query = $this->db->get();
        return $query->row_array(); // İlk ürünü döndürür
    }

    // Ürün Güncelleme (Update)
    public function update_product($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('products', $data);  // Ürünü güncelle
    }

    // Ürün Silme (Delete)
    public function delete_product($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('products');  // Ürünü sil
    }
}
