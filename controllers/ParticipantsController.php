<?php

namespace App\controllers;

use App\models\Participant;
use PDO;

/**
 * Class ParticipantsController
 * Handles the logic for fetching participant data from the database
 * and applying filters, pagination, and other operations.
 */
class ParticipantsController
{
    private $participants;

    public function __construct(PDO $db)
    {
        $this->participants = new Participant($db);
    }

    /**
     * Fetch filtered participant data with pagination.
     *
     * @param array $filters Filters to be applied (e.g., employee_name, event_name, event_date).
     * @param int $limit The maximum number of records to fetch.
     * @param int $offset The starting point for the records to fetch.
     * @return array The filtered and paginated participant data.
     */
    public function getData($filters, $limit, $offset)
    {
        return $this->participants->getFilteredData($filters, $limit, $offset);
    }
}