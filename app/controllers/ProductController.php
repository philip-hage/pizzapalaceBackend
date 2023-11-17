<?php

class ProductController extends Controller
{
    private $customerModel;
    private $productModel;
    private $screenModel;

    public function __construct()
    {
        $this->customerModel = $this->model('CustomerModel');
        $this->productModel = $this->model('ProductModel');
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

            $image = $this->screenModel->getScreenDataById($productId, 'product', 'main');
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
                'customer' => $customer,
                'productType' => $productType,
                'imageSrc' => $imageSrc,
                'image' => $image

            ];
            $this->view('backend/products/update', $data);
        }
    }

    public function updateImage($productId)
    {
        global $var;
        $screenId = $var['rand'];
        $imageUploaderResult = $this->imageUploader($screenId);

        if ($imageUploaderResult['status'] === 200 && strpos($imageUploaderResult['message'], 'Image uploaded successfully') !== false) {
            $entity = 'product';
            $this->screenModel->insertScreenImages($screenId, $productId, $entity, 'main');
            $toast = urlencode('true');
            $toasttitle = urlencode('Success');
            $toastmessage = urlencode('Your create of the image was successful');
            header('Location:' . URLROOT . 'ProductController/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
        } else {
            Helper::log('error', $imageUploaderResult);
            $toast = urlencode('false');
            $toasttitle = urlencode('Failed');
            $toastmessage = urlencode('Your create of the image has failed');
            header('Location:' . URLROOT . 'ProductController/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
        }
    }

    public function deleteImage($screenId)
    {
        // Call the deleteScreen method from the model
        if (!$this->screenModel->deleteScreen($screenId)) {
            $toast = urlencode('true');
            $toasttitle = urlencode('Success');
            $toastmessage = urlencode('Image deleted successfully');
            header('Location:' . URLROOT . 'ProductController/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
        } else {
            $toast = urlencode('false');
            $toasttitle = urlencode('Failed');
            $toastmessage = urlencode('Image deleted Failed');
            header('Location:' . URLROOT . 'ProductController/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
        }
    }
}
