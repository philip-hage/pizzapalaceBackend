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

    public function overview($pageNumber = NULL)
    {
        $totalRecords = count($this->vehicleModel->getVehicles());
        $pagination = $this->pagination($pageNumber, 3, $totalRecords);
        $vehicles = $this->vehicleModel->getVehiclesByPagination($pagination['offset'], $pagination['recordsPerPage']);

        $countVehicles = $this->vehicleModel->getTotalVehiclesCount();


        $data = [
            'vehicles' => $vehicles,
            'countVehicles' => $countVehicles,
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
        $this->view('backend/vehicles/overview', $data);
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $vehicleName = ($post['vehicleName']);

            if (empty($vehicleName)) {
                header('Location:' . URLROOT . 'Vehicle/overview/{toast:false;toasttitle:Failed;toastmessage:Your+create+of+the+Vehicle+has+failed}');
            } else {
                $this->vehicleModel->create($post);
                header('Location:' . URLROOT . 'Vehicle/overview/{toast:true;toasttitle:Success;toastmessage:Your+create+of+the+Vehicle+was+successful}');
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
                header('Location:' . URLROOT . 'Vehicle/overview/{toast:true;toasttitle:Success;toastmessage:Your+update+of+the+Vehicle+was+successful}');
            } else {
                header('Location:' . URLROOT . 'Vehicle/overview/{toast:false;toasttitle:Failed;toastmessage:Your+update+of+the+Vehicle+has+failed}');
            }
        } else {
            global $vehicleType;
            $row = $this->vehicleModel->getVehicleById($vehicleId);
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
                'row' => $row,
                'store' => $store,
                'vehicleType' => $vehicleType,
                'imageSrc' => $imageSrc,
                'image' => $image

            ];
            $this->view('backend/vehicles/update', $data);
        }
    }

    public function updateImage($vehicleId)
    {
        global $var;
        $screenId = $var['rand'];
        $imageUploaderResult = $this->imageUploader($screenId);

        if ($imageUploaderResult['status'] === 200 && strpos($imageUploaderResult['message'], 'Image uploaded successfully') !== false) {
            $entity = 'vehicle';
            $this->screenModel->insertScreenImages($screenId, $vehicleId, $entity, 'main');
            header('Location:' . URLROOT . 'Vehicle/update/' . $vehicleId . '/' . '{toast:true;toasttitle:Success;toastmessage:Your+create+of+the+image+was+successful}');
        } else {
            Helper::log('error', $imageUploaderResult);
            header('Location:' . URLROOT . 'Vehicle/update/' . $vehicleId . '/' . '{toast:false;toasttitle:Failed;toastmessage:Your+create+of+the+image+has+failed}');
        }
    }

    public function deleteImage($screenId)
    {
        // Call the deleteScreen method from the model
        if (!$this->screenModel->deleteScreen($screenId)) {
            header('Location:' . URLROOT . 'Vehicle/overview/{toast:true;toasttitle:Success;toastmessage:Image+deleted+of+successfully}');
        } else {
            header('Location:' . URLROOT . 'Vehicle/overview/{toast:false;toasttitle:Failed;toastmessage:Image+deleted+of+Failed}');
        }
    }

    public function delete($vehicleId)
    {
        if ($_SERVER["REQUEST_METHOD"] == 'POST') {
            $result = $this->vehicleModel->delete($vehicleId);

            if (!$result) {
                header('Location:' . URLROOT . 'Customer/overview/{toast:true;toasttitle:Success;toastmessage:Your+delete+of+the+customer+was+successful}');
            } else {
                header('Location:' . URLROOT . 'Customer/overview/{toast:false;toasttitle:Failed;toastmessage:Your+delete+of+the+customer+has+failed}');
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
