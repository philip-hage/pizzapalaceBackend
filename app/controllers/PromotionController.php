<?php

class PromotionController extends Controller
{
    private $promotionModel;
    private $screenModel;

    public function __construct()
    {
        $this->promotionModel = $this->model('PromotionModel');
        $this->screenModel = $this->model('ScreenModel');
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

            $image = $this->screenModel->getScreenDataById($promotionId, 'promotion', 'main');
            if ($image !== false) {
                // Check if the necessary properties exist before accessing them
                if (property_exists($image, 'screenCreateDate') && property_exists($image, 'screenId')) {
                    $createDate = date('Ymd', $image->screenCreateDate);
                    $imageSrc = URLROOT . 'public/media/' . $createDate . '/' . $image->screenId . '.jpg';
                } else {
                    // Handle the case where expected properties are missing
                    $imageSrc = URLROOT . 'public/default-image.jpg';
                }
            } else {
                // Handle the case where no image data is found
                $imageSrc = URLROOT . 'public/default-image.jpg';
            }

            $data = [
                'row' => $row,
                'imageSrc' => $imageSrc,
                'image' => $image
            ];
            $this->view('backend/promotions/update', $data);
        }
    }

    public function updateImage($promotionId)
    {
        global $var;
        $screenId = $var['rand'];
        $imageUploaderResult = $this->imageUploader($screenId);

        if ($imageUploaderResult['status'] === 200 && strpos($imageUploaderResult['message'], 'Image uploaded successfully') !== false) {
            $entity = 'promotion';
            $this->screenModel->insertScreenImages($screenId, $promotionId, $entity, 'main');
            $toast = urlencode('true');
            $toasttitle = urlencode('Success');
            $toastmessage = urlencode('Your create of the image was successful');
            header('Location:' . URLROOT . 'PromotionController/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
        } else {
            Helper::log('error', $imageUploaderResult);
            $toast = urlencode('false');
            $toasttitle = urlencode('Failed');
            $toastmessage = urlencode('Your create of the image has failed');
            header('Location:' . URLROOT . 'PromotionController/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
        }
    }

    public function deleteImage($screenId)
    {
        // Call the deleteScreen method from the model
        if (!$this->screenModel->deleteScreen($screenId)) {
            $toast = urlencode('true');
            $toasttitle = urlencode('Success');
            $toastmessage = urlencode('Image deleted successfully');
            header('Location:' . URLROOT . 'PromotionController/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
        } else {
            $toast = urlencode('false');
            $toasttitle = urlencode('Failed');
            $toastmessage = urlencode('Image deleted Failed');
            header('Location:' . URLROOT . 'PromotionController/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
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
