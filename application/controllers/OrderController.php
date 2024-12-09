<?php
defined('BASEPATH') or exit('No direct script access allowed');
class OrderController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('OrderModel');
    }

    public function completeOrder()
    {
        // Sipariş verilerini al
        $order_data = [
            'user_id' => $this->session->userdata('user_id'),
            'total_price' => $this->input->post('total_price'),
            // Diğer sipariş verilerini burada alabilirsiniz
        ];

        // Siparişi veritabanına kaydet
        $this->db->insert('orders', $order_data);

        // Siparişin ID'sini al
        $order_id = $this->db->insert_id();

        // Sipariş öğelerini (product details) kaydedin
        $order_items = $this->input->post('order_items'); // Sipariş öğelerini post ile alıyoruz
        foreach ($order_items as $item) {
            $item_data = [
                'order_id' => $order_id, // Siparişin ID'sini ilişkilendiriyoruz
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ];
            $this->db->insert('order_items', $item_data);
        }

        // Sipariş tamamlandıktan sonra başarılı sayfaya yönlendir
        redirect('order/success'); // Yönlendirdiğiniz route
    }

    public function success()
    {
        // Sipariş başarıyla tamamlandığında bu sayfayı göster
        $data['order_items'] = $this->OrderModel->getOrderItems($this->session->userdata('order_id')); // Sipariş öğelerini al
        $data['total_price'] = $this->OrderModel->getTotalPrice($this->session->userdata('order_id')); // Toplam tutar
        $this->load->view('order_success', $data); // Success view'ini yükle
    }
}
