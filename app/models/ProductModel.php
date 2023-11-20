<?php

class ProductModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getProducts()
    {
        $this->db->query("SELECT p.productId,
                                 p.productOwner,
                                 p.productName,
                                 p.productPrice,
                                 p.productType,
                                 p.productCreatedate,
                                 c.customerFirstname
                                 FROM products as p
                                 INNER JOIN customers as c ON p.productOwner = c.customerId
                                 WHERE productIsActive = 1");
        return $this->db->resultSet();
    }

    public function getProductsByPagination($offset, $limit)
    {
        $this->db->query("SELECT p.productId,
                                 p.productOwner,
                                 p.productName,
                                 p.productPrice,
                                 p.productType,
                                 p.productCreatedate,
                                 c.customerFirstname
                                 FROM products as p
                                 INNER JOIN customers as c ON p.productOwner = c.customerId
                                 WHERE productIsActive = 1
                                 LIMIT :offset, :limit");
        $this->db->bind(':offset', $offset);
        $this->db->bind('limit', $limit);
        return $this->db->resultSet();
    }

    public function getTotalProductsCount()
    {
        $this->db->query("SELECT COUNT(*) as total FROM products WHERE productIsActive = 1");
        $result = $this->db->single();

        return $result->total;
    }

    public function getProductById($productId)
    {
        $this->db->query("SELECT p.productId,
                                 p.productOwner,
                                 p.productName,
                                 p.productPrice,
                                 p.productType,
                                 p.productCreatedate,
                                 c.customerFirstname
                                 FROM products as p
                                 INNER JOIN customers as c ON p.productOwner = c.customerId
                                 WHERE productIsActive = 1 AND productId = :id");
        $this->db->bind(":id", $productId);
        return $this->db->single();
    }

    public function getSingleProduct($productId)
    {
        $this->db->query("SELECT p.productId,
                                 p.productOwner,
                                 p.productName,
                                 p.productPrice,
                                 p.productType,
                                 p.productCreatedate,
                                 c.customerFirstname
                                 FROM products as p
                                 INNER JOIN customers as c ON p.productOwner = c.customerId
                                 WHERE productIsActive = 1 AND productId = :id");
        $this->db->bind(":id", $productId);
        $result = $this->db->single();

        if ($result) {
            return [$result->productName];
        } else {
            return null;
        }
    }

    public function create($post)
    {
        global $var;
        $this->db->query("INSERT INTO products (
                                                productId ,
                                                productOwner,
                                                productName,
                                                productCreateDate,
                                                productPrice,
                                                productType
                                                ) VALUES (
                                                    :id, :productOwner, :productName, :productCreateDate, :productPrice, :productType)");
        $this->db->bind(":id", $var['rand']);
        $this->db->bind(":productOwner", $post["productOwner"]);
        $this->db->bind(":productName", $post["productName"]);
        $this->db->bind(":productCreateDate", $var['timestamp']);
        $this->db->bind(":productPrice", $post["productPrice"]);
        $this->db->bind(":productType", $post["productType"]);
        return $this->db->execute();
    }

    public function delete($productId)
    {
        $this->db->query("UPDATE products SET productIsActive = 0 WHERE productId = :id");
        $this->db->bind(':id', $productId);
        $this->db->execute();
    }

    public function editProduct($post)
    {
        $this->db->query("UPDATE products SET productName = :productName,
                                                productOwner = :productOwner,
                                                productPrice = :productPrice,
                                                productType = :productType
                    WHERE productId = :id");
        $this->db->bind(':id', $post['id']);
        $this->db->bind(':productName', $post['productName']);
        $this->db->bind(':productOwner', $post['productOwner']);
        $this->db->bind(':productPrice', $post['productPrice']);
        $this->db->bind(':productType', $post['productType']);
        $this->db->execute();
    }
}
