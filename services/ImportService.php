<?php

require_once __DIR__ . '/../models/Employee.php';
require_once __DIR__ . '/../models/Events.php';
require_once __DIR__ . '/../models/Participants.php';
require_once __DIR__ . '/../utils/VersionComparator.php';

/**
 * Class ImportService
 * Handles the data import functionality for employees, events, and participations.
 * Ensures data integrity and updates database with new or modified data.
 */
class ImportService
{
    private $db;
    private $employees;
    private $events;
    private $participants;

    private $employees_data = [];

    public function __construct($db)
    {
        $this->db = $db;
        $this->employees = new Employee($db);
        $this->events = new Events($db);
        $this->participants = new Participants($db);
    }

    /**
     * Imports data from a JSON file and populates the database.
     *
     * @param string $filePath Path to the JSON file to be imported.
     * @throws Exception If file is not found or JSON is invalid.
     */
    public function import($filePath)
    {
        if (!file_exists($filePath)) {
            throw new Exception("File not found: $filePath");
        }

        $jsonData = file_get_contents($filePath);
        $data = json_decode($jsonData, true);

        if ($data === null) {
            throw new Exception("Invalid JSON format.");
        }

        echo "Importing data .." . PHP_EOL;

        // Initialize arrays to hold parsed data.
        $employees = [];
        $events = [];
        $participations = [];

        // Parse data into individual entities.
        foreach ($data as $item) {
            $employees[] = $this->mapEmployeeData($item);
            $events[] = $this->mapEventData($item);
            $participations[] = $this->mapParticipationData($item);
        }

        // Import the parsed data into the respective tables.
        $this->importEmployee($employees);
        $this->importEvents($events);
        $this->importParticipation(
            $this->mapEmployeeIDForParticipation($participations)
        );

        echo "Data imported successfully." . PHP_EOL;
    }

    /**
     * Maps raw employee data to the required format for database insertion.
     *
     * @param array $item Raw data item.
     * @return array Mapped employee data.
     */
    private function mapEmployeeData($item)
    {
        return [
            'employee_id' => $item['employee_id'],
            'employee_name' => $item['employee_name'],
            'employee_mail' => $item['employee_mail']
        ];
    }

    /**
     * Maps raw event data to the required format for database insertion.
     *
     * @param array $item Raw data item.
     * @return array Mapped event data.
     */
    private function mapEventData($item)
    {
        return [
            'event_id' => $item['event_id'],
            'event_name' => $item['event_name'],
            'event_date' => $item['event_date'],
            'version' => $item['version']
        ];
    }

    /**
     * Maps raw participation data to the required format for database insertion.
     *
     * @param array $item Raw data item.
     * @return array Mapped participation data.
     */
    private function mapParticipationData($item)
    {
        return [
            'participation_id' => $item['participation_id'],
            'employee_mail' => $item['employee_mail'],
            'employee_id' => $item['employee_id'],
            'event_id' => $item['event_id'],
            'participation_fee' => $item['participation_fee'],
        ];
    }

    /**
     * Imports employee data into the database, avoiding duplicates.
     *
     * @param array $employees Array of employee data.
     */
    private function importEmployee($employees)
    {
        foreach ($employees as $employee) {
            $id = $this->insertEmployee($employee);
            if (!in_array($id, $this->employees_data)) {
                $this->employees_data[$employee['employee_mail']] = $id;
            }
        }
    }

    /**
     * Inserts a single employee record or retrieves the ID of an existing one.
     *
     * @param array $employee Employee data.
     * @return int Employee ID.
     */
    private function insertEmployee($employee)
    {
        $existingEmployee = $this->employees->getEmployee($employee['employee_mail']);
        if ($existingEmployee) {
            return $existingEmployee['employee_id'];
        } else {
            return $this->employees->create($employee);
        }
    }

    /**
     * Imports event data into the database, avoiding duplicates.
     *
     * @param array $events Array of event data.
     */
    private function importEvents($events)
    {
        foreach ($events as $event) {
            $this->insertEvent($event);
        }
    }

    /**
     * Inserts a single event record or retrieves the ID of an existing one.
     *
     * @param array $event Event data.
     * @return int Event ID.
     */
    private function insertEvent($event)
    {
        $existingEvent = $this->events->getEvent($event['event_id']);
        if ($existingEvent) {
            return $existingEvent['event_id'];
        } else {
            $event['event_date'] = $this->convertTimezone($event['event_date'], $event['version']);
            return $this->events->create($event);
        }
    }

    /**
     * Imports participation data into the database.
     *
     * @param array $participations Array of participation data.
     */
    private function importParticipation($participations)
    {
        foreach ($participations as $participation) {
            $this->insertParticipation($participation);
        }
    }

    /**
     * Inserts a single participation record or retrieves the ID of an existing one.
     *
     * @param array $participation Participation data.
     * @return int Participation ID.
     */
    private function insertParticipation($participation)
    {
        $existingParticipants = $this->participants->getParticipant($participation);
        if ($existingParticipants) {
            return $existingParticipants['participation_id'];
        } else {
            return $this->participants->create($participation);
        }
    }

    /**
     * Maps employee email to their corresponding ID for participations.
     *
     * @param array $participations Array of participation data.
     * @return array Updated participation data with employee IDs.
     */
    private function mapEmployeeIDForParticipation($participations)
    {
        $newParticipation = [];
        foreach ($participations as $participation) {
            $participation['employee_id'] = $this->employees_data[$participation['employee_mail']];
            unset($participation['employee_mail']);
            $newParticipation[] = $participation;
        }

        return $newParticipation;
    }

    /**
     * Converts event date based on version.
     *
     * @param string $date Event date.
     * @param string $version Event version.
     * @return string Converted date.
     */
    private function convertTimezone($date, $version)
    {
        $eventDate = new DateTime($date);
        if (VersionComparator::isOldVersion($version)) {
            $eventDate->setTimezone(new DateTimeZone('Europe/Berlin'));
        } else {
            $eventDate->setTimezone(new DateTimeZone('UTC'));
        }
        return $eventDate->format('Y-m-d H:i:s');
    }
}
