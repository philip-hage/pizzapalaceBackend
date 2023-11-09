<?php

class ProductController extends Controller
{
    private $customerModel;
    private $productModel;

    public function __construct()
    {
        $this->customerModel = $this->model('CustomerModel');
        $this->productModel = $this->model('ProductModel');
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
        $products = $this->productModel->getProducts();
        $countProducts = count($this->productModel->getProducts());


        $data = [
            'products' => $products,
            'countProducts' => $countProducts
        ];
        $this->view('backend/products/overview', $data);
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $this->productModel->create($post);
            header('Location: ' . URLROOT . 'ProductController/overview');
        } else {
            $customer = $this->customerModel->getCustomers();
            global $productType;
            $data = [
                'title' => 'Create Vehicle',
                'customer' => $customer,
                'productType' => $productType
            ];
            $this->view('backend/products/create', $data);
        }
    }

    public function delete($productId)
    {
        $productInfo = $this->productModel->getSingleProduct($productId);

        if ($productInfo) {
            $productName = $productInfo[0];

            echo '<script>';
            echo 'if (confirm("Are you sure that you want to delete: ' . $productName . '")) {';
            echo '    window.location.href = "' . URLROOT . '/ProductController/confirmDeleteProduct/' . $productId . '";';
            echo '} else {';
            echo '    window.location.href = "' . URLROOT . '/ProductController/overview/' . $productId . '";';
            echo '}';
            echo '</script>';
        } else {
            echo 'Product information not found.';
        }
    }

    public function confirmDeleteProduct($productId)
    {
        if ($this->productModel->delete($productId)) {
            header('location: ' . URLROOT . '/ProductController/overview');
        } else {
            // Helper::log()
            header('location: ' . URLROOT . '/ProductController/overview');
        }
    }

    public function update($productId)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $result = $this->productModel->editProduct($post);

            if (!$result) {
                echo 'The update was successful';
                header('Refresh: 1; url=' . URLROOT . '/ProductController/overview/' . $productId . '');
            } else {
                // helper log
                echo 'The update was not successful';
                header('Refresh: 1; url=' . URLROOT . '/ProductController/overview/' . $productId . '');
            }
        } else {
            global $productType;
            $row = $this->productModel->getProductById($productId);
            $customer = $this->customerModel->getCustomers();

            $data = [
                'row' => $row,
                'customer' => $customer,
                'productType' => $productType,

            ];
            $this->view('backend/products/update', $data);
        }
    }
}
