<?php

namespace App\models;

use PDO;

class Participant {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function create($participation)
    {
        $stmt = $this->db->prepare("INSERT INTO participations (participation_id, employee_id, event_id, participation_fee) VALUES (?, ?, ?, ?)");
        $stmt->execute([$participation['participation_id'], $participation['employee_id'], $participation['event_id'], $participation['participation_fee']]);
        return $this->db->lastInsertId();
    }

    public function getParticipant($participation)
    {
        $stmt = $this->db->prepare("SELECT participation_id FROM participations WHERE employee_id = ? AND event_id = ?");
        $stmt->execute([$participation['employee_id'], $participation['event_id']]);
        return $stmt->fetch();
    }

    public function getFilteredData($filters, $limit = 10, $offset = 0)
    {
        $query = "
                SELECT p.participation_id, e.employee_name, e.employee_mail, ev.event_name, ev.event_date, p.participation_fee, ev.version
                FROM participations p
                INNER JOIN employees e ON p.employee_id = e.employee_id
                INNER JOIN events ev ON p.event_id = ev.event_id
                WHERE 1=1
            ";
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

        $query .= " ORDER BY p.participation_id DESC LIMIT :limit OFFSET :offset";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
