<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Product_model extends CI_Model
{

    public function insert_product($data)
    {
        return $this->db->insert('products', $data);  // Veritabanına ürün ekleme
    }

    // Ürünleri al
    public function get_all_products()
    {
        return $this->db->get('products')->result_array();  // Bütün ürünleri getir
    }
}
