<?php

class CustomerController extends Controller
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

    public function overview()
    {

        $customers = $this->customerModel->getCustomers();
        $countCustomers = $this->customerModel->getTotalCustomersCount();

        $data = [
            'customers' => $customers,
            'countCustomers' => $countCustomers
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
                $toast = urlencode('false');
                $toasttitle = urlencode('Failed');
                $toastmessage = urlencode('Your create of the customer has failed');
                header('Location:' . URLROOT . 'CustomerController/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
            } else {
                // Form data is valid; proceed with creating the customer
                $this->customerModel->create($post);
                $toast = urlencode('true');
                $toasttitle = urlencode('Success');
                $toastmessage = urlencode('Your create of the customer was successful');

                header('Location:' . URLROOT . 'CustomerController/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
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
                $toast = urlencode('true');
                $toasttitle = urlencode('Success');
                $toastmessage = urlencode('Your update of the customer was successful');
                header('Location:' . URLROOT . 'CustomerController/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
            } else {
                $toast = urlencode('false');
                $toasttitle = urlencode('Failed');
                $toastmessage = urlencode('Your update of the customer has failed');
                header('Location:' . URLROOT . 'CustomerController/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
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
            $toast = urlencode('true');
            $toasttitle = urlencode('Success');
            $toastmessage = urlencode('Your create of the image was successful');
            header('Location:' . URLROOT . 'CustomerController/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
        } else {
            Helper::log('error', $imageUploaderResult);
            $toast = urlencode('false');
            $toasttitle = urlencode('Failed');
            $toastmessage = urlencode('Your create of the image has failed');
            header('Location:' . URLROOT . 'CustomerController/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
        }
    }

    public function deleteImage($screenId)
    {
        // Call the deleteScreen method from the model
        if (!$this->screenModel->deleteScreen($screenId)) {
            $toast = urlencode('true');
            $toasttitle = urlencode('Success');
            $toastmessage = urlencode('Image deleted successfully');
            header('Location:' . URLROOT . 'CustomerController/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
        } else {
            $toast = urlencode('false');
            $toasttitle = urlencode('Failed');
            $toastmessage = urlencode('Image deleted Failed');
            header('Location:' . URLROOT . 'CustomerController/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
        }

        // Redirect to the overview page

    }

    public function delete($customerId)
    {
        if ($_SERVER["REQUEST_METHOD"] == 'POST') {
            $result = $this->customerModel->deleteCustomer($customerId);

            if (!$result) {
                $toast = urlencode('true');
                $toasttitle = urlencode('Success');
                $toastmessage = urlencode('Your delete of the customer was successful');
                header('Location:' . URLROOT . 'CustomerController/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
            } else {
                $toast = urlencode('false');
                $toasttitle = urlencode('Failed');
                $toastmessage = urlencode('Your delete of the customer has failed');
                header('Location:' . URLROOT . 'CustomerController/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
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
