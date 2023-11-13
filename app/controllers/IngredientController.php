<?php

class IngredientController extends Controller
{
    private $ingredientModel;

    public function __construct()
    {
        $this->ingredientModel = $this->model('IngredientModel');
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
        $ingredientInfo = $this->ingredientModel->getSingleIngredient($ingredientId);

        if ($ingredientInfo) {
            $IngredientName = $ingredientInfo[0];

            echo '<script>';
            echo 'if (confirm("Are you sure that you want to delete: ' . $IngredientName . '")) {';
            echo '    window.location.href = "' . URLROOT . '/IngredientController/confirmDeleteIngredient/' . $ingredientId . '";';
            echo '} else {';
            echo '    window.location.href = "' . URLROOT . '/IngredientController/overview/' . '";';
            echo '}';
            echo '</script>';
        } else {
            echo 'Ingredient information not found.';
        }
    }

    public function confirmDeleteIngredient($ingredientId)
    {
        if ($this->ingredientModel->delete($ingredientId)) {
            header('location: ' . URLROOT . '/IngredientController/overview/');
        } else {
            Helper::log('error', 'The delete was not succesfull at the delete ingredient');
            header('location: ' . URLROOT . '/IngredientController/overview/');
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

            $data = [
                'row' => $row
            ];
            $this->view('backend/ingredient/update', $data);
        }
    }
}
