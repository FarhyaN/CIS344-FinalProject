<?php
session_start();
require_once 'PharmacyDatabase.php';

if (!isset($_SESSION['userId']) || $_SESSION['userType'] !== 'patient') {
    header("Location: login.php");
    exit();
}

$db = new PharmacyDatabase();
$userId = $_SESSION['userId'];
$prescriptions = $db->getUserDetails($userId);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Patient Dashboard</title>
    <style>
        body { font-family: Arial; }
        table { border-collapse: collapse; width: 90%; margin: 20px auto; }
        th, td { padding: 10px; border: 1px solid #ddd; text-align: left; }
        th { background-color: #f2f2f2; }
        h2 { text-align: center; }
    </style>
</head>
<body>
    <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>! Here are your prescriptions:</h2>

    <?php if (empty($prescriptions[0]['prescriptionId'])): ?>
        <p style="text-align: center;">You currently have no prescriptions.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Medication</th>
                    <th>Dosage</th>
                    <th>Manufacturer</th>
                    <th>Quantity</th>
                    <th>Instructions</th>
                    <th>Prescribed Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($prescriptions as $prescription): ?>
                    <?php if ($prescription['prescriptionId']): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($prescription['medicationName']); ?></td>
                            <td><?php echo htmlspecialchars($prescription['medDosage']); ?></td>
                            <td><?php echo htmlspecialchars($prescription['manufacturer']); ?></td>
                            <td><?php echo htmlspecialchars($prescription['quantity']); ?></td>
                            <td><?php echo htmlspecialchars($prescription['dosageInstructions']); ?></td>
                            <td><?php echo htmlspecialchars($prescription['prescribedDate']); ?></td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <div style="text-align: center; margin-top: 20px;">
        <a href="logout.php">Logout</a>
    </div>
</body>
</html>

