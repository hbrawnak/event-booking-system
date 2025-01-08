<?php

class Booking {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function create($data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO bookings (participation_id, employee_name, employee_mail, event_id, event_name, participation_fee, event_date, version)
            VALUES (:participation_id, :employee_name, :employee_mail, :event_id, :event_name, :participation_fee, :event_date, :version)
        ");
        $stmt->execute($data);
    }
}
