<?php
require_once 'handler.php';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Lead Statuses</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>
<h1>Lead Statuses</h1>

<form method="GET" action="list.php">
    <label for="date_from">Date From:</label>
    <input type="date" id="date_from" name="date_from" value="<?= htmlspecialchars($_GET['date_from'] ?? '') ?>">
    <label for="date_to">Date To:</label>
    <input type="date" id="date_to" name="date_to" value="<?= htmlspecialchars($_GET['date_to'] ?? '') ?>">
    <button type="submit">Filter</button>
</form>

<?php

$date_from = $_GET['date_from'] ?? null;
$date_to = $_GET['date_to'] ?? null;

$response = getLeadStatuses($date_from, $date_to);
$responseData = json_decode($response, true);

if (!$responseData['status']) {
    echo "<p style='color: red;'>" . htmlspecialchars($responseData['error'] ?? 'An error occurred.') . "</p>";
} else {
    $leads = $responseData['data'] ?? [];
    if (empty($leads)) {
        echo "<p style='color: red;'>No leads found for the selected dates.</p>";
    } else {
        echo "<table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>FTD</th>
                </tr>
            </thead>
            <tbody>";
        foreach ($leads as $lead) {
            echo "<tr>
                <td>" . htmlspecialchars($lead['id']) . "</td>
                <td>" . htmlspecialchars($lead['email']) . "</td>
                <td>" . htmlspecialchars($lead['status']) . "</td>
                <td>" . htmlspecialchars($lead['ftd']) . "</td>
            </tr>";
        }
        echo "</tbody></table>";
    }
}
?>

</body>
</html>
