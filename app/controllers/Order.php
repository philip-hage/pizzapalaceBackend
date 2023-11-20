<?php

class Order extends Controller
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

    public function overview($pageNumber = NULL)
    {

        $totalRecords = count($this->orderModel->getOrders());
        $pagination = $this->pagination($pageNumber, 3, $totalRecords);
        $orders = $this->orderModel->getOrdersByPagination($pagination['offset'], $pagination['recordsPerPage']);

        $countOrders = $this->orderModel->getTotalOrdersCount();


        $data = [
            'orders' => $orders,
            'countOrders' => $countOrders,
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
        $this->view('backend/order/overview', $data);
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $orderPrice = ($post['orderPrice']);

            if (empty($orderPrice)) {
                header('Location:' . URLROOT . 'Order/overview/{toast:false;toasttitle:Failed;toastmessage:Your+create+of+the+order+has+failed}');
            } else {
                $this->orderModel->create($post);
                header('Location:' . URLROOT . 'Order/overview/{toast:true;toasttitle:Success;toastmessage:Your+create+of+the+order+was+successful}');
            }
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
                header('Location:' . URLROOT . 'Order/overview/{toast:true;toasttitle:Success;toastmessage:Your+update+of+the+order+was+successful}');
            } else {
                header('Location:' . URLROOT . 'Order/overview/{toast:false;toasttitle:Failed;toastmessage:Your+update+of+the+order+has+failed}');
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
