<?php

class EmployeeModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

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

    public function getEmployeesByPagination($offset, $limit)
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
                                 WHERE employeeIsActive = 1 LIMIT :offset, :limit");
        $this->db->bind(':offset', $offset);
        $this->db->bind('limit', $limit);
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

    public function getSingleEmployee($employeeId)
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
        $result = $this->db->single();

        if ($result) {
            return [$result->employeeFirstName, $result->employeeLastName];
        } else {
            return null;
        }
    }

    public function getTotalEmployeesCount()
    {
        $this->db->query("SELECT COUNT(*) as total FROM employees WHERE employeeIsActive = 1");
        $result = $this->db->single();

        return $result->total;
    }

    public function update($post)
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

    public function create($post)
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

    public function delete($employeeId)
    {
        $this->db->query("UPDATE employees SET employeeIsActive = 0 WHERE employeeId = :id");
        $this->db->bind(':id', $employeeId);
        $this->db->execute();
    }
}
