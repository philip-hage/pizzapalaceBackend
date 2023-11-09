<?php

class OrderController extends Controller
{
    private $orderModel;
    private $customerModel;
    private $storeModel;

    public function __construct()
    {
        $this->orderModel = $this->model('OrderModel');
        $this->customerModel = $this->model('CustomerModel');
        $this->storeModel = $this->model('StoreModel');
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
        $orders = $this->orderModel->getOrders();
        $countOrders = count($this->orderModel->getOrders());

        $data = [
            'orders' => $orders,
            'countOrders' => $countOrders
        ];
        $this->view('backend/order/overview', $data);
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $this->orderModel->create($post);
            header('Location: ' . URLROOT . 'OrderController/overview');
        } else {
            $customer = $this->customerModel->getCustomers();
            $store = $this->storeModel->getStores();
            global $orderState;
            global $orderStatus;
            $data = [
                'title' => 'Create Order',
                'customer' => $customer,
                'store' => $store,
                'orderState' => $orderState,
                'orderStatus' => $orderStatus
            ];
            $this->view('backend/order/create', $data);
        }
    }

    public function update($orderId)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $result = $this->orderModel->update($post);

            if (!$result) {
                echo 'The update was successful';
                header('Refresh: 1; url=' . URLROOT . '/OrderController/overview/' . $orderId . '');
            } else {
                echo 'The update was not successful';
                header('Refresh: 1; url=' . URLROOT . '/OrderController/overview/' . $orderId . '');
            }
        } else {
            global $orderState;
            global $orderStatus;
            $row = $this->orderModel->getOrderById($orderId);
            $customer = $this->customerModel->getCustomers();
            $store = $this->orderModel->getStores();

            $data = [
                'row' => $row,
                'customer' => $customer,
                'store' => $store,
                'orderState' => $orderState,
                'orderStatus' => $orderStatus,
            ];
            $this->view('backend/order/update', $data);
        }
    }

    public function orderHasProducts($orderId)
    {
        $products = $this->orderModel->getProductByOrder($orderId);
        $countProducts = count($this->orderModel->getProductByOrder($orderId));

        $data = [
            'products' => $products,
            'countProducts' => $countProducts
        ];
        $this->view('backend/order/orderhasproducts', $data);
    }
}
