<?php

use App\config\DBConnection;
use App\controllers\ImportController;

require_once __DIR__ . '/vendor/autoload.php';

$db = DBConnection::getConnection();

$controller = new ImportController($db);
$controller->import();

