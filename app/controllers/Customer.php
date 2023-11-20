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

    public function overview($pageNumber = NULL)
    {

        $totalRecords = count($this->customerModel->getCustomers());
        $pagination = $this->pagination($pageNumber, 3, $totalRecords);
        $customers = $this->customerModel->getCustomersByPagination($pagination['offset'], $pagination['recordsPerPage']);

        $countCustomers = $this->customerModel->getTotalCustomersCount();

        $data = [
            'customers' => $customers,
            'countCustomers' => $countCustomers,
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


    public function update($customerId = null)
    {
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
    public function updateImage($customerId)
    {
        global $var;
        $screenId = $var['rand'];
        $imageUploaderResult = $this->imageUploader($screenId);

        if ($imageUploaderResult['status'] === 200 && strpos($imageUploaderResult['message'], 'Image uploaded successfully') !== false) {
            $entity = 'customer';
            $this->screenModel->insertScreenImages($screenId, $customerId, $entity, 'main');
            header('Location:' . URLROOT . 'Customer/update/' . $customerId . '/' . '{toast:true;toasttitle:Success;toastmessage:Your+create+of+the+image+was+successful}');
        } else {
            Helper::log('error', $imageUploaderResult);
            header('Location:' . URLROOT . 'Customer/update/' . $customerId . '/' . '{toast:false;toasttitle:Failed;toastmessage:Your+create+of+the+image+has+failed}');
        }
    }

    public function deleteImage($ids)
    {
        $ids = explode('+', $ids);
        // Call the deleteScreen method from the model
        if (!$this->screenModel->deleteScreen($ids[0])) {
            header('Location:' . URLROOT . 'Customer/update/' . $ids[1] . '/' . '{toast:true;toasttitle:Success;toastmessage:Image+deleted+of+successfully}');
        } else {
            header('Location:' . URLROOT . 'Customer/update/' . $ids[1] . '/' . '{toast:false;toasttitle:Failed;toastmessage:Image+deleted+of+Failed}');
        }

        // Redirect to the overview page

    }

    public function delete($customerId)
    {
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
