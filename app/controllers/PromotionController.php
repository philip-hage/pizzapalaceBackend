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

            $promotionName = ($post['promotionName']);

            if (empty($promotionName)) {
                $toast = urlencode('false');
                $toasttitle = urlencode('Failed');
                $toastmessage = urlencode('Your create of the promotion has failed');
                header('Location:' . URLROOT . 'PromotionController/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
            } else {
                $this->promotionModel->create($post);
                $toast = urlencode('true');
                $toasttitle = urlencode('Success');
                $toastmessage = urlencode('Your create of the promotion was successful');
                header('Location:' . URLROOT . 'PromotionController/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
            }
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
            // Helper::dump($post);exit;
            $result = $this->promotionModel->update($post);

            if (!$result) {
                $toast = urlencode('true');
                $toasttitle = urlencode('Success');
                $toastmessage = urlencode('Your update of the promotion was successful');
                header('Location:' . URLROOT . 'PromotionController/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
            } else {
                $toast = urlencode('false');
                $toasttitle = urlencode('Failed');
                $toastmessage = urlencode('Your update of the promotion has failed');
                header('Location:' . URLROOT . 'PromotionController/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
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
        if ($_SERVER["REQUEST_METHOD"] == 'POST') {
            $result = $this->promotionModel->delete($promotionId);

            if (!$result) {
                $toast = urlencode('true');
                $toasttitle = urlencode('Success');
                $toastmessage = urlencode('Your delete of the promotion was successful');
                header('Location:' . URLROOT . 'PromotionController/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
            } else {
                $toast = urlencode('false');
                $toasttitle = urlencode('Failed');
                $toastmessage = urlencode('Your delete of the promotion has failed');
                header('Location:' . URLROOT . 'PromotionController/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
            }
        } else {

            $data = [
                'title' => 'Delete Promotion',
                'promotionId' => $promotionId
            ];
            $this->view('backend/promotions/delete', $data);
        }
    }
}
