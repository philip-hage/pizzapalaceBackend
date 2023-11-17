<?php

class OrderController extends Controller
{
    private $orderModel;
    private $customerModel;
    private $storeModel;
    private $screenModel;

    public function __construct()
    {
        $this->orderModel = $this->model('OrderModel');
        $this->customerModel = $this->model('CustomerModel');
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

            $orderPrice = ($post['orderPrice']);

            if (empty($orderPrice)) {
                $toast = urlencode('false');
                $toasttitle = urlencode('Failed');
                $toastmessage = urlencode('Your create of the order has failed');
                header('Location:' . URLROOT . 'OrderController/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
            } else {
                $this->orderModel->create($post);
                $toast = urlencode('true');
                $toasttitle = urlencode('Success');
                $toastmessage = urlencode('Your create of the order was successful');

                header('Location:' . URLROOT . 'OrderController/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
            }

            $this->orderModel->create($post);
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
                $toast = urlencode('true');
                $toasttitle = urlencode('Success');
                $toastmessage = urlencode('Your update of the order was successful');
                header('Location:' . URLROOT . 'OrderController/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
            } else {
                $toast = urlencode('false');
                $toasttitle = urlencode('Failed');
                $toastmessage = urlencode('Your update of the order has failed');
                header('Location:' . URLROOT . 'OrderController/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
            }
        } else {
            global $orderState;
            global $orderStatus;
            $row = $this->orderModel->getOrderById($orderId);
            $customer = $this->customerModel->getCustomers();
            $store = $this->storeModel->getStores();


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
