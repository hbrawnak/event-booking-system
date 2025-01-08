<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Booking.php';

class BookingController
{
    private $booking;
    private $db;

    public function __construct()
    {
        $this->db = getDatabaseConnection();
        $this->booking = new Booking($this->db);
    }

    public function import() {
        $json = file_get_contents(__DIR__ . '/../data/data.json');
        $data = json_decode($json, true);
        foreach ($data as $row) {
            print_r($row);
            $this->booking->create($row);
            print_r('data inserted');
        }
    }

    public function getData($filters)
    {
        return $this->booking->getFilteredData($filters);
    }
}