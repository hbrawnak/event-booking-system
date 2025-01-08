<?php

require_once __DIR__ . '/../models/Employee.php';
require_once __DIR__ . '/../models/Events.php';
require_once __DIR__ . '/../models/Participants.php';
require_once __DIR__ . '/../utils/VersionComparator.php';

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

        $employees = [];
        $events = [];
        $participations = [];

        foreach ($data as $item) {
            $employees[] = $this->mapEmployeeData($item);
            $events[] = $this->mapEventData($item);
            $participations[] = $this->mapParticipationData($item);
        }

        $this->importEmployee($employees);
        $this->importEvents($events);

        $this->importParticipation(
            $this->mapEmployeeIDForParticipation($participations)
        );

        echo "Data imported successfully." . PHP_EOL;
    }

    private function mapEmployeeData($item)
    {
        return [
            'employee_id' => $item['employee_id'],
            'employee_name' => $item['employee_name'],
            'employee_mail' => $item['employee_mail']
        ];
    }

    private function mapEventData($item)
    {
        return [
            'event_id' => $item['event_id'],
            'event_name' => $item['event_name'],
            'event_date' => $item['event_date'],
            'version' => $item['version']
        ];
    }

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

    private function importEmployee($employees)
    {
        foreach ($employees as $employee) {
            $id = $this->insertEmployee($employee);
            if (!in_array($id, $this->employees_data)) {
                $this->employees_data[$employee['employee_mail']] = $id;
            }
        }
    }

    private function insertEmployee($employee)
    {
        $existingEmployee = $this->employees->getEmployee($employee['employee_mail']);
        if ($existingEmployee) {
            return $existingEmployee['employee_id'];
        } else {
            return $this->employees->create($employee);
        }
    }

    private function importEvents($events)
    {
        foreach ($events as $event) {
            $this->insertEvent($event);
        }
    }

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

    private function importParticipation($events)
    {
        foreach ($events as $event) {
            $this->insertParticipation($event);
        }
    }

    private function insertParticipation($participation)
    {
        $existingParticipants = $this->participants->getParticipant($participation);
        if ($existingParticipants) {
            return $existingParticipants['participation_id'];
        } else {
            return $this->participants->create($participation);
        }
    }

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

    private function convertTimezone($date, $version) {
        $eventDate = new DateTime($date);
        if (VersionComparator::isOldVersion($version)) {
            $eventDate->setTimezone(new DateTimeZone('Europe/Berlin'));
        } else {
            $eventDate->setTimezone(new DateTimeZone('UTC'));
        }
        return $eventDate->format('Y-m-d H:i:s');
    }
}

