<?php

class OrderModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }


    public function getOrders()
    {
        $this->db->query("SELECT o.orderId,
                                 o.orderStoreId,
                                 o.orderCustomerId,
                                 o.orderPrice,
                                 o.orderState,
                                 o.orderStatus,
                                 o.orderCreateDate,
                                 c.customerFirstName,
                                 c.customerLastName,
                                 s.storeName
                                 FROM orders as o 
                                 INNER JOIN customers as c ON o.orderCustomerId = c.customerId
                                 INNER JOIN stores as s ON o.orderStoreId = s.storeId");
        return $this->db->resultSet();
    }

    public function getOrdersByPagination($offset, $limit)
    {
        $this->db->query("SELECT o.orderId,
                                 o.orderStoreId,
                                 o.orderCustomerId,
                                 o.orderPrice,
                                 o.orderState,
                                 o.orderStatus,
                                 o.orderCreateDate,
                                 c.customerFirstName,
                                 c.customerLastName,
                                 s.storeName
                                 FROM orders as o 
                                 INNER JOIN customers as c ON o.orderCustomerId = c.customerId
                                 INNER JOIN stores as s ON o.orderStoreId = s.storeId
                                 LIMIT :offset, :limit");
        $this->db->bind(':offset', $offset);
        $this->db->bind('limit', $limit);
        return $this->db->resultSet();
    }

    public function getTotalOrdersCount()
    {
        $this->db->query("SELECT COUNT(*) as total FROM orders");
        $result = $this->db->single();

        return $result->total;
    }

    public function getOrderById($orderId)
    {
        $this->db->query("SELECT o.orderId,
        o.orderStoreId,
        o.orderCustomerId,
        o.orderPrice,
        o.orderState,
        o.orderStatus,
        o.orderCreateDate,
        c.customerFirstName,
        c.customerLastName,
        s.storeName
        FROM orders as o 
        INNER JOIN customers as c ON o.orderCustomerId = c.customerId
        INNER JOIN stores as s ON o.orderStoreId = s.storeId
        WHERE o.orderId = :id");
        $this->db->bind(":id", $orderId);
        return $this->db->single();
    }

    public function update($post)
    {
        $this->db->query("UPDATE orders SET     orderStoreId = :orderStoreId,
                                                orderCustomerId = :orderCustomerId,
                                                orderState = :orderState,
                                                orderStatus = :orderStatus,
                                                orderPrice = :orderPrice
                    WHERE orderId = :id");
        $this->db->bind(':id', $post['id']);
        $this->db->bind(':orderStoreId', $post['orderStoreId']);
        $this->db->bind(':orderCustomerId', $post['orderCustomerId']);
        $this->db->bind(':orderState', $post['orderState']);
        $this->db->bind(':orderStatus', $post['orderStatus']);
        $this->db->bind(':orderPrice', $post['orderPrice']);
        $this->db->execute();
    }

    public function create($post)
    {
        global $var;
        $this->db->query("INSERT INTO orders (
                                                orderId,
                                                orderStoreId,
                                                orderCustomerId,
                                                orderCreateDate,
                                                orderState,
                                                orderStatus,
                                                orderPrice
                                                ) VALUES (
                                                    :id, :orderStoreId, :orderCustomerId, :orderCreateDate, :orderState, :orderStatus, :orderPrice)");
        $this->db->bind(":id", $var['rand']);
        $this->db->bind(":orderStoreId", $post["orderStoreId"]);
        $this->db->bind(":orderCustomerId", $post["orderCustomerId"]);
        $this->db->bind(":orderCreateDate", $var['timestamp']);
        $this->db->bind(":orderState", $post["orderState"]);
        $this->db->bind(":orderStatus", $post["orderStatus"]);
        $this->db->bind(":orderPrice", $post["orderPrice"]);
        return $this->db->execute();
    }

    public function getProductByOrder($orderId)
    {
        $this->db->query("SELECT o.orderId,
                                 p.productId,
                                 p.productName,
                                 p.productType,
                                 ohp.orderId,
                                 ohp.productId,
                                 ohp.productPrice
                                 FROM orderhasproducts as ohp
                                 INNER JOIN orders as o ON ohp.orderId = o.orderId
                                 INNER JOIN products as p ON ohp.productId = p.productId
                                 WHERE ohp.orderId = :orderId");
        $this->db->bind(':orderId', $orderId);
        return $this->db->resultSet();
    }
}
