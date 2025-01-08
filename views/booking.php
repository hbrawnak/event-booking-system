<?php
/**
 * @var array $data
 */
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Event Bookings</title>
</head>
<body>

<table border="1">
    <thead>
    <tr>
        <th>Employee Name</th>
        <th>Email</th>
        <th>Event Name</th>
        <th>Event Date</th>
        <th>Fee</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($data as $row): ?>
        <tr>
            <td><?= htmlspecialchars($row['employee_name']) ?></td>
            <td><?= htmlspecialchars($row['employee_mail']) ?></td>
            <td><?= htmlspecialchars($row['event_name']) ?></td>
            <td><?= htmlspecialchars($row['event_date']) ?></td>
            <td><?= htmlspecialchars(number_format($row['participation_fee'], 2)) ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>