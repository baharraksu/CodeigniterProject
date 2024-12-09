<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{

    public function register($data)
    {
        return $this->db->insert('users', $data); // 'users' tablo adı
    }
    public function get_user_by_email($email)
    {
        return $this->db->get_where('users', ['email' => $email])->row_array();
    }
    public function getUserAddresses($userId)
    {
        $this->db->where('user_id', $userId);
        return $this->db->get('addresses')->result_array();
    }
}
