<?php


class ReviewController extends Controller
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

    public function overview()
    {
        $reviews = $this->reviewModel->getReviews();
        $countReviews = count($this->reviewModel->getReviews());

        $data = [
            'reviews' => $reviews,
            'countReviews' => $countReviews
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
                $toast = urlencode('false');
                $toasttitle = urlencode('Failed');
                $toastmessage = urlencode('Your create of the review has failed');
                header('Location:' . URLROOT . 'ReviewController/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
            } else {
                $this->reviewModel->create($post);
                $toast = urlencode('true');
                $toasttitle = urlencode('Success');
                $toastmessage = urlencode('Your create of the review was successful');

                header('Location:' . URLROOT . 'ReviewController/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
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

    public function delete($reviewId)
    {
        if ($_SERVER["REQUEST_METHOD"] == 'POST') {
            $result = $this->reviewModel->delete($reviewId);

            if (!$result) {
                $toast = urlencode('true');
                $toasttitle = urlencode('Success');
                $toastmessage = urlencode('Your delete of the review was successful');
                header('Location:' . URLROOT . 'ReviewController/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
            } else {
                $toast = urlencode('false');
                $toasttitle = urlencode('Failed');
                $toastmessage = urlencode('Your delete of the review has failed');
                header('Location:' . URLROOT . 'ReviewController/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
            }
        } else {

            $data = [
                'title' => 'Delete Review',
                'reviewId' => $reviewId
            ];
            $this->view('backend/reviews/delete', $data);
        }
    }

    public function update($reviewId)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $result = $this->reviewModel->update($post);

            if (!$result) {
                $toast = urlencode('true');
                $toasttitle = urlencode('Success');
                $toastmessage = urlencode('Your update of the review was successful');
                header('Location:' . URLROOT . 'ReviewController/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
            } else {
                $toast = urlencode('false');
                $toasttitle = urlencode('Failed');
                $toastmessage = urlencode('Your update of the review has failed');
                header('Location:' . URLROOT . 'ReviewController/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
            }
        } else {
            $row = $this->reviewModel->getReviewById($reviewId);
            $customer = $this->customerModel->getCustomers();

            $image = $this->screenModel->getScreenDataById($reviewId, 'review', 'main');
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
                'imageSrc' => $imageSrc,
                'image' => $image

            ];
            $this->view('backend/reviews/update', $data);
        }
    }

    public function updateImage($reviewId)
    {
        global $var;
        $screenId = $var['rand'];
        $imageUploaderResult = $this->imageUploader($screenId);

        if ($imageUploaderResult['status'] === 200 && strpos($imageUploaderResult['message'], 'Image uploaded successfully') !== false) {
            $entity = 'review';
            $this->screenModel->insertScreenImages($screenId, $reviewId, $entity, 'main');
            $toast = urlencode('true');
            $toasttitle = urlencode('Success');
            $toastmessage = urlencode('Your create of the image was successful');
            header('Location:' . URLROOT . 'ReviewController/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
        } else {
            Helper::log('error', $imageUploaderResult);
            $toast = urlencode('false');
            $toasttitle = urlencode('Failed');
            $toastmessage = urlencode('Your create of the image has failed');
            header('Location:' . URLROOT . 'ReviewController/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
        }
    }

    public function deleteImage($screenId)
    {
        // Call the deleteScreen method from the model
        if (!$this->screenModel->deleteScreen($screenId)) {
            $toast = urlencode('true');
            $toasttitle = urlencode('Success');
            $toastmessage = urlencode('Image deleted successfully');
            header('Location:' . URLROOT . 'ReviewController/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
        } else {
            $toast = urlencode('false');
            $toasttitle = urlencode('Failed');
            $toastmessage = urlencode('Image deleted Failed');
            header('Location:' . URLROOT . 'ReviewController/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
        }
    }
}
