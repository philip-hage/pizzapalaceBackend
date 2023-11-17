<?php 
class CustomerModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getCustomers()
    {
        $this->db->query("SELECT customerId,
                                 customerFirstName,
                                 customerLastName,
                                 customerStreetName,
                                 customerZipCode,
                                 customerCity,
                                 customerEmail,
                                 customerPhone,
                                 customerType,
                                 customerCreateDate
                                 FROM customers
                                 WHERE customerIsActive = 1");
        return $this->db->resultSet();
    }

    public function getCustomersByPagination($offset, $limit)
    {
        $this->db->query("SELECT customerId,
                                 customerFirstName,
                                 customerLastName,
                                 customerStreetName,
                                 customerZipCode,
                                 customerCity,
                                 customerEmail,
                                 customerPhone,
                                 customerType,
                                 customerCreateDate
                                 FROM customers
                                 WHERE customerIsActive = 1 LIMIT :offset, :limit");
        $this->db->bind(':offset', $offset);
        $this->db->bind('limit', $limit);
        return $this->db->resultSet();
    }

    public function getTotalCustomersCount()
    {
        $this->db->query("SELECT COUNT(*) as total FROM customers WHERE customerIsActive = 1");
        $result = $this->db->single();

        return $result->total;
    }

    public function getCustomerTypes()
    {
        $this->db->query("SELECT DISTINCT customerType FROM customers WHERE customerIsActive = 1");
        return $this->db->resultSet();
    }

    public function getCustomerById($customerId)
    {
        $this->db->query("SELECT customerId, customerFirstName, customerLastName, customerStreetName, customerCity, customerZipCode, customerPhone, customerEmail, customerType, customerIsActive, Customercreatedate 
        FROM customers WHERE customerId = :customerId");
        $this->db->bind(':customerId', $customerId);
        $result = $this->db->single();

        if ($result) {
            return [$result->customerFirstName, $result->customerLastName];
        } else {
            return null;
        }
    }
    public function deleteCustomer($id)
    {
        $this->db->query("UPDATE customers SET customerIsActive = 0 WHERE customerId = :id");
        $this->db->bind(':id', $id);
        $this->db->execute();
    }

    public function getSingleCustomer($customerId)
    {
        $this->db->query("SELECT customerId,
                                    customerFirstName,
                                    customerLastName,
                                    customerStreetName,
                                    customerCity,
                                    customerZipCode,
                                    customerPhone,
                                    customerEmail,
                                    customerType
                                    FROM customers
                                    WHERE customerId = :id");
        $this->db->bind(':id', $customerId);
        $row = $this->db->single();
        return $row;
    }

    public function update($post)
    {
        try {
            $this->db->query("UPDATE customers SET customerFirstName = :customerFirstName,
                                                customerLastName = :customerLastName,
                                                customerStreetName = :customerStreetName,
                                                customerCity = :customerCity,
                                                customerZipCode = :customerZipCode,
                                                customerPhone = :customerPhone,
                                                customerEmail = :customerEmail,
                                                customerType = :customerType
                    WHERE customerId = :id");
            $this->db->bind(':id', $post['id']);
            $this->db->bind(':customerFirstName', $post['customerFirstName']);
            $this->db->bind(':customerLastName', $post['customerLastName']);
            $this->db->bind(':customerStreetName', $post['customerStreetName']);
            $this->db->bind(':customerCity', $post['customerCity']);
            $this->db->bind(':customerZipCode', $post['customerZipCode']);
            $this->db->bind(':customerPhone', $post['customerPhone']);
            $this->db->bind(':customerEmail', $post['customerEmail']);
            $this->db->bind(':customerType', $post['customerType']);
            $this->db->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function create($post)
    {
        global $var;
        $this->db->query("INSERT INTO customers (customerId,
                                                customerFirstName,
                                                customerLastName,
                                                customerStreetName,
                                                customerZipCode,
                                                customerCity,
                                                customerEmail,
                                                customerPhone,
                                                customerType,
                                                customerCreateDate)
                                                VALUES (:id, :customerfirstname, :customerlastname, :customerstreetname, :customerzipcode, :customercity, :customeremail,
                                                :customerphone, :customertype, :customercreatedate)");
        $this->db->bind(":id", $var['rand']);
        $this->db->bind(":customerfirstname", $post["customerfirstname"]);
        $this->db->bind(":customerlastname", $post["customerlastname"]);
        $this->db->bind(":customerstreetname", $post["customerstreetname"]);
        $this->db->bind(":customerzipcode", $post["customerzipcode"]);
        $this->db->bind(":customercity", $post["customercity"]);
        $this->db->bind(":customeremail", $post["customeremail"]);
        $this->db->bind(":customerphone", $post["customerphone"]);
        $this->db->bind(":customertype", $post["customertype"]);
        $this->db->bind(":customercreatedate", $var['timestamp']);
        return $this->db->execute();
    }

    

}
