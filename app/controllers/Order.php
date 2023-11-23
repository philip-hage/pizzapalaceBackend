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

    public function overview($params)
    {
        // Extract page number from $params
        $pageNumber = isset($params['page']) ? intval($params['page']) : 1;

        // Define records per page and calculate offset
        $recordsPerPage = 2; // You can adjust this based on your needs
        $offset = ($pageNumber - 1) * $recordsPerPage;

        // Get customers for the current page
        $orders = $this->orderModel->getOrdersByPagination($offset, $recordsPerPage);

        // Get total number of customers
        $countOrders = $this->orderModel->getTotalOrdersCount();

        // Calculate total number of pages
        $totalPages = ceil($countOrders / $recordsPerPage);

        // Ensure $pageNumber is within valid range
        $pageNumber = max(1, min($pageNumber, $totalPages));


        $data = [
            'orders' => $orders,
            'countOrders' => $countOrders,
            'currentPage' => $pageNumber,
            'recordsPerPage' => $recordsPerPage,
            'totalPages' => $totalPages,
        ];
        $this->view('backend/order/overview', $data);
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $orderPrice = ($post['orderPrice']);

            if (empty($orderPrice)) {
                header('Location:' . URLROOT . 'Order/overview/{toast:false;toasttitle:Failed;toastmessage:Your+create+of+the+order+has+failed}/');
            } else {
                $this->orderModel->create($post);
                header('Location:' . URLROOT . 'Order/overview/{toast:true;toasttitle:Success;toastmessage:Your+create+of+the+order+was+successful}/');
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

    public function update($params)
    {
        $orderId = $params['orderId'];
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $result = $this->orderModel->update($post);

            if (!$result) {
                header('Location:' . URLROOT . 'Order/overview/{toast:true;toasttitle:Success;toastmessage:Your+update+of+the+order+was+successful}/');
            } else {
                header('Location:' . URLROOT . 'Order/overview/{toast:false;toasttitle:Failed;toastmessage:Your+update+of+the+order+has+failed}/');
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

    public function orderHasProducts($params = NULL)
    {
        $orderId = $params['orderId'];
        $products = $this->orderModel->getProductByOrder($orderId);
        $countProducts = count($this->orderModel->getProductByOrder($orderId));

        $data = [
            'products' => $products,
            'countProducts' => $countProducts
        ];
        $this->view('backend/order/orderhasproducts', $data);
    }
}
