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

    public function getFilteredData($filters)
    {
        $query = "SELECT * FROM bookings WHERE 1=1";
        $params = [];

        if (!empty($filters['employee_name'])) {
            $query .= " AND employee_name LIKE :employee_name";
            $params[':employee_name'] = "%" . $filters['employee_name'] . "%";
        }
        if (!empty($filters['event_name'])) {
            $query .= " AND event_name LIKE :event_name";
            $params[':event_name'] = "%" . $filters['event_name'] . "%";
        }
        if (!empty($filters['event_date'])) {
            $query .= " AND DATE(event_date) = :event_date";
            $params[':event_date'] = $filters['event_date'];
        }

        $stmt = $this->db->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
