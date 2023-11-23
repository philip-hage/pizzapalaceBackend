<?php


class Review extends Controller
{
    private $reviewModel;
    private $customerModel;
    private $orderModel;
    private $productModel;
    private $storeModel;
    private $screenModel;

    public function __construct()
    {
        $this->reviewModel = $this->model('ReviewModel');
        $this->customerModel = $this->model('CustomerModel');
        $this->orderModel = $this->model('OrderModel');
        $this->productModel = $this->model('ProductModel');
        $this->storeModel = $this->model('StoreModel');
        $this->screenModel = $this->model('ScreenModel');
    }

    public function index()
    {
        $data = [
            'title' => 'Pizza Palace'
        ];
        $this->view('backend/index', $data);
    }

    public function overview($params)
    {

        // Extract page number from $params
        $pageNumber = isset($params['page']) ? intval($params['page']) : 1;

        // Define records per page and calculate offset
        $recordsPerPage = 2; // You can adjust this based on your needs
        $offset = ($pageNumber - 1) * $recordsPerPage;

        // Get customers for the current page
        $reviews = $this->reviewModel->getReviewsByPagination($offset, $recordsPerPage);

        // Get total number of customers
        $countReviews = $this->reviewModel->getTotalReviewsCount();

        // Calculate total number of pages
        $totalPages = ceil($countReviews / $recordsPerPage);

        // Ensure $pageNumber is within valid range
        $pageNumber = max(1, min($pageNumber, $totalPages));

        $data = [
            'reviews' => $reviews,
            'countReviews' => $countReviews,
            'currentPage' => $pageNumber,
            'recordsPerPage' => $recordsPerPage,
            'totalPages' => $totalPages,
        ];
        $this->view('backend/reviews/overview', $data);
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $reviewRating = ($post['reviewRating']);
            $reviewDescription = ($post['reviewDescription']);

            if (empty($reviewRating) || empty($reviewDescription)) {
                header('Location:' . URLROOT . 'Review/overview/{toast:false;toasttitle:Failed;toastmessage:Your+create+of+the+review+has+failed}/');
            } else {
                $this->reviewModel->create($post);
                header('Location:' . URLROOT . 'Review/overview/{toast:true;toasttitle:Success;toastmessage:Your+create+of+the+review+was+successful}/');
            }
        } else {
            $customer = $this->customerModel->getCustomers();
            $orders = $this->orderModel->getOrders();
            $prodcuts = $this->productModel->getProducts();
            $stores = $this->storeModel->getStores();
            $data = [
                'title' => 'Create Review',
                'customer' => $customer,
                'orders' => $orders,
                'products' => $prodcuts,
                'store' => $stores
            ];
            $this->view('backend/reviews/create', $data);
        }
    }

    public function delete($params = NULL)
    {
        $reviewId = $params['reviewId'];
        if ($_SERVER["REQUEST_METHOD"] == 'POST') {
            $result = $this->reviewModel->delete($reviewId);

            if (!$result) {
                header('Location:' . URLROOT . 'Review/overview/{toast:true;toasttitle:Success;toastmessage:Your+delete+of+the+review+was+successful}/');
            } else {
                header('Location:' . URLROOT . 'Review/overview/{toast:false;toasttitle:Failed;toastmessage:Your+delete+of+the+review+has+failed}/');
            }
        } else {

            $data = [
                'title' => 'Delete Review',
                'reviewId' => $reviewId
            ];
            $this->view('backend/reviews/delete', $data);
        }
    }

    public function update($params = NULL)
    {
        $reviewId = $params['reviewId'];
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $result = $this->reviewModel->update($post);

            if (!$result) {
                header('Location:' . URLROOT . 'Review/overview/{toast:true;toasttitle:Success;toastmessage:Your+update+of+the+Review+was+successful}/');
            } else {
                header('Location:' . URLROOT . 'Review/overview/{toast:false;toasttitle:Failed;toastmessage:Your+update+of+the+Review+has+failed}/');
            }
        } else {
            $row = $this->reviewModel->getReviewById($reviewId);
            $customer = $this->customerModel->getCustomers();
            $orders = $this->orderModel->getOrders();
            $prodcuts = $this->productModel->getProducts();
            $stores = $this->storeModel->getStores();

            $images = $this->screenModel->getScreensDataById($reviewId, 'review');
            if ($images !== false) {
                // Check if the necessary properties exist before accessing them
                foreach ($images as $image) :
                    if (property_exists($image, 'screenCreateDate') && property_exists($image, 'screenId')) {
                        $createDate = date('Ymd', $image->screenCreateDate);
                        $image->imagePath = URLROOT . 'public/media/' . $createDate . '/' . $image->screenId . '.jpg';
                    } else {
                        // Handle the case where expected properties are missing
                        $image->imagePath = URLROOT . 'public/default-image.jpg';
                    }
                endforeach;
            }

            $data = [
                'row' => $row,
                'customer' => $customer,
                'images' => $images,
                'orders' => $orders,
                'products' => $prodcuts,
                'stores' => $stores

            ];
            $this->view('backend/reviews/update', $data);
        }
    }

    public function updateImage($params = NULL)
    {
        $reviewId = $params['reviewId'];
        global $var;
        $screenId = $var['rand'];
        $imageUploaderResult = $this->imageUploader($screenId);
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if ($imageUploaderResult['status'] === 200 && strpos($imageUploaderResult['message'], 'Image uploaded successfully') !== false) {
            $entity = 'review';
            $this->screenModel->insertScreensImages($screenId, $reviewId, $entity, $post);
            header('Location:' . URLROOT . 'Review/update/{reviewId:' . $reviewId . ';' . 'toast:true;toasttitle:Success;toastmessage:Your+create+of+the+image+was+successful}/');
        } else {
            Helper::log('error', $imageUploaderResult);
            header('Location:' . URLROOT . 'Review/update/{reviewId:' . $reviewId . ';' . 'toast:false;toasttitle:Failed;toastmessage:Your+create+of+the+image+has+failed}/');
        }
    }

    public function deleteImage($params = NULL)
    {
        $screenId = $params['screenId'];
        $reviewId = $params['reviewId'];
        // Call the deleteScreen method from the model
        if (!$this->screenModel->deleteScreen($screenId)) {
            header('Location:' . URLROOT . 'Review/update/{reviewId:' . $reviewId . ';' . 'toast:true;toasttitle:Success;toastmessage:Image+deleted+of+successfully}/');
        } else {
            header('Location:' . URLROOT . 'Review/update/{reviewId:' . $reviewId . ';' . 'toast:false;toasttitle:Failed;toastmessage:Image+deleted+of+Failed}/');
        }
    }
}
