<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Participants.php';
require_once __DIR__ . '/../Services/ImportService.php';
require_once __DIR__ . '/../utils/VersionComparator.php';

class BookingController
{
    private $db;
    private $participants;
    private $importService;

    public function __construct()
    {
        $this->db = getDatabaseConnection();
        $this->participants = new Participants($this->db);
        $this->importService = new ImportService($this->db);
    }

    public function import() {
        try {
            $file_path = __DIR__ . '/../data/data.json';
            $this->importService->import($file_path);
        } catch (Exception $e) {
            echo "Error while importing: " . $e->getMessage();
        }
    }

    public function getData($filters, $limit, $offset)
    {
        return $this->participants->getFilteredData($filters, $limit, $offset);
    }
}