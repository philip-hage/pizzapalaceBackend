<?php

class Promotion extends Controller
{
    private $promotionModel;
    private $screenModel;

    public function __construct()
    {
        $this->promotionModel = $this->model('PromotionModel');
        $this->screenModel = $this->model('ScreenModel');
    }

    public function overview($params)
    {

        // Extract page number from $params
        $pageNumber = isset($params['page']) ? intval($params['page']) : 1;

        // Define records per page and calculate offset
        $recordsPerPage = 2; // You can adjust this based on your needs
        $offset = ($pageNumber - 1) * $recordsPerPage;

        // Get customers for the current page
        $promotions = $this->promotionModel->getPromotionsByPagination($offset, $recordsPerPage);

        // Get total number of customers
        $countPromotions = $this->promotionModel->getTotalPromotionsCount();

        // Calculate total number of pages
        $totalPages = ceil($countPromotions / $recordsPerPage);

        // Ensure $pageNumber is within valid range
        $pageNumber = max(1, min($pageNumber, $totalPages));

        $data = [
            'promotions' => $promotions,
            'countPromotions' => $countPromotions,
            'currentPage' => $pageNumber,
            'recordsPerPage' => $recordsPerPage,
            'totalPages' => $totalPages,
        ];
        $this->view('backend/promotions/overview', $data);
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $promotionName = ($post['promotionName']);

            if (empty($promotionName)) {
                header('Location:' . URLROOT . 'Promotion/overview/{toast:false;toasttitle:Failed;toastmessage:Your+create+of+the+promotion+has+failed}');
            } else {
                $this->promotionModel->create($post);
                header('Location:' . URLROOT . 'Promotion/overview/{toast:true;toasttitle:Success;toastmessage:Your+create+of+the+promotion+was+successful}');
            }
        } else {
            $data = [
                'title' => 'Create Promotion'
            ];
            $this->view('backend/promotions/create', $data);
        }
    }

    public function update($params = NULL)
    {
        $promotionId = $params['promotionId'];
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            // Helper::dump($post);exit;
            $result = $this->promotionModel->update($post);

            if (!$result) {
                header('Location:' . URLROOT . 'Promotion/overview/{toast:true;toasttitle:Success;toastmessage:Your+update+of+the+promotion+was+successful}');
            } else {
                header('Location:' . URLROOT . 'Promotion/overview/{toast:false;toasttitle:Failed;toastmessage:Your+update+of+the+promotion+has+failed}');
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

    public function updateImage($params = NULL)
    {
        $promotionId = $params['promotionId'];
        global $var;
        $screenId = $var['rand'];
        $imageUploaderResult = $this->imageUploader($screenId);

        if ($imageUploaderResult['status'] === 200 && strpos($imageUploaderResult['message'], 'Image uploaded successfully') !== false) {
            $entity = 'promotion';
            $this->screenModel->insertScreenImages($screenId, $promotionId, $entity, 'main');
            header('Location:' . URLROOT . 'Promotion/update/{promotionId:' . $promotionId . ';' . 'toast:true;toasttitle:Success;toastmessage:Your+create+of+the+image+was+successful}');
        } else {
            Helper::log('error', $imageUploaderResult);
            header('Location:' . URLROOT . 'Promotion/update/{promotionId:' . $promotionId . ';' . 'toast:false;toasttitle:Failed;toastmessage:Your+create+of+the+image+has+failed}');
        }
    }

    public function deleteImage($params = NULL)
    {
        $screenId = $params['screenId'];
        $promotionId = $params['promotionId'];
        // Call the deleteScreen method from the model
        if (!$this->screenModel->deleteScreen($screenId)) {
            header('Location:' . URLROOT . 'Promotion/update/{promotionId:' . $promotionId . ';' . 'toast:true;toasttitle:Success;toastmessage:Image+deleted+of+successfully}');
        } else {
            header('Location:' . URLROOT . 'Promotion/update/{promotionId:' . $promotionId . ';' . 'toast:false;toasttitle:Failed;toastmessage:Image+deleted+of+Failed}');
        }
    }

    public function delete($params)
    {
        $promotionId = $params['promotionId'];
        if ($_SERVER["REQUEST_METHOD"] == 'POST') {
            $result = $this->promotionModel->delete($promotionId);

            if (!$result) {
                header('Location:' . URLROOT . 'Promotion/overview/{toast:true;toasttitle:Success;toastmessage:Your+delete+of+the+promotion+was+successful}');
            } else {
                header('Location:' . URLROOT . 'Promotion/overview/{toast:false;toasttitle:Failed;toastmessage:Your+delete+of+the+promotion+has+failed}');
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
