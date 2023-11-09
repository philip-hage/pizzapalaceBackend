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

            $this->customerModel->create($post);
            header('Location: ' . URLROOT . 'CustomerController/overview/');
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
                echo 'The update was successful';
                header('Refresh: 3; url=' . URLROOT . '/CustomerController/overview/');
            } else {
                echo 'The update was not successful';
                header('Refresh: 3; url=' . URLROOT . '/CustomerController/overview/');
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

    public function deleteCustomer($customerId)
    {
        $customerInfo = $this->customerModel->getCustomerById($customerId);

        if ($customerInfo) {
            $customerFirstName = $customerInfo[0];
            $customerLastName = $customerInfo[1];

            echo '<script>';
            echo 'if (confirm("Are you sure that you want to delete: ' . $customerFirstName . ' ' . $customerLastName . '")) {';
            echo '    window.location.href = "' . URLROOT . '/CustomerController/confirmDeleteCustomer/' . $customerId . '";';
            echo '} else {';
            echo '    window.location.href = "' . URLROOT . '/CustomerController/overview/' . $customerId . '";';
            echo '}';
            echo '</script>';
        } else {
            echo 'Customer information not found.';
        }
    }

    public function confirmDeleteCustomer($customerId)
    {
        if ($this->customerModel->deleteCustomer($customerId)) {
            header('location: ' . URLROOT . '/CustomerController/overview');
        } else {
            header('location: ' . URLROOT . '/CustomerController/overview');
        }
    }

}


?>