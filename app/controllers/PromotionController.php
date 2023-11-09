<?php

class PromotionController extends Controller
{
    private $promotionModel;

    public function __construct()
    {
        $this->promotionModel = $this->model('PromotionModel');
    }

    public function overview()
    {
        $promotions = $this->promotionModel->getPromotions();
        $countPromotions = count($this->promotionModel->getPromotions());

        $data = [
            'promotions' => $promotions,
            'countPromotions' => $countPromotions
        ];
        $this->view('backend/promotions/overview', $data);
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $this->promotionModel->create($post);
            header('Location: ' . URLROOT . 'PromotionController/overview');
        } else {
            $data = [
                'title' => 'Create Promotion'
            ];
            $this->view('backend/promotions/create', $data);
        }
    }

    public function update($promotionId)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $result = $this->promotionModel->update($post);

            if (!$result) {
                echo 'The update was successful';
                header('Refresh: 1; url=' . URLROOT . '/PromotionController/overview/' . $promotionId . '');
            } else {
                echo 'The update was not successful';
                header('Refresh: 1; url=' . URLROOT . '/PromotionController/overview/' . $promotionId . '');
            }
        } else {
            $row = $this->promotionModel->getPromotionById($promotionId);

            $data = [
                'row' => $row
            ];
            $this->view('backend/promotions/update', $data);
        }
    }

    public function delete($promotionId)
    {
        $promotionInfo = $this->promotionModel->getSinglePromotion($promotionId);

        if ($promotionInfo) {
            $promotionName = $promotionInfo[0];

            echo '<script>';
            echo 'if (confirm("Are you sure that you want to delete: ' . $promotionName . '")) {';
            echo '    window.location.href = "' . URLROOT . '/PromotionController/confirmDeletePromotion/' . $promotionId . '";';
            echo '} else {';
            echo '    window.location.href = "' . URLROOT . '/PromotionController/overview/' . $promotionId . '";';
            echo '}';
            echo '</script>';
        } else {
            echo 'Promotion Information not found';
        }
    }

    public function confirmDeletePromotion($promotionId)
    {
        if ($this->promotionModel->delete($promotionId)) {
            header('location: ' . URLROOT . '/PromotionController/overview');
        } else {
            header('location: ' . URLROOT . '/PromotionController/overview');
        }
    }
}
