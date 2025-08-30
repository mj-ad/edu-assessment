<?php

class Student
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getStudents()
    {
        $this->db->query('SELECT * FROM students ORDER BY id DESC');
        $results = $this->db->resultSet();
        return $results;
    }

    public function addStudent($data)
    {
        $this->db->query('INSERT INTO students (first_name, last_name, email, phone, fee_status) VALUES(:first_name, :last_name, :email, :phone, :fee_status)');
        // Bind values
        $this->db->bind(':last_name', $data['last_name']);
        $this->db->bind(':first_name', $data['first_name']);
        $this->db->bind(':fee_status', $data['fee_status']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':phone', $data['phone']);

        // Execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function updateStudent($data)
    {
        $this->db->query('UPDATE students SET first_name = :first_name, last_name = :last_name, email = :email, phone = :phone, fee_status = :fee_status WHERE id = :id');
        // Bind values
        $this->db->bind(':last_name', $data['last_name']);
        $this->db->bind(':first_name', $data['first_name']);
        $this->db->bind(':fee_status', $data['fee_status']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':phone', $data['phone']);

        // Execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getStudentById($id)
    {
        $this->db->query('SELECT * FROM students WHERE id = :id');
        $this->db->bind(':id', $id);
        $row = $this->db->single();
        return $row;
    }

    public function deleteStudent($id)
    {
        $this->db->query('DELETE FROM students WHERE id = :id');
        // Bind value
        $this->db->bind(':id', $id);

        // Execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
