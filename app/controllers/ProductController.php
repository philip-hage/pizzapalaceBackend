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

            $productName = ($post['productName']);
            $productPrice = ($post['productPrice']);

            if (empty($productName) || empty($productPrice)) {
                $toast = urlencode('false');
                $toasttitle = urlencode('Failed');
                $toastmessage = urlencode('Your create of the product has failed');
                header('Location:' . URLROOT . 'ProductController/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
            } else {
                $this->productModel->create($post);
                $toast = urlencode('true');
                $toasttitle = urlencode('Success');
                $toastmessage = urlencode('Your create of the product was successful');

                header('Location:' . URLROOT . 'ProductController/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
            }
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
        if ($_SERVER["REQUEST_METHOD"] == 'POST') {
            $result = $this->productModel->delete($productId);

            if (!$result) {
                $toast = urlencode('true');
                $toasttitle = urlencode('Success');
                $toastmessage = urlencode('Your delete of the product was successful');
                header('Location:' . URLROOT . 'ProductController/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
            } else {
                $toast = urlencode('false');
                $toasttitle = urlencode('Failed');
                $toastmessage = urlencode('Your delete of the product has failed');
                header('Location:' . URLROOT . 'ProductController/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
            }
        } else {
            $data = [
                'title' => 'Delete Product',
                'productId' => $productId
            ];
            $this->view('backend/products/delete', $data);
        }
    }

    public function update($productId)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $result = $this->productModel->editProduct($post);

            if (!$result) {
                $toast = urlencode('true');
                $toasttitle = urlencode('Success');
                $toastmessage = urlencode('Your update of the product was successful');
                header('Location:' . URLROOT . 'ProductController/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
            } else {
                $toast = urlencode('false');
                $toasttitle = urlencode('Failed');
                $toastmessage = urlencode('Your update of the product has failed');
                header('Location:' . URLROOT . 'ProductController/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
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
