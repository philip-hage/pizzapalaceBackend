<?php

class VehicleController extends Controller
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
            $toast = urlencode('true');
            $toasttitle = urlencode('Success');
            $toastmessage = urlencode('Your create of the image was successful');
            header('Location:' . URLROOT . 'VehicleController/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
        } else {
            Helper::log('error', $imageUploaderResult);
            $toast = urlencode('false');
            $toasttitle = urlencode('Failed');
            $toastmessage = urlencode('Your create of the image has failed');
            header('Location:' . URLROOT . 'VehicleController/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
        }
    }

    public function deleteImage($screenId)
    {
        // Call the deleteScreen method from the model
        if (!$this->screenModel->deleteScreen($screenId)) {
            $toast = urlencode('true');
            $toasttitle = urlencode('Success');
            $toastmessage = urlencode('Image deleted successfully');
            header('Location:' . URLROOT . 'VehicleController/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
        } else {
            $toast = urlencode('false');
            $toasttitle = urlencode('Failed');
            $toastmessage = urlencode('Image deleted Failed');
            header('Location:' . URLROOT . 'VehicleController/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
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
