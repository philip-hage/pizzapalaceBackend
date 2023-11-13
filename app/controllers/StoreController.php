<?php


class StoreController extends Controller
{
    private $storeModel;
    private $vehicleModel;

    public function __construct()
    {
        $this->storeModel = $this->model('StoreModel');
        $this->vehicleModel = $this->model('VehicleModel');
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
        $stores = $this->storeModel->getStores();
        $countStores = count($this->storeModel->getStores());

        $data = [
            'stores' => $stores,
            'countStores' => $countStores
        ];
        $this->view('backend/store/overview', $data);
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $storeName = ($post['storeName']);
            $storeZipcode = ($post['storeZipcode']);
            $storeStreetName = ($post['storeStreetName']);
            $storeCity = ($post['storeCity']);
            $storePhone = ($post['storePhone']);
            $storeEmail = ($post['storeEmail']);

            if (
                empty($storeName) || empty($storeZipcode) ||
                empty($storeStreetName) || empty($storeCity) ||
                empty($storePhone) ||
                !filter_var($storeEmail, FILTER_VALIDATE_EMAIL)
            ) {
                $toast = urlencode('false');
                $toasttitle = urlencode('Failed');
                $toastmessage = urlencode('Your create of the store has failed');
                header('Location:' . URLROOT . 'StoreController/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
            } else {
                // Form data is valid; proceed with creating the store
                $this->storeModel->create($post);
                $toast = urlencode('true');
                $toasttitle = urlencode('Success');
                $toastmessage = urlencode('Your create of the store was successful');

                header('Location:' . URLROOT . 'StoreController/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
            }
        } else {
            $data = [
                'title' => 'Create Store'
            ];
            $this->view('backend/store/create', $data);
        }
    }

    public function delete($storeId)
    {
        if ($_SERVER["REQUEST_METHOD"] == 'POST') {
            $result = $this->storeModel->delete($storeId);

            if (!$result) {
                $toast = urlencode('true');
                $toasttitle = urlencode('Success');
                $toastmessage = urlencode('Your delete of the store was successful');
                header('Location:' . URLROOT . 'StoreController/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
            } else {
                $toast = urlencode('false');
                $toasttitle = urlencode('Failed');
                $toastmessage = urlencode('Your delete of the store has failed');
                header('Location:' . URLROOT . 'StoreController/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
            }
        } else {

            $data = [
                'title' => 'Delete store',
                'storeId' => $storeId
            ];
            $this->view('backend/store/delete', $data);
        }
    }

    public function update($storeId)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $result = $this->storeModel->update($post);

            if (!$result) {
                $toast = urlencode('true');
                $toasttitle = urlencode('Success');
                $toastmessage = urlencode('Your update of the store was successful');
                header('Location:' . URLROOT . 'StoreController/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
            } else {
                $toast = urlencode('false');
                $toasttitle = urlencode('Failed');
                $toastmessage = urlencode('Your update of the store has failed');
                header('Location:' . URLROOT . 'StoreController/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
            }
        } else {
            $row = $this->storeModel->getStoreById($storeId);

            $data = [
                'row' => $row
            ];
            $this->view('backend/store/update', $data);
        }
    }

    public function storeHasEmployees($storeId)
    {
        $store = $this->storeModel->getStoreById($storeId);
        $employees = $this->storeModel->getEmployeeByStore($storeId);
        $countEmployees = count($this->storeModel->getEmployeeByStore($storeId));

        $data = [
            'employees' => $employees,
            'store' => $store,
            'countEmployees' => $countEmployees
        ];
        $this->view('backend/store/storehasemployees', $data);
    }

    public function createStoreEmployee($storeId)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $result = $this->storeModel->create($post, $storeId);

            if ($result) {
                header('Location: ' . URLROOT . 'StoreController/storeHasEmployees/' . $storeId);
            } else {
                Helper::log('error', 'The create was not succcesfull at store has employees create');
                header('Location: ' . URLROOT . 'StoreController/storeHasEmployees/' . $storeId);
            }
        } else {
            $data = [
                'title' => 'Create Store',
                'id' => $storeId
            ];
            $this->view('backend/store/overview', $data);
        }
    }

    public function storeHasVehicles($storeId)
    {
        $store = $this->storeModel->getStoreById($storeId);
        $vehicles = $this->vehicleModel->getVehicleByStore($storeId);
        $countVehicles = count($this->vehicleModel->getVehicleByStore($storeId));

        $data = [
            'store' => $store,
            'vehicles' => $vehicles,
            'countVehicles' => $countVehicles
        ];
        $this->view('backend/store/storehasvehicles', $data);
    }
}
