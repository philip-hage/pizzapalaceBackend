<?php

class VehicleController extends Controller
{
    private $vehicleModel;
    private $storeModel;

    public function __construct()
    {
        $this->vehicleModel = $this->model('VehicleModel');
        $this->storeModel = $this->model('StoreModel');
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
        $vehicles = $this->vehicleModel->getVehicles();
        $countVehicles = count($this->vehicleModel->getVehicles());


        $data = [
            'vehicles' => $vehicles,
            'countVehicles' => $countVehicles
        ];
        $this->view('backend/vehicles/overview', $data);
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $this->vehicleModel->create($post);
            header('Location: ' . URLROOT . 'VehicleController/overview');
        } else {
            $store = $this->storeModel->getStores();
            global $vehicleType;
            $data = [
                'title' => 'Create Vehicle',
                'store' => $store,
                'vehicleType' => $vehicleType
            ];
            $this->view('backend/vehicles/create', $data);
        }
    }
    

    public function update($vehicleId)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $result = $this->vehicleModel->update($post);

            if (!$result) {
                echo 'The update was successful';
                header('Refresh: 1; url=' . URLROOT . '/VehicleController/overview/' . $vehicleId . '');
            } else {
                echo 'The update was not successful';
                header('Refresh: 1; url=' . URLROOT . '/VehicleController/overview/' . $vehicleId . '');
            }
        } else {
            global $vehicleType;
            $row = $this->vehicleModel->getVehicleById($vehicleId);
            $store = $this->storeModel->getStores();

            $data = [
                'row' => $row,
                'store' => $store,
                'vehicleType' => $vehicleType,
                
            ];
            $this->view('backend/vehicles/update', $data);
        }
    }

    public function delete($vehicleId)
    {
        echo '<script>';
        echo 'if (confirm("Are you sure that you want to delete: dit voertuig")) {';
        echo '    window.location.href = "' . URLROOT . '/VehicleController/confirmDeleteVehicle/' . $vehicleId . '";';
        echo '} else {';
        echo '    window.location.href = "' . URLROOT . '/VehicleController/overview/' . $vehicleId . '";';
        echo '}';
        echo '</script>';
    }

    public function confirmDeleteVehicle($vehicleId)
    {
        if ($this->vehicleModel->delete($vehicleId)) {
            header('location: ' . URLROOT . '/VehicleController/overview');
        } else {
            header('location: ' . URLROOT . '/VehicleController/overview');
        }
    }
}