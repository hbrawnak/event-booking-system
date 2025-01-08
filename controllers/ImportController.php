<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../Services/ImportService.php';

class ImportController
{
    private $db;
    private $importService;

    public function __construct()
    {
        $this->db = getDatabaseConnection();
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
}