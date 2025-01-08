<?php
require_once __DIR__ . '/controllers/ParticipantsController.php';

$controller = new ParticipantsController();

$filters = [
    'employee_name' => isset($_GET['employee_name']) ? $_GET['employee_name'] : '',
    'event_name' => isset($_GET['event_name']) ? $_GET['event_name'] : '',
    'event_date' => isset($_GET['event_date']) ? $_GET['event_date'] : '',
];

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$page = max($page, 1);
$limit = isset($_GET['limit']) ? (int) $_GET['limit'] : 10;
$offset = ($page - 1) * $limit;

$result = $controller->getData($filters, $limit, $offset);

$fees = array_map(function ($item) {
    return $item['participation_fee'];
}, $result);

$totalPrice = array_sum($fees);


include __DIR__ . '/views/participants.php';