<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Trendyol_model extends CI_Model
{

    private $base_url = "";
    private $access_token = "";
    private $supplier_id = "";

    private function getHeaders()
    {
        return [
            "Authorization: Bearer " . $this->access_token,
            "Content-Type: application/json"
        ];
    }

    private function sendRequest($endpoint)
    {
        $url = $this->base_url . $endpoint;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->getHeaders());

        $response = curl_exec($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return [
            'status_code' => $status_code,
            'response' => json_decode($response, true)
        ];
    }

    public function getProducts($page = 1, $size = 50)
    {
        $endpoint = "/suppliers/{$this->supplier_id}/products?page={$page}&size={$size}&approved=True";
        return $this->sendRequest($endpoint);
    }
    public function getCategories()
    {
        $endpoint = "/product-categories"; // Example endpoint to get product categories
        return $this->sendRequest($endpoint);
    }


    public function getAddresses()
    {
        $endpoint = "/suppliers/{$this->supplier_id}/addresses";
        return $this->sendRequest($endpoint);
    }

    public function getCategoryAttributes($categoryId)
    {
        $endpoint = "/product-categories/{$categoryId}/attributes";
        return $this->sendRequest($endpoint);
    }

    public function getBrands($page = 1, $size = 50)
    {
        $endpoint = "/brands?page={$page}&size={$size}";
        return $this->sendRequest($endpoint);
    }

    public function getOrders($status = 'Awaiting')
    {
        $endpoint = "/suppliers/{$this->supplier_id}/orders?status={$status}";
        return $this->sendRequest($endpoint);
    }

    public function trendyolProducts()
    {
        $this->load->model('Trendyol_model'); // Modeli yükle
        $products = $this->Trendyol_model->getProducts(); // Ürünleri al

        if ($products['status_code'] === 200) { // Başarılı bir istek
            $data['products'] = $products['response']; // Gelen yanıt
            $this->load->view('products', $data); // View'e gönder
        } else {
            echo "Veri alınamadı. Hata kodu: " . $products['status_code'];
        }
    }
    public function get_categories()
    {
        $this->db->select('categoryName'); // Kategori adını almak istiyoruz
        $this->db->from('categories'); // categories tablosu
        $query = $this->db->get();

        return $query->result_array(); // Verileri dizi olarak döndürüyoruz
    }
}
