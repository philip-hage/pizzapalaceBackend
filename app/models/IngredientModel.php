<?php

class IngredientModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

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

    public function getIngredientsByPagination($offset, $limit)
    {
        $this->db->query("SELECT ingredientId,
                                 ingredientName,
                                 ingredientPrice,
                                 ingredientCreateDate
                                 FROM ingredients
                                 WHERE ingredientIsActive = 1 LIMIT :offset, :limit");
        $this->db->bind(':offset', $offset);
        $this->db->bind('limit', $limit);
        return $this->db->resultSet();
    }

    public function getTotalIngredientsCount()
    {
        $this->db->query("SELECT COUNT(*) as total FROM ingredients WHERE ingredientIsActive = 1");
        $result = $this->db->single();

        return $result->total;
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

    public function getSingleIngredient($ingredientId)
    {
        $this->db->query("SELECT ingredientId,
                                 ingredientName,
                                 ingredientPrice,
                                 ingredientCreateDate
                                 FROM ingredients
                                 WHERE ingredientIsActive = 1 AND ingredientId = :id");
        $this->db->bind(":id", $ingredientId);
        $result = $this->db->single();

        if ($result) {
            return [$result->ingredientName];
        } else {
            return null;
        }
    }

    public function create($post)
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

    public function delete($ingredientId)
    {
        $this->db->query("UPDATE ingredients SET ingredientIsActive = 0 WHERE ingredientId = :id");
        $this->db->bind(':id', $ingredientId);
        $this->db->execute();
    }

    public function update($post)
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
}
