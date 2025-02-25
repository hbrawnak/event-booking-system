<?php
/**
 * @var array $result
 * @var array $filters
 * @var float $totalPrice
 * @var int $page
 * @var int $limit
 */
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Event Bookings</title>
</head>
<body>
<form method="get" action="/index.php">
    <label for="employee_name">Employee Name:</label>
    <input type="text" id="employee_name" name="employee_name" value="<?= htmlspecialchars(isset($filters['employee_name']) ? $filters['employee_name'] : '') ?>">

    <label for="event_name">Event Name:</label>
    <input type="text" id="event_name" name="event_name" value="<?= htmlspecialchars(isset($filters['event_name']) ? $filters['event_name'] : '') ?>">

    <label for="event_date">Event Date:</label>
    <input type="date" id="event_date" name="event_date" value="<?= htmlspecialchars(isset($filters['event_date']) ? $filters['event_date'] : '') ?>">

    <button type="submit">Filter</button>
</form>
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
    <?php foreach ($result as $row): ?>
        <tr>
            <td><?= htmlspecialchars($row['employee_name']) ?></td>
            <td><?= htmlspecialchars($row['employee_mail']) ?></td>
            <td><?= htmlspecialchars($row['event_name']) ?></td>
            <td><?= htmlspecialchars($row['event_date']) ?></td>
            <td><?= htmlspecialchars(number_format($row['participation_fee'], 2)) ?></td>
        </tr>
    <?php endforeach; ?>
    <tr>
        <td colspan="4" style="text-align: right;"><strong>Total Price:</strong></td>
        <td><strong><?= number_format($totalPrice, 2) ?></strong></td>
    </tr>
    </tbody>
</table>

<?php if (count($result) > 0): ?>
    <div class="pagination">
        <?php if ($page == 1): ?>
        <a href="#">Previous</a>
        <?php else: ?>
            <a href="?page=<?= $page - 1 ?>&limit=<?= $limit ?>" class="prev" <?= ($page <= 1) ? 'disabled' : '' ?>>Previous</a>
        <?php endif; ?>
        <a href="?page=<?= $page + 1 ?>&limit=<?= $limit ?>" class="next">Next</a>
    </div>
<?php else: ?>
    <div class="pagination">
        <?php if ($page == 1): ?>
            <a href="#">Previous</a>
        <?php else: ?>
            <a href="?page=<?= $page - 1 ?>&limit=<?= $limit ?>" class="prev" <?= ($page <= 1) ? 'disabled' : '' ?>>Previous</a>
        <?php endif; ?>
            <a href="#">Next</a>
    </div>
<?php endif; ?>

</body>
</html>