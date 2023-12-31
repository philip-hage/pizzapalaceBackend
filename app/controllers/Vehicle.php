<?php

class Vehicle extends Controller
{
    private $vehicleModel;
    private $storeModel;
    private $screenModel;

    public function __construct()
    {
        $this->vehicleModel = $this->model('VehicleModel');
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
        $vehicles = $this->vehicleModel->getVehiclesByPagination($offset, $recordsPerPage);

        // Get total number of customers
        $countVehicles = $this->vehicleModel->getTotalVehiclesCount();

        // Calculate total number of pages
        $totalPages = ceil($countVehicles / $recordsPerPage);

        // Ensure $pageNumber is within valid range
        $pageNumber = max(1, min($pageNumber, $totalPages));

        $data = [
            'vehicles' => $vehicles,
            'countVehicles' => $countVehicles,
            'currentPage' => $pageNumber,
            'recordsPerPage' => $recordsPerPage,
            'totalPages' => $totalPages,
        ];
        $this->view('backend/vehicles/overview', $data);
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $vehicleName = ($post['vehicleName']);

            if (empty($vehicleName)) {
                header('Location:' . URLROOT . 'vehicle/overview/{toast:false;toasttitle:Failed;toastmessage:Your+create+of+the+Vehicle+has+failed}/');
            } else {
                $this->vehicleModel->create($post);
                header('Location:' . URLROOT . 'vehicle/overview/{toast:true;toasttitle:Success;toastmessage:Your+create+of+the+Vehicle+was+successful}/');
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


    public function update($params = NULL)
    {
        $vehicleId = $params['vehicleId'];
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $result = $this->vehicleModel->update($post);

            if (!$result) {
                header('Location:' . URLROOT . 'vehicle/overview/{toast:true;toasttitle:Success;toastmessage:Your+update+of+the+Vehicle+was+successful}/');
            } else {
                header('Location:' . URLROOT . 'vehicle/overview/{toast:false;toasttitle:Failed;toastmessage:Your+update+of+the+Vehicle+has+failed}/');
            }
        } else {
            global $vehicleType;
            $vehicles = $this->vehicleModel->getVehicleById($vehicleId);
            $store = $this->storeModel->getStores();

            $image = $this->screenModel->getScreenDataById($vehicleId, 'vehicle', 'main');
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
                'vehicles' => $vehicles,
                'store' => $store,
                'vehicleType' => $vehicleType,
                'imageSrc' => $imageSrc,
                'image' => $image

            ];
            $this->view('backend/vehicles/update', $data);
        }
    }

    public function updateImage($params)
    {
        $vehicleId = $params['vehicleId'];
        global $var;
        $screenId = $var['rand'];
        $imageUploaderResult = $this->imageUploader($screenId);

        if ($imageUploaderResult['status'] === 200 && strpos($imageUploaderResult['message'], 'Image uploaded successfully') !== false) {
            $entity = 'vehicle';
            $this->screenModel->insertScreenImages($screenId, $vehicleId, $entity, 'main');
            header('Location:' . URLROOT . 'vehicle/update/{vehicleId:' . $vehicleId . ';' . 'toast:true;toasttitle:Success;toastmessage:Your+create+of+the+image+was+successful}/');
        } else {
            Helper::log('error', $imageUploaderResult);
            header('Location:' . URLROOT . 'vehicle/update/{vehicleId:' . $vehicleId . ';' . 'toast:false;toasttitle:Failed;toastmessage:Your+create+of+the+image+has+failed}/');
        }
    }

    public function deleteImage($params)
    {
        $screenId = $params['screenId'];
        $vehicleId = $params['vehicleId'];
        // Call the deleteScreen method from the model
        if (!$this->screenModel->deleteScreen($screenId)) {
            header('Location:' . URLROOT . 'vehicle/update/{vehicleId:' . $vehicleId . ';' . 'toast:true;toasttitle:Success;toastmessage:Image+deleted+of+successfully}/');
        } else {
            header('Location:' . URLROOT . 'vehicle/update/{vehicleId:' . $vehicleId . ';' . 'toast:false;toasttitle:Failed;toastmessage:Image+deleted+of+Failed}/');
        }
    }

    public function delete($params = NULL)
    {
        $vehicleId = $params['vehicleId'];
        if ($_SERVER["REQUEST_METHOD"] == 'POST') {
            $result = $this->vehicleModel->delete($vehicleId);

            if (!$result) {
                header('Location:' . URLROOT . 'customer/overview/{toast:true;toasttitle:Success;toastmessage:Your+delete+of+the+customer+was+successful}/');
            } else {
                header('Location:' . URLROOT . 'customer/overview/{toast:false;toasttitle:Failed;toastmessage:Your+delete+of+the+customer+has+failed}/');
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
