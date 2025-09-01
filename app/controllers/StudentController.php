<?php
require_once __DIR__ . '/../src/helpers.php';
require_once __DIR__ . '/../models/Student.php';
require_once __DIR__ . '/../src/Mailer.php';

class StudentController
{
    // List all students (JSON)
    public function index(): void
    {
        json_response(Student::all());
    }

    // Render students list view (HTML)
    public function indexView(): void
    {
        $students = Student::all();
        include __DIR__ . '/../views/Students/Students.php';
    }

    // Show a specific student (JSON)
    public function show(int $id): void
    {
        $student = Student::find($id);
        if (!$student) {
            json_response(['error' => 'Student not found'], 404);
        }
        json_response($student);
    }

    // Render student details view (HTML)
    public function showView(int $id): void
    {
        $student = Student::find($id);
        if (!$student) {
            http_response_code(404);
            echo "Student not found";
            return;
        }
        require __DIR__ . '/../views/Students/Student.php';
    }

    // Create a new student (JSON)
    public function store(): void
    {
        $data = $_POST ?: get_input_json();
        foreach (['reg_no', 'first_name', 'last_name', 'email', 'class_id'] as $req) {
            if (empty($data[$req])) {
                json_response(['error' => "$req is required"], 422);
            }
        }
        if (!validate_email($data['email'])) {
            json_response(['error' => 'Invalid email format'], 422);
        }

        try {
            $student = Student::create($data);
            $mailer = new Mailer();
            $mailer->sendWelcome(
                $student['email'],
                $student['first_name'] . ' ' . $student['last_name'],
                $student['reg_no']
            );
            json_response($student, 201);
        } catch (Exception $e) {
            json_response(['error' => $e->getMessage()], 422);
        }
    }

    // Update a student (JSON)
    public function update(int $id): void
    {
        $data = $_POST ?: get_input_json();
        $student = Student::find($id);
        json_response($student);
        if (!$student) {
            json_response(['error' => 'Student not found'], 404);
        }

        $required = ['reg_no', 'first_name', 'last_name', 'email', 'class_id'];
        foreach ($required as $field) {
            if (empty($data[$field])) {
                json_response(['error' => "$field is required"], 422);
            }
        }
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            json_response(['error' => 'Invalid email format'], 422);
        }

        try {
            $existingRegNo = Student::findByRegNo($data['reg_no']);
            if ($existingRegNo && $existingRegNo['id'] != $id) {
                json_response(['error' => 'Registration number already exists'], 422);
            }

            $existingEmail = Student::findByEmail($data['email']);
            if ($existingEmail && $existingEmail['id'] != $id) {
                json_response(['error' => 'Email already exists'], 422);
            }

            $updated = Student::updateById($id, $data);
            error_log("Update successful for ID: $id, Data: " . json_encode($updated)); // Log success
            json_response($updated);
        } catch (Exception $e) {
            error_log("Update error for ID: $id - " . $e->getMessage()); // Log error
            json_response(['error' => $e->getMessage()], 422);
        }
    }

    // Delete a student (JSON)
    public function destroy(int $id): void
    {
        $student = Student::find($id);
        if (!$student) {
            json_response(['error' => 'Student not found'], 404);
        }

        if (Student::deleteById($id)) {
            json_response(['message' => 'Student deleted']);
        } else {
            json_response(['error' => 'Failed to delete student'], 500);
        }
    }

    // Update fee status (JSON)
    public function updateFeeStatus(int $id): void
    {
        $data = $_POST ?: get_input_json();
        $student = Student::find($id);
        if (!$student) {
            json_response(['error' => 'Student not found'], 404);
        }
        if (empty($data['fee_status'])) {
            json_response(['error' => 'fee_status is required'], 422);
        }

        try {
            $updated = Student::setFeeStatus($id, $data['fee_status']);
            json_response($updated);
        } catch (Exception $e) {
            json_response(['error' => $e->getMessage()], 422);
        }
    }

    // Render fee status view (HTML) - Add this if needed
    public function feeStatusView(int $id): void
    {
        $student = Student::find($id);
        if (!$student) {
            http_response_code(404);
            echo "Student not found";
            return;
        }
        require __DIR__ . '/../views/FeeStatus.php';
    }

    public function addView(): void
    {
        include __DIR__ . '/../views/Students/AddStudent.php';
    }

    public function editView(int $id): void
    {
        $student = Student::find($id);
        if (!$student) {
            http_response_code(404);
            echo "Student not found";
            return;
        }
        include __DIR__ . '/../views/Students/EditStudent.php';
    }

    public function search()
    {
        $name = $_GET['name'] ?? '';
        json_response(Student::searchByName($name));
    }
}
