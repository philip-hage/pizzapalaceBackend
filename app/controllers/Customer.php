<?php

class Customer extends Controller
{
    private $customerModel;
    private $screenModel;

    public function __construct()
    {
        $this->customerModel = $this->model('CustomerModel');
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
        $customers = $this->customerModel->getCustomersByPagination($offset, $recordsPerPage);

        // Get total number of customers
        $countCustomers = $this->customerModel->getTotalCustomersCount();

        // Calculate total number of pages
        $totalPages = ceil($countCustomers / $recordsPerPage);

        // Ensure $pageNumber is within valid range
        $pageNumber = max(1, min($pageNumber, $totalPages));

        $data = [
            'customers' => $customers,
            'countCustomers' => $countCustomers,
            'currentPage' => $pageNumber,
            'recordsPerPage' => $recordsPerPage,
            'totalPages' => $totalPages,
        ];

        $this->view('backend/customer/overview', $data);
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $customerfirstname = ($post['customerfirstname']);
            $customerlastname = ($post['customerlastname']);
            $customerstreetname = ($post['customerstreetname']);
            $customercity = ($post['customercity']);
            $customerzipcode = ($post['customerzipcode']);
            $customerphone = ($post['customerphone']);
            $customeremail = ($post['customeremail']);

            if (
                empty($customerfirstname) || empty($customerlastname) ||
                empty($customerstreetname) || empty($customercity) ||
                empty($customerzipcode) || empty($customerphone) ||
                !filter_var($customeremail, FILTER_VALIDATE_EMAIL)
            ) {
                header('Location:' . URLROOT . 'Customer/overview/{toast:false;toasttitle:Failed;toastmessage:Your+create+of+the+customer+has+failed}');
            } else {
                // Form data is valid; proceed with creating the customer
                $this->customerModel->create($post);
                header('Location:' . URLROOT . 'Customer/overview/{toast:true;toasttitle:Success;toastmessage:Your+create+of+the+customer+was+successful}');
            }
        } else {
            $data = [
                'title' => 'Create customer'
            ];
            $this->view('backend/customer/create', $data);
        }
    }


    public function update($params = null)
    {
        $customerId = $params['customerId'];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $result = $this->customerModel->update($post);

            if (!$result) {
                header('Location:' . URLROOT . 'Customer/overview/{toast:true;toasttitle:Success;toastmessage:Your+update+of+the+customer+was+successful}');
            } else {
                header('Location:' . URLROOT . 'Customer/overview/{toast:false;toasttitle:Failed;toastmessage:Your+update+of+the+customer+has+failed}');
            }
        } else {
            $row = $this->customerModel->getSingleCustomer($customerId);
            // echo $customerId;
            $image = $this->screenModel->getScreenDataById($customerId, 'customer', 'main');
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
                'title' => '<h3>Update customer</h3>',
                'row' => $row,
                'imageSrc' => $imageSrc,
                'image' => $image
            ];
            $this->view('backend/customer/update', $data);
        }
    }
    public function updateImage($params = NULL)
    {
        $customerId = $params['customerId'];
        global $var;
        $screenId = $var['rand'];
        $imageUploaderResult = $this->imageUploader($screenId);

        if ($imageUploaderResult['status'] === 200 && strpos($imageUploaderResult['message'], 'Image uploaded successfully') !== false) {
            $entity = 'customer';
            $this->screenModel->insertScreenImages($screenId, $customerId, $entity, 'main');
            header('Location:' . URLROOT . 'Customer/update/{customerId:' . $customerId . ';' . 'toast:true;toasttitle:Success;toastmessage:Your+create+of+the+image+was+successful}');
        } else {
            Helper::log('error', $imageUploaderResult);
            header('Location:' . URLROOT . 'Customer/update/{customerId:' . $customerId . ';' . 'toast:false;toasttitle:Failed;toastmessage:Your+create+of+the+image+has+failed}');
        }
    }

    public function deleteImage($params)
    {
        $screenId = $params['screenId'];
        $customerId = $params['customerId'];
        // Call the deleteScreen method from the model
        if (!$this->screenModel->deleteScreen($screenId)) {
            header('Location:' . URLROOT . 'Customer/update/{customerId:' . $customerId . ';' . 'toast:true;toasttitle:Success;toastmessage:Image+deleted+of+successfully}');
        } else {
            header('Location:' . URLROOT . 'Customer/update/{customerId:' . $customerId . ';' . 'toast:false;toasttitle:Failed;toastmessage:Image+deleted+of+Failed}');
        }

        // Redirect to the overview page

    }

    public function delete($params)
    {
        $customerId = $params['customerId'];
        if ($_SERVER["REQUEST_METHOD"] == 'POST') {
            $result = $this->customerModel->deleteCustomer($customerId);


            if (!$result) {
                header('Location:' . URLROOT . 'Customer/overview/{toast:true;toasttitle:Success;toastmessage:Your+delete+of+the+customer+was+successful}');
            } else {
                header('Location:' . URLROOT . 'Customer/overview/{toast:false;toasttitle:Failed;toastmessage:Your+delete+of+the+customer+has+failed}');
            }
        } else {

            $data = [
                'title' => 'Delete customer',
                'customerId' => $customerId
            ];
            $this->view('backend/customer/delete', $data);
        }
    }
}
