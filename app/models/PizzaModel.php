<?php

class PizzaModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getPizzas()
    {
        $this->db->query("SELECT productId,
                                 productName,
                                 productPrice,
                                 productType,
                                 productPath 
                                 FROM products 
                                 WHERE productType = 'pizza' AND productIsActive = 1
                                 ORDER BY productName ASC");
        return $this->db->resultSet();
    }

    public function getDrinks()
    {
        $this->db->query("SELECT productId,
                                 productName,
                                 productPrice,
                                 productType,
                                 productPath 
                                 FROM products 
                                 WHERE productType = 'drink' AND productIsActive = 1");
        return $this->db->resultSet();
    }

    public function getSnacks()
    {
        $this->db->query("SELECT productId,
                                 productName,
                                 productPrice,
                                 productType,
                                 productPath 
                                 FROM products 
                                 WHERE productType = 'snack' AND productIsActive = 1");
        return $this->db->resultSet();
    }

    public function getPromotions()
    {
        $this->db->query("SELECT promotionId,
                                 promotionName,
                                 promotionStartDate,
                                 promotionEndDate
                                 FROM promotions
                                 WHERE promotionIsActive = 1");
        return $this->db->resultSet();
    }

    public function getReviews()
    {
        $this->db->query("SELECT r.reviewId,
                                 r.reviewCustomerId,
                                 r.reviewRating,
                                 c.customerFirstName,
                                 c.customerLastName
                                 FROM reviews as r
                                 INNER JOIN customers as c ON r.reviewCustomerId = c.customerId
                                 WHERE reviewIsActive = 1");
        return $this->db->resultSet();
    }


    // Customers 

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

    public function editCustomer($post)
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

    public function createCustomer($post)
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



    // Orders

    public function getOrders()
    {
        $this->db->query("SELECT o.orderId,
                                 o.orderStoreId,
                                 o.orderCustomerId,
                                 o.orderPrice,
                                 o.orderCreateDate,
                                 c.customerFirstName,
                                 c.customerLastName,
                                 s.storeName
                                 FROM orders as o 
                                 INNER JOIN customers as c ON o.orderCustomerId = c.customerId
                                 INNER JOIN stores as s ON o.orderStoreId = s.storeId");
        return $this->db->resultSet();
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


    // Ingredient

    public function getIngredients()
    {
        $this->db->query("SELECT ingredientId,
                                 ingredientName,
                                 ingredientPrice,
                                 ingredientCreateDate
                                 FROM ingredients
                                 WHERE ingredientIsActive = 1");
        return $this->db->resultSet();
    }

    public function getIngredientById($ingredientId)
    {
        $this->db->query("SELECT ingredientId,
                                 ingredientName,
                                 ingredientPrice,
                                 ingredientCreateDate
                                 FROM ingredients
                                 WHERE ingredientIsActive = 1 AND ingredientId = :id");
        $this->db->bind(":id", $ingredientId);
        return $this->db->single();
    }

    public function createIngredient($post)
    {
        global $var;
        $this->db->query("INSERT INTO ingredients (
                                                ingredientId,
                                                ingredientName,
                                                ingredientPrice,
                                                ingredientCreateDate) VALUES (
                                                    :id, :ingredientName, :ingredientPrice, :ingredientCreateDate)");
        $this->db->bind(":id", $var['rand']);
        $this->db->bind(":ingredientName", $post["ingredientName"]);
        $this->db->bind(":ingredientPrice", $post["ingredientPrice"]);
        $this->db->bind(":ingredientCreateDate", $var['timestamp']);
        return $this->db->execute();
    }

    public function deleteIngredient($ingredientId)
    {
        $this->db->query("UPDATE ingredients SET ingredientIsActive = 0 WHERE ingredientId = :id");
        $this->db->bind(':id', $ingredientId);
        $this->db->execute();
    }

    public function editIngredient($post)
    {
        try {
            $this->db->query("UPDATE ingredients SET ingredientName = :ingredientName,
                                                ingredientPrice = :ingredientPrice
                    WHERE ingredientId = :id");
            $this->db->bind(':id', $post['id']);
            $this->db->bind(':ingredientName', $post['ingredientName']);
            $this->db->bind(':ingredientPrice', $post['ingredientPrice']);
            $this->db->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    //employees

    public function getEmployees()
    {
        $this->db->query("SELECT employeeId,
                                 employeeFirstName,
                                 employeeLastName,
                                 employeeRole,
                                 employeeCreateDate,
                                 employeeCity,
                                 employeePhone,
                                 employeeEmail
                                 FROM employees
                                 WHERE employeeIsActive = 1");
        return $this->db->resultSet();
    }

    public function getEmployeeById($employeeId)
    {
        $this->db->query("SELECT employeeId,
                                 employeeFirstName,
                                 employeeLastName,
                                 employeeRole,
                                 employeeCreateDate,
                                 employeeCity,
                                 employeePhone,
                                 employeeEmail,
                                 employeeStreetName,
                                 employeeZipCode
                                 FROM employees
                                 WHERE employeeIsActive = 1 AND employeeId = :id");
        $this->db->bind(":id", $employeeId);
        return $this->db->single();
    }

    public function editEmployee($post)
    {
        try {
            $this->db->query("UPDATE employees SET employeeFirstName = :employeeFirstName,
                                                employeeLastName = :employeeLastName,
                                                employeeStreetName = :employeeStreetName,
                                                employeeCity = :employeeCity,
                                                employeeZipCode = :employeeZipCode,
                                                employeePhone = :employeePhone,
                                                employeeEmail = :employeeEmail,
                                                employeeRole = :employeeRole
                    WHERE employeeId = :id");
            $this->db->bind(':id', $post['id']);
            $this->db->bind(':employeeFirstName', $post['employeeFirstName']);
            $this->db->bind(':employeeLastName', $post['employeeLastName']);
            $this->db->bind(':employeeStreetName', $post['employeeStreetName']);
            $this->db->bind(':employeeCity', $post['employeeCity']);
            $this->db->bind(':employeeZipCode', $post['employeeZipCode']);
            $this->db->bind(':employeePhone', $post['employeePhone']);
            $this->db->bind(':employeeEmail', $post['employeeEmail']);
            $this->db->bind(':employeeRole', $post['employeeRole']);
            $this->db->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function createEmployee($post)
    {
        global $var;
        $this->db->query("INSERT INTO employees (
                                                employeeId,
                                                employeeFirstName,
                                                employeeRole,
                                                employeeCreateDate,
                                                employeeLastName,
                                                employeeStreetName,
                                                employeeZipCode,
                                                employeeCity,
                                                employeePhone,
                                                employeeEmail) VALUES (
                                                    :id, :employeeFirstName, :employeeRole, :employeeCreateDate, :employeeLastName, :employeeStreetName, :employeeZipCode,
                                                    :employeeCity, :employeePhone, :employeeEmail)");
        $this->db->bind(":id", $var['rand']);
        $this->db->bind(":employeeFirstName", $post["employeeFirstName"]);
        $this->db->bind(":employeeRole", $post["employeeRole"]);
        $this->db->bind(":employeeCreateDate", $var['timestamp']);
        $this->db->bind(":employeeLastName", $post["employeeLastName"]);
        $this->db->bind(":employeeStreetName", $post["employeeStreetName"]);
        $this->db->bind(":employeeZipCode", $post["employeeZipCode"]);
        $this->db->bind(":employeeCity", $post["employeeCity"]);
        $this->db->bind(":employeePhone", $post["employeePhone"]);
        $this->db->bind(":employeeEmail", $post["employeeEmail"]);
        return $this->db->execute();
    }

    public function deleteEmployee($employeeId)
    {
        $this->db->query("UPDATE employees SET employeeIsActive = 0 WHERE employeeId = :id");
        $this->db->bind(':id', $employeeId);
        $this->db->execute();
    }

    // store

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

    public function createStore($post)
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

    public function deleteStore($storeId)
    {
        $this->db->query("UPDATE stores SET storeIsActive = 0 WHERE storeId = :id");
        $this->db->bind(':id', $storeId);
        $this->db->execute();
    }

    public function editStore($post)
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

    // vehicles

    public function getVehicles()
    {
        $this->db->query("SELECT v.vehicleId,
                                 v.vehicleStoreId,
                                 v.vehicleName,
                                 v.vehicleType,
                                 v.vehicleCreateDate,
                                 v.vehicleMaintenanceDate,
                                 s.storeName
                                 FROM vehicles as v
                                 INNER JOIN stores as s ON v.vehicleStoreId = s.storeId
                                 WHERE vehicleIsActive = 1");
        return $this->db->resultSet();
    }

    public function getVehicleById($vehicleId)
    {
        $this->db->query("SELECT v.vehicleId,
        v.vehicleStoreId,
        v.vehicleName,
        v.vehicleType,
        v.vehicleCreateDate,
        v.vehicleMaintenanceDate,
        s.storeName
        FROM vehicles as v
        INNER JOIN stores as s ON v.vehicleStoreId = s.storeId
        WHERE vehicleIsActive = 1 AND v.vehicleId = :id");
        $this->db->bind(":id", $vehicleId);
        return $this->db->single();
    }

    public function createVehicle($post)
    {
        global $var;
        $vehicleCreateDate = $var['timestamp']; // Original Unix timestamp for vehicleCreateDate

        // Calculate the Unix timestamp for vehicleMaintenanceDate
        $threeMonthsInSeconds = 3 * 30 * 24 * 60 * 60; // Three months in seconds
        $vehicleMaintenanceDate = $vehicleCreateDate + $threeMonthsInSeconds;
        $this->db->query("INSERT INTO vehicles (
                                                vehicleId,
                                                vehicleStoreId,
                                                vehicleName,
                                                vehicleType,
                                                vehicleCreateDate,
                                                vehicleMaintenanceDate
                                                ) VALUES (
                                                    :id, :vehicleStoreId, :vehicleName, :vehicleType, :vehicleCreateDate, :vehicleMaintenanceDate)");
        $this->db->bind(":id", $var['rand']);
        $this->db->bind(":vehicleStoreId", $post["vehicleStoreId"]);
        $this->db->bind(":vehicleName", $post["vehicleName"]);
        $this->db->bind(":vehicleType", $post["vehicleType"]);
        $this->db->bind(":vehicleCreateDate", $vehicleCreateDate);
        $this->db->bind(":vehicleMaintenanceDate", $vehicleMaintenanceDate);
        return $this->db->execute();
    }

    public function getVehicleByStore($storeId)
    {
        $this->db->query("SELECT v.vehicleId,
                                 v.vehicleStoreId,
                                 v.vehicleName,
                                 v.vehicleType,
                                 v.vehicleCreateDate,
                                 v.vehicleMaintenanceDate,
                                 s.storeName
                                 FROM vehicles as v
                                 INNER JOIN stores as s ON v.vehicleStoreId = s.storeId
                                 WHERE vehicleIsActive = 1 AND v.vehicleStoreId = :storeId");
        $this->db->bind(':storeId', $storeId);
        return $this->db->resultSet();
    }

    public function editVehicle($post)
    {
        $this->db->query("UPDATE vehicles SET vehicleName = :vehicleName,
                                                vehicleStoreId = :vehicleStoreId,
                                                vehicleType = :vehicleType
                    WHERE vehicleId = :id");
        $this->db->bind(':id', $post['id']);
        $this->db->bind(':vehicleName', $post['vehicleName']);
        $this->db->bind(':vehicleStoreId', $post['vehicleStoreId']);
        $this->db->bind(':vehicleType', $post['vehicleType']);
        $this->db->execute();
    }

    public function deleteVehicle($vehicleId)
    {
        $this->db->query("UPDATE vehicles SET vehicleIsActive = 0 WHERE vehicleId = :id");
        $this->db->bind(':id', $vehicleId);
        $this->db->execute();
    }

    // product

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

    public function createProduct($post)
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

    public function deleteProduct($productId)
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
