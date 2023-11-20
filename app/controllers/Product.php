<?php

class Product extends Controller
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

    public function overview($pageNumber = NULL)
    {

        $totalRecords = count($this->productModel->getProducts());
        $pagination = $this->pagination($pageNumber, 3, $totalRecords);
        $products = $this->productModel->getProductsByPagination($pagination['offset'], $pagination['recordsPerPage']);

        $countProducts = $this->productModel->getTotalProductsCount();


        $data = [
            'products' => $products,
            'countProducts' => $countProducts,
            'pageNumber' => $pagination['pageNumber'],
            'nextPage' => $pagination['nextPage'],
            'previousPage' => $pagination['previousPage'],
            'totalPages' => $pagination['totalPages'],
            'firstPage' => $pagination['firstPage'],
            'secondPage' => $pagination['secondPage'],
            'thirdPage' => $pagination['thirdPage'],
            'offset' => $pagination['offset'],
            'recordsPerPage' => $pagination['recordsPerPage']
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
                header('Location:' . URLROOT . 'Product/overview/{toast:false;toasttitle:Failed;toastmessage:Your+create+of+the+product+has+failed}');
            } else {
                $this->productModel->create($post);
                header('Location:' . URLROOT . 'Product/overview/{toast:true;toasttitle:Success;toastmessage:Your+create+of+the+product+was+successful}');
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
                header('Location:' . URLROOT . 'Product/overview/{toast:true;toasttitle:Success;toastmessage:Your+delete+of+the+product+was+successful}');
            } else {
                header('Location:' . URLROOT . 'Product/overview/{toast:false;toasttitle:Failed;toastmessage:Your+delete+of+the+product+has+failed}');
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
                header('Location:' . URLROOT . 'Product/overview/{toast:true;toasttitle:Success;toastmessage:Your+update+of+the+product+was+successful}');
            } else {
                header('Location:' . URLROOT . 'Product/overview/{toast:false;toasttitle:Failed;toastmessage:Your+update+of+the+product+has+failed}');
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
            header('Location:' . URLROOT . 'Product/update/' . $productId . '/' . '{toast:true;toasttitle:Success;toastmessage:Your+create+of+the+image+was+successful}');
        } else {
            Helper::log('error', $imageUploaderResult);
            header('Location:' . URLROOT . 'Product/update/' . $productId . '/' . '{toast:false;toasttitle:Failed;toastmessage:Your+create+of+the+image+has+failed}');
        }
    }

    public function deleteImage($screenId)
    {
        // Call the deleteScreen method from the model
        if (!$this->screenModel->deleteScreen($screenId)) {
            header('Location:' . URLROOT . 'Product/overview/{toast:true;toasttitle:Success;toastmessage:Image+deleted+of+successfully}');
        } else {
            header('Location:' . URLROOT . 'Product/overview/{toast:false;toasttitle:Failed;toastmessage:Image+deleted+of+Failed}');
        }
    }
}
