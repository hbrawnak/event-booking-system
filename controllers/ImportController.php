<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../Services/ImportService.php';


/**
 * Class ImportController
 * Responsible for managing the import process, including data loading
 * and error handling during the import operation.
 */
class ImportController
{
    private $db;
    private $importService;

    public function __construct()
    {
        $this->db = getDatabaseConnection();
        $this->importService = new ImportService($this->db);
    }

    /**
     * Handles the import operation.
     * This method attempts to import data from a predefined JSON file and
     * captures any exceptions that occur during the process.
     */
    public function import() {
        try {
            $file_path = __DIR__ . '/../data/data.json';
            $this->importService->import($file_path);
        } catch (Exception $e) {
            echo "Error while importing: " . $e->getMessage();
        }
    }
}