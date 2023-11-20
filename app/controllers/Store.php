<?php


class Store extends Controller
{
    private $storeModel;
    private $vehicleModel;
    private $screenModel;

    public function __construct()
    {
        $this->storeModel = $this->model('StoreModel');
        $this->vehicleModel = $this->model('VehicleModel');
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
        $totalRecords = count($this->storeModel->getStores());
        $pagination = $this->pagination($pageNumber, 3, $totalRecords);
        $stores = $this->storeModel->getStoresByPagination($pagination['offset'], $pagination['recordsPerPage']);

        $countStores = $this->storeModel->getTotalStoresCount();

        $data = [
            'stores' => $stores,
            'countStores' => $countStores,
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
                header('Location:' . URLROOT . 'Store/overview/{toast:false;toasttitle:Failed;toastmessage:Your+create+of+the+Store+has+failed}');
            } else {
                // Form data is valid; proceed with creating the store
                $this->storeModel->create($post);
                header('Location:' . URLROOT . 'Store/overview/{toast:true;toasttitle:Success;toastmessage:Your+create+of+the+Store+was+successful}');
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
                header('Location:' . URLROOT . 'Store/overview/{toast:true;toasttitle:Success;toastmessage:Your+delete+of+the+Store+was+successful}');
            } else {
                header('Location:' . URLROOT . 'Store/overview/{toast:false;toasttitle:Failed;toastmessage:Your+delete+of+the+Store+has+failed}');
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
                header('Location:' . URLROOT . 'Store/overview/{toast:true;toasttitle:Success;toastmessage:Your+update+of+the+Store+was+successful}');
            } else {
                Helper::log('error', 'The update was not succcesfull at Store update');
                header('Location:' . URLROOT . 'Store/overview/{toast:false;toasttitle:Failed;toastmessage:Your+update+of+the+Store+has+failed}');
            }
        } else {
            $row = $this->storeModel->getStoreById($storeId);
            $image = $this->screenModel->getScreenDataById($storeId, 'store', 'main');
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
                'imageSrc' => $imageSrc,
                'image' => $image
            ];
            $this->view('backend/store/update', $data);
        }
    }

    public function updateImage($storeId)
    {
        global $var;
        $screenId = $var['rand'];
        $imageUploaderResult = $this->imageUploader($screenId);

        if ($imageUploaderResult['status'] === 200 && strpos($imageUploaderResult['message'], 'Image uploaded successfully') !== false) {
            $entity = 'store';
            $this->screenModel->insertScreenImages($screenId, $storeId, $entity, 'main');
            header('Location:' . URLROOT . 'Store/update/' . $storeId . '/' . '{toast:true;toasttitle:Success;toastmessage:Your+create+of+the+image+was+successful}');
        } else {
            Helper::log('error', $imageUploaderResult);
            header('Location:' . URLROOT . 'Store/update/' . $storeId . '/' . '{toast:false;toasttitle:Failed;toastmessage:Your+create+of+the+image+has+failed}');
        }
    }

    public function deleteImage($screenId)
    {
        // Call the deleteScreen method from the model
        if (!$this->screenModel->deleteScreen($screenId)) {
            header('Location:' . URLROOT . 'Store/overview/{toast:true;toasttitle:Success;toastmessage:Image+deleted+of+successfully}');
        } else {
            header('Location:' . URLROOT . 'Store/overview/{toast:false;toasttitle:Failed;toastmessage:Image+deleted+of+Failed}');
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
                header('Location: ' . URLROOT . 'Store/storeHasEmployees/' . $storeId);
            } else {
                Helper::log('error', 'The create was not succcesfull at store has employees create');
                header('Location: ' . URLROOT . 'Store/storeHasEmployees/' . $storeId);
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
