<?php

namespace App\models;

class Event {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function create($event)
    {
        $stmt = $this->db->prepare("INSERT INTO events (event_id, event_name, event_date, version) VALUES (?, ?, ?, ?)");
        $stmt->execute([$event['event_id'], $event['event_name'], $event['event_date'], $event['version']]);
        return $this->db->lastInsertId();
    }

    public function getEvent($event_id)
    {
        $stmt = $this->db->prepare("SELECT event_id FROM events WHERE event_id = ?");
        $stmt->execute([$event_id]);
        return $stmt->fetch();
    }
}
