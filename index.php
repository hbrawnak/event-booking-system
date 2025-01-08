<?php
require_once 'controllers/BookingController.php';

$controller = new BookingController();

$filters = [
    //'employee_name' => isset($_GET['employee_name']) ? $_GET['employee_name'] : ''
    'employee_name' => 'Reto Fanzen'
];

$data = $controller->getData($filters);
print_r($data);