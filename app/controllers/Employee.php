<?php

class Employee extends Controller
{
    private $employeeModel;
    private $screenModel;

    public function __construct()
    {
        $this->employeeModel = $this->model('EmployeeModel');
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
        $totalRecords = count($this->employeeModel->getEmployees());
        $pagination = $this->pagination($pageNumber, 3, $totalRecords);
        $employees = $this->employeeModel->getEmployeesByPagination($pagination['offset'], $pagination['recordsPerPage']);

        $countEmployees = $this->employeeModel->getTotalEmployeesCount();


        $data = [
            'employees' => $employees,
            'countEmployees' => $countEmployees,
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
        $this->view('backend/employee/overview', $data);
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $result = $this->employeeModel->create($post);

            if ($result) {
                header('Location:' . URLROOT . 'Employee/overview/{toast:true;toasttitle:Success;toastmessage:Your+create+of+the+employee+was+successful}');
            } else {
                Helper::log('error', 'The create was not succesfull at the employee create');
                header('Location:' . URLROOT . 'Employee/overview/{toast:false;toasttitle:Failed;toastmessage:Your+create+of+the+employee+has+failed}');
            }
        } else {
            $data = [
                'title' => 'Create Employee'
            ];
            $this->view('backend/employee/create', $data);
        }
    }

    public function delete($employeeId)
    {
        if ($_SERVER["REQUEST_METHOD"] == 'POST') {
            $result = $this->employeeModel->delete($employeeId);

            if (!$result) {
                header('Location:' . URLROOT . 'Employee/overview/{toast:true;toasttitle:Success;toastmessage:Your+delete+of+the+employee+was+successful}');
            } else {
                header('Location:' . URLROOT . 'Employee/overview/{toast:false;toasttitle:Failed;toastmessage:Your+delete+of+the+employee+has+failed}');
            }
        } else {

            $data = [
                'title' => 'Delete employee',
                'employeeId' => $employeeId
            ];
            $this->view('backend/employee/delete', $data);
        }
    }

    public function update($employeeId)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $result = $this->employeeModel->update($post);

            if (!$result) {
                header('Location:' . URLROOT . 'Employee/overview/{toast:true;toasttitle:Success;toastmessage:Your+update+of+the+employee+was+successful}');
            } else {
                Helper::log('error', 'The update was not succcesfull at employee update');
                header('Location:' . URLROOT . 'Employee/overview/{toast:false;toasttitle:Failed;toastmessage:Your+update+of+the+employee+has+failed}');
            }
        } else {
            $row = $this->employeeModel->getEmployeeById($employeeId);

            // Retrieve the image associated with the employee
            $image = $this->screenModel->getScreenDataById($employeeId, 'employee', 'main');

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

            $this->view('backend/employee/update', $data);
        }
    }

    public function updateImage($employeeId)
    {
        global $var;
        $screenId = $var['rand'];
        $imageUploaderResult = $this->imageUploader($screenId);

        if ($imageUploaderResult['status'] === 200 && strpos($imageUploaderResult['message'], 'Image uploaded successfully') !== false) {
            $entity = 'employee';
            $this->screenModel->insertScreenImages($screenId, $employeeId, $entity, 'main');
            header('Location:' . URLROOT . 'Employee/update/' . $employeeId . '/' . '{toast:true;toasttitle:Success;toastmessage:Your+create+of+the+image+was+successful}');
        } else {
            Helper::log('error', $imageUploaderResult);
            header('Location:' . URLROOT . 'Employee/update/' . $employeeId . '/' . '{toast:false;toasttitle:Failed;toastmessage:Your+create+of+the+image+has+failed}');
        }
    }

    public function deleteImage($ids)
    {
        $ids = explode('+', $ids);
        // Call the deleteScreen method from the model
        if (!$this->screenModel->deleteScreen($ids[0])) {
            header('Location:' . URLROOT . 'Employee/update/' . $ids[1] . '/' . '{toast:true;toasttitle:Success;toastmessage:Image+deleted+of+successfully}');
        } else {
            header('Location:' . URLROOT . 'Employee/update/' . $ids[1] . '/' . '{toast:false;toasttitle:Failed;toastmessage:Image+deleted+of+Failed}');
        }
    }
}
