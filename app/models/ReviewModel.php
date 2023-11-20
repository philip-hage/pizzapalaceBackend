<?php

class ReviewModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getReviews()
    {
        $this->db->query("SELECT r.reviewId,
                                 r.reviewCustomerId,
                                 r.reviewRating,
                                 r.reviewEntityId,
                                 r.reviewEntity,
                                 r.reviewDescription,
                                 r.reviewCreateDate,
                                 c.customerFirstName,
                                 c.customerLastName
                                 FROM reviews as r
                                 INNER JOIN customers as c ON r.reviewCustomerId = c.customerId
                                 WHERE reviewIsActive = 1");
        return $this->db->resultSet();
    }

    public function getReviewsByPagination($offset, $limit)
    {
        $this->db->query("SELECT r.reviewId,
                                 r.reviewCustomerId,
                                 r.reviewRating,
                                 r.reviewEntityId,
                                 r.reviewEntity,
                                 r.reviewDescription,
                                 r.reviewCreateDate,
                                 c.customerFirstName,
                                 c.customerLastName
                                 FROM reviews as r
                                 INNER JOIN customers as c ON r.reviewCustomerId = c.customerId
                                 WHERE reviewIsActive = 1
                                 LIMIT :offset, :limit");
        $this->db->bind(':offset', $offset);
        $this->db->bind('limit', $limit);
        return $this->db->resultSet();
    }

    public function getTotalReviewsCount()
    {
        $this->db->query("SELECT COUNT(*) as total FROM reviews WHERE reviewIsActive = 1");
        $result = $this->db->single();

        return $result->total;
    }

    public function getReviewById($reviewId)
    {
        $this->db->query("SELECT r.reviewId,
                                 r.reviewCustomerId,
                                 r.reviewRating,
                                 r.reviewEntityId,
                                 r.reviewEntity,
                                 r.reviewDescription,
                                 r.reviewCreateDate,
                                 c.customerFirstName,
                                 c.customerLastName
                                 FROM reviews as r
                                 INNER JOIN customers as c ON r.reviewCustomerId = c.customerId
                                 WHERE reviewIsActive = 1 AND r.reviewId = :id");
        $this->db->bind(":id", $reviewId);
        return $this->db->single();
    }

    public function update($post)
    {
        $this->db->query("UPDATE reviews SET reviewRating = :reviewRating,
                                                reviewCustomerId = :reviewCustomerId,
                                                reviewDescription = :reviewDescription
                    WHERE reviewId = :id");
        $this->db->bind(':id', $post['id']);
        $this->db->bind(':reviewRating', $post['reviewRating']);
        $this->db->bind(':reviewDescription', $post['reviewDescription']);
        $this->db->bind(':reviewCustomerId', $post['reviewCustomerId']);
        $this->db->execute();
    }

    public function create($post)
    {
        global $var;
        $this->db->query("INSERT INTO reviews (
                                                reviewId,
                                                reviewCustomerId,
                                                reviewEntityId,
                                                reviewEntity,
                                                reviewDescription,
                                                reviewRating,
                                                reviewCreateDate) VALUES (
                                                    :id, :reviewCustomerId, :reviewEntityId, :reviewEntity, :reviewDescription, :reviewRating, :reviewCreateDate)");
        $this->db->bind(":id", $var['rand']);
        $this->db->bind(":reviewCustomerId", $post["reviewCustomerId"]);
        $this->db->bind(":reviewEntityId", $post["reviewEntityId"]);
        $this->db->bind(":reviewEntity", $post["reviewEntity"]);
        $this->db->bind(":reviewRating", $post["reviewRating"]);
        $this->db->bind(":reviewDescription", $post["reviewDescription"]);
        $this->db->bind(":reviewCreateDate", $var['timestamp']);
        return $this->db->execute();
    }

    public function delete($reviewId)
    {
        $this->db->query("UPDATE reviews SET reviewIsActive = 0 WHERE reviewId = :id");
        $this->db->bind(':id', $reviewId);
        $this->db->execute();
    }
}
