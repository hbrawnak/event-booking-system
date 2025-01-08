<?php

class Employee {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function create($employee)
    {
        $stmt = $this->db->prepare("INSERT INTO employees (employee_name, employee_mail) VALUES (?, ?)");
        $stmt->execute([$employee['employee_name'], $employee['employee_mail']]);
        return $this->db->lastInsertId();
    }

    public function getEmployee($email)
    {
        $stmt = $this->db->prepare("SELECT employee_id FROM employees WHERE employee_mail = ?");
        $stmt->execute([$email]);
        return $stmt->fetch();
    }
}
