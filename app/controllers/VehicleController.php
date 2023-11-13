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

            $vehicleName = ($post['vehicleName']);

            if (empty($vehicleName)) {
                $toast = urlencode('false');
                $toasttitle = urlencode('Failed');
                $toastmessage = urlencode('Your create of the vehicle has failed');
                header('Location:' . URLROOT . 'VehicleController/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
            } else {
                $this->vehicleModel->create($post);
                $toast = urlencode('true');
                $toasttitle = urlencode('Success');
                $toastmessage = urlencode('Your create of the vehicle was successful');
                header('Location:' . URLROOT . 'VehicleController/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
            }
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
                $toast = urlencode('true');
                $toasttitle = urlencode('Success');
                $toastmessage = urlencode('Your update of the vehicle was successful');
                header('Location:' . URLROOT . 'VehicleController/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
            } else {
                $toast = urlencode('false');
                $toasttitle = urlencode('Failed');
                $toastmessage = urlencode('Your update of the vehicle has failed');
                header('Location:' . URLROOT . 'VehicleController/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
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
        if ($_SERVER["REQUEST_METHOD"] == 'POST') {
            $result = $this->vehicleModel->delete($vehicleId);

            if (!$result) {
                $toast = urlencode('true');
                $toasttitle = urlencode('Success');
                $toastmessage = urlencode('Your delete of the vehicle was successful');
                header('Location:' . URLROOT . 'VehicleController/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
            } else {
                $toast = urlencode('false');
                $toasttitle = urlencode('Failed');
                $toastmessage = urlencode('Your delete of the vehicle has failed');
                header('Location:' . URLROOT . 'VehicleController/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
            }
        } else {

            $data = [
                'title' => 'Delete Vehicle',
                'vehicleId' => $vehicleId
            ];
            $this->view('backend/vehicles/delete', $data);
        }
    }
}
