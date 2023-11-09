<?php


class ReviewController extends Controller
{
    private $reviewModel;
    private $customerModel;

    public function __construct()
    {
        $this->reviewModel = $this->model('ReviewModel');
        $this->customerModel = $this->model('CustomerModel');
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

            $this->reviewModel->create($post);
            header('Location: ' . URLROOT . 'ReviewController/overview');
        } else {
            $customer = $this->customerModel->getCustomers();
            $data = [
                'title' => 'Create Review',
                'customer' => $customer
            ];
            $this->view('backend/reviews/create', $data);
        }
    }

    public function delete($reviewId)
    {
        echo '<script>';
        echo 'if (confirm("Are you sure that you want to delete: deze Review")) {';
        echo '    window.location.href = "' . URLROOT . '/ReviewController/confirmDeleteReview/' . $reviewId . '";';
        echo '} else {';
        echo '    window.location.href = "' . URLROOT . '/ReviewController/overview/' . $reviewId . '";';
        echo '}';
        echo '</script>';
    }

    public function confirmDeleteReview($reviewId)
    {
        if ($this->reviewModel->delete($reviewId)) {
            header('location: ' . URLROOT . '/ReviewController/overview');
        } else {
            header('location: ' . URLROOT . '/ReviewController/overview');
        }
    }

    public function update($reviewId)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $result = $this->reviewModel->update($post);

            if (!$result) {
                echo 'The update was successful';
                header('Refresh: 1; url=' . URLROOT . '/ReviewController/overview/' . $reviewId . '');
            } else {
                echo 'The update was not successful';
                header('Refresh: 1; url=' . URLROOT . '/ReviewController/overview/' . $reviewId . '');
            }
        } else {
            $row = $this->reviewModel->getReviewById($reviewId);
            $customer = $this->customerModel->getCustomers();

            $data = [
                'row' => $row,
                'customer' => $customer
                
            ];
            $this->view('backend/reviews/update', $data);
        }
    }
}