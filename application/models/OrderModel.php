<?php
class OrderModel extends CI_Model
{

    public function createOrder($userId)
    {
        $this->db->trans_start();

        // Sipariş Tablosuna Ekle
        $cartItems = $this->CartModel->getCartItems();
        $totalPrice = $this->CartModel->getTotalPrice();
        $orderData = [
            'user_id' => $userId,
            'total_price' => $totalPrice,
            'status' => 'pending',
            'created_at' => date('Y-m-d H:i:s')
        ];
        $this->db->insert('orders', $orderData);
        $orderId = $this->db->insert_id();

        // Sipariş Detaylarını Ekle
        foreach ($cartItems as $item) {
            $orderItemData = [
                'order_id' => $orderId,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price']
            ];
            $this->db->insert('order_items', $orderItemData);
        }

        $this->db->trans_complete();
        return $this->db->trans_status() ? $orderId : false;
    }
    public function createOrderItems($orderId, $cartItems)
    {
        foreach ($cartItems as $item) {
            $data = [
                'order_id' => $orderId,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ];
            $this->db->insert('order_items', $data);
        }
    }

    public function createPaymentTransaction($orderId, $paymentMethod, $paymentStatus)
    {
        $data = [
            'order_id' => $orderId,
            'payment_method' => $paymentMethod,
            'payment_status' => $paymentStatus,
        ];
        $this->db->insert('payment_transactions', $data);
    }
    public function getOrderDetails($order_id)
    {
        $this->db->select('orders.*, user_addresses.address_line1, user_addresses.city, user_addresses.country');
        $this->db->from('orders');
        $this->db->join('user_addresses', 'orders.address_id = user_addresses.id');
        $this->db->where('orders.id', $order_id);
        $query = $this->db->get();

        return $query->row_array(); // Tek bir sipariş döndürülür
    }
}
