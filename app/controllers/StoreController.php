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

            $this->storeModel->create($post);
            header("Location: " . URLROOT . "StoreController/overview");
        } else {
            $data = [
                'title' => 'Create Store'
            ];
            $this->view('backend/store/storeCreate', $data);
        }
    }

    public function delete($storeId)
    {
        echo '<script>';
        echo 'if (confirm("Are you sure that you want to delete: deze store")) {';
        echo '    window.location.href = "' . URLROOT . '/StoreController/confirmDeleteStore/' . $storeId . '";';
        echo '} else {';
        echo '    window.location.href = "' . URLROOT . '/StoreController/overview/' . $storeId . '";';
        echo '}';
        echo '</script>';
    }

    public function confirmDeleteStore($storeId)
    {
        if ($this->storeModel->delete($storeId)) {
            header('location: ' . URLROOT . '/StoreController/overview');
        } else {
            header('location: ' . URLROOT . '/StoreController/overview');
        }
    }

    public function update($storeId)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $result = $this->storeModel->update($post);

            if (!$result) {
                echo 'The update was successful';
                header('Refresh: 3; url=' . URLROOT . '/StoreController/overview/' . $storeId . '');
            } else {
                echo 'The update was not successful';
                header('Refresh: 3; url=' . URLROOT . '/StoreController/overview/' . $storeId . '');
            }
        } else {
            $row = $this->storeModel->getStoreById($storeId);

            $data = [
                'row' => $row
            ];
            $this->view('backend/store/storeEdit', $data);
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

            $this->storeModel->create($post, $storeId);
            header('Location: ' . URLROOT . 'StoreController/storeHasEmployees/' . $storeId);
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