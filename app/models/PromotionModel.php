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

    public function getPromotionsByPagination($offset, $limit)
    {
        $this->db->query("SELECT promotionId,
                                 promotionName,
                                 promotionStartDate,
                                 promotionEndDate,
                                 promotionCreateDate
                                 FROM promotions
                                 WHERE promotionIsActive = 1
                                 LIMIT :offset, :limit");
        $this->db->bind(':offset', $offset);
        $this->db->bind('limit', $limit);
        return $this->db->resultSet();
    }

    public function getTotalPromotionsCount()
    {
        $this->db->query("SELECT COUNT(*) as total FROM promotions WHERE promotionIsActive = 1");
        $result = $this->db->single();

        return $result->total;
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
        $startDate = DateTime::createFromFormat('d/m/Y', $post['promotionStartDate'])->getTimestamp();
        $endDate = DateTime::createFromFormat('d/m/Y', $post['promotionEndDate'])->getTimestamp();

        $this->db->query("INSERT INTO promotions (promotionId,
                                            promotionName,
                                            promotionStartDate,
                                            promotionEndDate,
                                            promotionCreateDate)
                                            VALUES (:id, :promotionName, :promotionStartDate, :promotionEndDate, :promotionCreateDate)");

        $this->db->bind(":id", $var['rand']);
        $this->db->bind(":promotionName", $post["promotionName"]);
        $this->db->bind(":promotionStartDate", $startDate); // Bind Unix timestamp
        $this->db->bind(":promotionEndDate", $endDate); // Bind Unix timestamp
        $this->db->bind(":promotionCreateDate", $var['timestamp']);

        return $this->db->execute();
    }

    public function update($post)
    {

        $startDate = DateTime::createFromFormat('d/m/Y', $post['promotionStartDate'])->getTimestamp();
        $endDate = DateTime::createFromFormat('d/m/Y', $post['promotionEndDate'])->getTimestamp();




        $this->db->query("UPDATE promotions SET promotionName = :promotionName,
                                                promotionStartDate = :promotionStartDate,
                                                promotionEndDate = :promotionEndDate
                    WHERE promotionId = :id");
        $this->db->bind(':id', $post['id']);
        $this->db->bind(':promotionName', $post['promotionName']);
        $this->db->bind(':promotionStartDate', $startDate);
        $this->db->bind(':promotionEndDate',  $endDate);
        $this->db->execute();
    }

    public function delete($promotionId)
    {
        $this->db->query("UPDATE promotions SET promotionIsActive = 0 WHERE promotionId = :id");
        $this->db->bind(':id', $promotionId);
        $this->db->execute();
    }
}
