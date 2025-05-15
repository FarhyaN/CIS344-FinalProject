<?php
require_once 'PharmacyDatabase.php';

$db = new PharmacyDatabase();
$inventory = $db->MedicationInventory();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Medication Inventory</title>
    <style>
        table {
            width: 80%;
            border-collapse: collapse;
            margin: 20px auto;
        }
        th, td {
            padding: 10px;
            border: 1px solid #999;
            text-align: center;
        }
        h2 {
            text-align: center;
        }
    </style>
</head>
<body>
    <h2>Medication Inventory</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Medication Name</th>
            <th>Dosage</th>
            <th>Manufacturer</th>
        </tr>
        <?php if (!empty($inventory)): ?>
            <?php foreach ($inventory as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['medicationId']) ?></td>
                    <td><?= htmlspecialchars($row['medicationName']) ?></td>
                    <td><?= htmlspecialchars($row['dosage']) ?></td>
                    <td><?= htmlspecialchars($row['manufacturer']) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="4">No medications found.</td></tr>
        <?php endif; ?>
    </table>
</body>
</html>
