<?php

class StoreModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getStores()
    {
        $this->db->query("SELECT storeId,
                                 storeName,
                                 storeZipcode,
                                 storeStreetName,
                                 storeCity,
                                 storePhone,
                                 storeEmail,
                                 storeCreateDate
                                 FROM stores
                                 WHERE storeIsActive = 1");
        return $this->db->resultSet();
    }

    public function getStoreById($storeId)
    {
        $this->db->query("SELECT storeId,
                                 storeName,
                                 storeZipcode,
                                 storeStreetName,
                                 storeCity,
                                 storePhone,
                                 storeEmail,
                                 storeCreateDate
                                 FROM stores
                                 WHERE storeIsActive = 1 AND storeId = :storeId");
        $this->db->bind(':storeId', $storeId);
        return $this->db->single();
    }

    public function create($post)
    {
        global $var;
        $this->db->query("INSERT INTO stores (
                                                storeId,
                                                storeName,
                                                storeZipcode,
                                                storeCreateDate,
                                                storeStreetName,
                                                storeCity,
                                                storePhone,
                                                storeEmail) VALUES (
                                                    :id, :storeName, :storeZipcode, :storeCreateDate, :storeStreetName, :storeCity, :storePhone,
                                                    :storeEmail)");
        $this->db->bind(":id", $var['rand']);
        $this->db->bind(":storeName", $post["storeName"]);
        $this->db->bind(":storeZipcode", $post["storeZipcode"]);
        $this->db->bind(":storeCreateDate", $var['timestamp']);
        $this->db->bind(":storeStreetName", $post["storeStreetName"]);
        $this->db->bind(":storeCity", $post["storeCity"]);
        $this->db->bind(":storePhone", $post["storePhone"]);
        $this->db->bind(":storeEmail", $post["storeEmail"]);
        return $this->db->execute();
    }

    public function delete($storeId)
    {
        $this->db->query("UPDATE stores SET storeIsActive = 0 WHERE storeId = :id");
        $this->db->bind(':id', $storeId);
        $this->db->execute();
    }

    public function update($post)
    {
        try {
            $this->db->query("UPDATE stores SET storeName = :storeName,
                                                storeZipcode = :storeZipcode,
                                                storeStreetName = :storeStreetName,
                                                storeCity = :storeCity,
                                                storePhone = :storePhone,
                                                storeEmail = :storeEmail
                    WHERE storeId = :id");
            $this->db->bind(':id', $post['id']);
            $this->db->bind(':storeName', $post['storeName']);
            $this->db->bind(':storeZipcode', $post['storeZipcode']);
            $this->db->bind(':storeStreetName', $post['storeStreetName']);
            $this->db->bind(':storeCity', $post['storeCity']);
            $this->db->bind(':storePhone', $post['storePhone']);
            $this->db->bind(':storeEmail', $post['storeEmail']);
            $this->db->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getEmployeeByStore($storeId)
    {
        $this->db->query("SELECT  e.employeeFirstName,
                                  e.employeeLastName,
                                  e.employeeRole,
                                  e.employeeCreateDate,
                                  e.employeeCity,
                                  e.employeePhone,
                                  e.employeeEmail,
                                  s.storeName,
                                  she.storeId,
                                  she.employeeId
                                  FROM storehasemployees as she
                                  INNER JOIN employees as e ON she.employeeId = e.employeeId
                                  INNER JOIN stores as s ON she.storeId = s.storeId
                                  WHERE she.storeId = :storeId");
        $this->db->bind(':storeId', $storeId);
        return $this->db->resultSet();
    }
}