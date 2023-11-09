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

            $this->employeeModel->create($post);
            header('Location: ' . URLROOT . 'EmployeeController/overview');
        } else {
            $data = [
                'title' => 'Create Employee'
            ];
            $this->view('backend/employee/create', $data);
        }
    }

    public function delete($employeeId)
    {
        $employeeInfo = $this->employeeModel->getSingleEmployee($employeeId);

        if ($employeeInfo) {
            $employeeFirstName = $employeeInfo[0];
            $employeeLastName = $employeeInfo[1];

        echo '<script>';
        echo 'if (confirm("Are you sure that you want to delete: ' . $employeeFirstName . ' ' . $employeeLastName . '")) {';
        echo '    window.location.href = "' . URLROOT . '/EmployeeController/confirmDeleteEmployee/' . $employeeId . '";';
        echo '} else {';
        echo '    window.location.href = "' . URLROOT . '/EmployeeController/overview/' . $employeeId . '";';
        echo '}';
        echo '</script>';
        } else {
            echo 'Employee information not found.';
        }
    }

    public function confirmDeleteEmployee($employeeId)
    {
        if ($this->employeeModel->delete($employeeId)) {
            header('location: ' . URLROOT . '/EmployeeController/overview');
        } else {
            header('location: ' . URLROOT . '/EmployeeController/overview');
        }
    }

    public function update($employeeId)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $result = $this->employeeModel->update($post);

            if (!$result) {
                echo 'The update was successful';
                header('Refresh: 3; url=' . URLROOT . '/EmployeeController/overview/' . $employeeId . '');
            } else {
                echo 'The update was not successful';
                header('Refresh: 3; url=' . URLROOT . '/EmployeeController/overview/' . $employeeId . '');
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
