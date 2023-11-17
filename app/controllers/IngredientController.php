<?php

class IngredientController extends Controller
{
    private $ingredientModel;
    private $screenModel;

    public function __construct()
    {
        $this->ingredientModel = $this->model('IngredientModel');
        $this->screenModel = $this->model('ScreenModel');
    }

    public function index()
    {
        $data = [
            'title' => 'Pizza Palace'
        ];
        $this->view('backend/index', $data);
    }

    public function overview()
    {
        $ingredients = $this->ingredientModel->getIngredients();
        $countIngredients = count($this->ingredientModel->getIngredients());

        $data = [
            'ingredients' => $ingredients,
            'countIngredients' => $countIngredients
        ];
        $this->view('backend/ingredient/overview', $data);
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $result =  $this->ingredientModel->create($post);

            if ($result) {
                header('Location: ' . URLROOT . 'IngredientController/overview');
            } else {
                Helper::log('error', 'The create was not succcesfull at Ingredient create');
                header('Location: ' . URLROOT . 'IngredientController/overview');
            }
        } else {
            $data = [
                'title' => 'Create Ingredient'
            ];
            $this->view('backend/ingredient/create', $data);
        }
    }

    public function delete($ingredientId)
    {
        if ($_SERVER["REQUEST_METHOD"] == 'POST') {
            $result = $this->ingredientModel->delete($ingredientId);

            if (!$result) {
                $toast = urlencode('true');
                $toasttitle = urlencode('Success');
                $toastmessage = urlencode('Your delete of the ingredient was successful');
                header('Location:' . URLROOT . 'IngredientController/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
            } else {
                $toast = urlencode('false');
                $toasttitle = urlencode('Failed');
                $toastmessage = urlencode('Your delete of the ingredient has failed');
                header('Location:' . URLROOT . 'IngredientController/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
            }
        } else {

            $data = [
                'title' => 'Delete ingredient',
                'ingredientId' => $ingredientId
            ];
            $this->view('backend/ingredient/delete', $data);
        }
    }

    public function update($ingredientId)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $result = $this->ingredientModel->update($post);

            if (!$result) {
                echo 'The update was successful';
                header('Refresh: 3; url=' . URLROOT . '/IngredientController/overview/');
            } else {
                Helper::log('error', 'The update was not succcesfull at ingredient update');
                header('Refresh: 3; url=' . URLROOT . '/IngredientController/overview/');
            }
        } else {
            $row = $this->ingredientModel->getIngredientById($ingredientId);
            $image = $this->screenModel->getScreenDataById($ingredientId, 'ingredient', 'main');
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
                'title' => '<h3>Update ingredient</h3>',
                'row' => $row,
                'imageSrc' => $imageSrc,
                'image' => $image
            ];
            $this->view('backend/ingredient/update', $data);
        }
    }

    public function updateImage($ingredientId)
    {
        global $var;
        $screenId = $var['rand'];
        $imageUploaderResult = $this->imageUploader($screenId);

        if ($imageUploaderResult['status'] === 200 && strpos($imageUploaderResult['message'], 'Image uploaded successfully') !== false) {
            $entity = 'ingredient';
            $this->screenModel->insertScreenImages($screenId, $ingredientId, $entity, 'main');
            $toast = urlencode('true');
            $toasttitle = urlencode('Success');
            $toastmessage = urlencode('Your create of the image was successful');
            header('Location:' . URLROOT . 'IngredientController/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
        } else {
            Helper::log('error', $imageUploaderResult);
            $toast = urlencode('false');
            $toasttitle = urlencode('Failed');
            $toastmessage = urlencode('Your create of the image has failed');
            header('Location:' . URLROOT . 'IngredientController/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
        }
    }

    public function deleteImage($screenId)
    {
        // Call the deleteScreen method from the model
        if (!$this->screenModel->deleteScreen($screenId)) {
            $toast = urlencode('true');
            $toasttitle = urlencode('Success');
            $toastmessage = urlencode('Image deleted successfully');
            header('Location:' . URLROOT . 'IngredientController/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
        } else {
            $toast = urlencode('false');
            $toasttitle = urlencode('Failed');
            $toastmessage = urlencode('Image deleted Failed');
            header('Location:' . URLROOT . 'IngredientController/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
        }
    }
}
