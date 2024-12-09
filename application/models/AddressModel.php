<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AddressModel extends CI_Model
{
    public function getUserAddresses($user_id)
    {
        // Veritabanından kullanıcı adreslerini çekme
        $this->db->select('id, address_line1, address_line2, city, state, postal_code, country');
        $this->db->from('user_addresses');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get();

        return $query->result_array(); // Adresleri döndür
    }
}
