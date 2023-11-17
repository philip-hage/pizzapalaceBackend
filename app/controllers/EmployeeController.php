<?php

class EmployeeController extends Controller
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

    public function overview()
    {
        $employees = $this->employeeModel->getEmployees();
        $countEmployees = count($this->employeeModel->getEmployees());

        $data = [
            'employees' => $employees,
            'countEmployees' => $countEmployees
        ];
        $this->view('backend/employee/overview', $data);
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $result = $this->employeeModel->create($post);

            if ($result) {
                header('Location: ' . URLROOT . 'EmployeeController/overview');
            } else {
                Helper::log('error', 'The create was not succesfull at the employee create');
                header('Location: ' . URLROOT . 'EmployeeController/overview');
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
                $toast = urlencode('true');
                $toasttitle = urlencode('Success');
                $toastmessage = urlencode('Your delete of the employee was successful');
                header('Location:' . URLROOT . 'EmployeeController/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
            } else {
                $toast = urlencode('false');
                $toasttitle = urlencode('Failed');
                $toastmessage = urlencode('Your delete of the employee has failed');
                header('Location:' . URLROOT . 'EmployeeController/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
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
                header('Refresh: 3; url=' . URLROOT . 'EmployeeController/overview/');
            } else {
                Helper::log('error', 'The update was not succcesfull at employee update');
                header('Refresh: 3; url=' . URLROOT . 'EmployeeController/overview/');
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
            $toast = urlencode('true');
            $toasttitle = urlencode('Success');
            $toastmessage = urlencode('Your create of the image was successful');
            header('Location:' . URLROOT . 'EmployeeController/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
        } else {
            Helper::log('error', $imageUploaderResult);
            $toast = urlencode('false');
            $toasttitle = urlencode('Failed');
            $toastmessage = urlencode('Your create of the image has failed');
            header('Location:' . URLROOT . 'EmployeeController/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
        }
    }

    public function deleteImage($screenId)
    {
        // Call the deleteScreen method from the model
        if (!$this->screenModel->deleteScreen($screenId)) {
            $toast = urlencode('true');
            $toasttitle = urlencode('Success');
            $toastmessage = urlencode('Image deleted successfully');
            header('Location:' . URLROOT . 'EmployeeController/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
        } else {
            $toast = urlencode('false');
            $toasttitle = urlencode('Failed');
            $toastmessage = urlencode('Image deleted Failed');
            header('Location:' . URLROOT . 'EmployeeController/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
        }
    }
}
