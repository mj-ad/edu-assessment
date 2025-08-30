<?php

class StudentController extends Controller
{
    protected $studentModel;

    public function __construct()
    {
        $this->studentModel = $this->model('Student');
    }

    public function index()
    {
        // Get students
        $students = $this->studentModel->getStudents();

        $data = [
            'title' => 'Students',
            'students' => $students
        ];

        $this->view('students/index', $data);
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'first_name' => trim($_POST['first_name']),
                'last_name' => trim($_POST['last_name']),
                'email' => trim($_POST['email']),
                'phone' => trim($_POST['phone']),
                'fee_status' => trim($_POST['fee_status']),
                'first_name_err' => '',
                'last_name_err' => '',
                'email_err' => '',
                'phone_err' => '',
                'fee_status_err' => ''
            ];

            // Validate data
            if (empty($data['first_name'])) {
                $data['first_name_err'] = 'Please enter first name';
            }
            if (empty($data['last_name'])) {
                $data['last_name_err'] = 'Please enter last name';
            }
            if (empty($data['email'])) {
                $data['email_err'] = 'Please enter email';
            } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $data['email_err'] = 'Please enter a valid email';
            }
            if (empty($data['phone'])) {
                $data['phone_err'] = 'Please enter phone number';
            }
            if (empty($data['fee_status'])) {
                $data['fee_status_err'] = 'Please enter fee status';
            }

            // Make sure there are no errors
            if (empty($data['first_name_err']) && empty($data['last_name_err']) && empty($data['email_err']) && empty($data['phone_err']) && empty($data['fee_status_err'])) {
                // Validated
                if ($this->studentModel->addStudent($data)) {
                    $this->view('students/index');
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $this->view('students/add', $data);
            }
        } else {
            $data = [
                'first_name' => '',
                'last_name' => '',
                'email' => '',
                'phone' => '',
                'fee_status' => '',
                'first_name_err' => '',
                'last_name_err' => '',
                'email_err' => '',
                'phone_err' => '',
                'fee_status_err' => ''
            ];
            $this->view('students/add', $data);
        }
    }

    public function studentById($id)
    {
        $student = $this->studentModel->getStudentById($id);
        $this->view('student/student', ["student" => $student], $student['first_name'] . $student['last_name']);
    }

    public function deleteStudent($id)
    {
        $this->studentModel->deleteStudent($id);
    }

    public function updateStudent($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'id' => $id,
                'first_name' => trim($_POST['first_name']),
                'last_name' => trim($_POST['last_name']),
                'email' => trim($_POST['email']),
                'phone' => trim($_POST['phone']),
                'fee_status' => trim($_POST['fee_status']),
                'first_name_err' => '',
                'last_name_err' => '',
                'email_err' => '',
                'phone_err' => '',
                'fee_status_err' => ''
            ];

            // Validate data
            if (empty($data['first_name'])) {
                $data['first_name_err'] = 'Please enter first name';
            }
            if (empty($data['last_name'])) {
                $data['last_name_err'] = 'Please enter last name';
            }
            if (empty($data['email'])) {
                $data['email_err'] = 'Please enter email';
            } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $data['email_err'] = 'Please enter a valid email';
            }
            if (empty($data['phone'])) {
                $data['phone_err'] = 'Please enter phone number';
            }
            if (empty($data['fee_status'])) {
                $data['fee_status_err'] = 'Please enter fee status';
            }

            // Make sure there are no errors
            if (empty($data['first_name_err']) && empty($data['last_name_err']) && empty($data['email_err']) && empty($data['phone_err']) && empty($data['fee_status_err'])) {
                // Validated
                if ($this->studentModel->updateStudent($data)) {
                    $this->view('students/index');
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $this->view('students/edit', $data);
            }
        } else {
            $data = [
                'first_name' => '',
                'last_name' => '',
                'email' => '',
                'phone' => '',
                'fee_status' => '',
                'first_name_err' => '',
                'last_name_err' => '',
                'email_err' => '',
                'phone_err' => '',
                'fee_status_err' => ''
            ];
            $this->view('students/edit', $data);
        }
    }
}
