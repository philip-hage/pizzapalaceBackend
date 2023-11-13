<?php

class CustomerController extends Controller
{
    private $customerModel;

    public function __construct()
    {
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
        // $url = urldecode($url);
        // if (preg_match('/{([^:]+):([^}]+)}/', $url, $matches)) {
        //     $toast = $matches[1]; // "toast"
        //     $isFalse = $matches[2]; // "false"

        //     // You can check if $isFalse is equal to the string "false" or not.
        //     if ($isFalse === "false") {
        //         // $isFalse is the string "false"

        //     } else {

        //         Helper::dump($url);exit;
        //     }
        // }
        $customers = $this->customerModel->getCustomers();
        $countCustomers = count($this->customerModel->getCustomers());


        $data = [
            'customers' => $customers,
            'countCustomers' => $countCustomers,
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
            $data = [
                'title' => '<h3>Update customer</h3>',
                'row' => $row
            ];
            $this->view('backend/customer/update', $data);
        }
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
