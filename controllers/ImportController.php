<?php

namespace App\controllers;

use App\services\ImportService;
use Exception;

/**
 * Class ImportController
 * Responsible for managing the import process, including data loading
 * and error handling during the import operation.
 */
class ImportController
{
    private $importService;

    public function __construct($db)
    {
        $this->importService = new ImportService($db);
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