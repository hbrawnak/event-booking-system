<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Participants.php';

class ParticipantsController
{
    private $db;
    private $participants;

    public function __construct()
    {
        $this->db = getDatabaseConnection();
        $this->participants = new Participants($this->db);
    }

    public function getData($filters, $limit, $offset)
    {
        return $this->participants->getFilteredData($filters, $limit, $offset);
    }
}