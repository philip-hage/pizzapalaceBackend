<?php

class PromotionModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }
    public function getPromotions()
    {
        $this->db->query("SELECT promotionId,
                                 promotionName,
                                 promotionStartDate,
                                 promotionEndDate,
                                 promotionCreateDate
                                 FROM promotions
                                 WHERE promotionIsActive = 1");
        return $this->db->resultSet();
    }

    public function getPromotionById($promotionId)
    {
        $this->db->query("SELECT promotionId,
                                 promotionName,
                                 promotionStartDate,
                                 promotionEndDate,
                                 promotionCreateDate
                                 FROM promotions
                                 WHERE promotionIsActive = 1 AND promotionId = :id");
        $this->db->bind(":id", $promotionId);
        return $this->db->single();
    }

    public function getSinglePromotion($promotionId)
    {
        $this->db->query("SELECT promotionId,
                                 promotionName,
                                 promotionStartDate,
                                 promotionEndDate,
                                 promotionCreateDate
                                 FROM promotions
                                 WHERE promotionIsActive = 1 AND promotionId = :id");
        $this->db->bind(":id", $promotionId);
        $result = $this->db->single();

        if ($result) {
            return [$result->promotionName];
        } else {
            return null;
        }
    }

    public function create($post)
    {
        global $var;

        // Convert date strings to Unix timestamps
        $startDateTimestamp = strtotime($post["promotionStartDate"]);
        $endDateTimestamp = strtotime($post["promotionEndDate"]);

        $this->db->query("INSERT INTO promotions (promotionId,
                                            promotionName,
                                            promotionStartDate,
                                            promotionEndDate,
                                            promotionCreateDate)
                                            VALUES (:id, :promotionName, :promotionStartDate, :promotionEndDate, :promotionCreateDate)");

        $this->db->bind(":id", $var['rand']);
        $this->db->bind(":promotionName", $post["promotionName"]);
        $this->db->bind(":promotionStartDate", $startDateTimestamp); // Bind Unix timestamp
        $this->db->bind(":promotionEndDate", $endDateTimestamp); // Bind Unix timestamp
        $this->db->bind(":promotionCreateDate", $var['timestamp']);

        return $this->db->execute();
    }

    public function update($post)
    {
        $startDateTimestamp = strtotime($post["promotionStartDate"]);
        $endDateTimestamp = strtotime($post["promotionEndDate"]);

        $this->db->query("UPDATE promotions SET promotionName = :promotionName,
                                                promotionStartDate = :promotionStartDate,
                                                promotionEndDate = :promotionEndDate
                    WHERE promotionId = :id");
        $this->db->bind(':id', $post['id']);
        $this->db->bind(':promotionName', $post['promotionName']);
        $this->db->bind(':promotionStartDate', $startDateTimestamp);
        $this->db->bind(':promotionEndDate',  $endDateTimestamp);
        $this->db->execute();
    }

    public function delete($promotionId)
    {
        $this->db->query("UPDATE promotions SET promotionIsActive = 0 WHERE promotionId = :id");
        $this->db->bind(':id', $promotionId);
        $this->db->execute();
    }
}
