<?php


require_once 'config/database.php';
require_once 'Booking.php';

// Call the function to get the database connection
$db = getDatabaseConnection();

echo "Database connection established successfully!";
$json = file_get_contents(__DIR__ . '/data/data.json');
$data = json_decode($json, true);

$booking = new Booking($db);
foreach ($data as $row) {
    print_r($row);
    $booking->create($row);
}
