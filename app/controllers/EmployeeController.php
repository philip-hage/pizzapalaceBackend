<?php

class EmployeeController extends Controller
{
    private $employeeModel;

    public function __construct()
    {
        $this->employeeModel = $this->model('EmployeeModel');
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

            $data = [
                'row' => $row
            ];
            $this->view('backend/employee/update', $data);
        }
    }
}
