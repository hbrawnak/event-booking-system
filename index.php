<?php
require_once __DIR__ . '/controllers/BookingController.php';

$controller = new BookingController();

$filters = [
    'employee_name' => isset($_GET['employee_name']) ? $_GET['employee_name'] : '',
    'event_name' => isset($_GET['event_name']) ? $_GET['event_name'] : '',
    'event_date' => isset($_GET['event_date']) ? $_GET['event_date'] : '',
];

$data = $controller->getData($filters);
//print_r($data);

include __DIR__ . '/views/booking.php';