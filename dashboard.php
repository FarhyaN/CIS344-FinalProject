<?php
session_start();
if (!isset($_SESSION['userType']) || !isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$userType = $_SESSION['userType'];
$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo ucfirst($userType); ?> Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #eef2f3;
            padding: 40px;
        }
        .dashboard {
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            max-width: 600px;
            margin: auto;
            padding: 30px;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        li {
            background: #007BFF;
            color: white;
            padding: 12px;
            margin: 10px 0;
            border-radius: 8px;
            text-align: center;
        }
        li a {
            color: white;
            text-decoration: none;
            display: block;
        }
        li:hover {
            background: #0056b3;
        }
        .logout {
            text-align: center;
            margin-top: 20px;
        }
        .logout a {
            color: #d9534f;
            text-decoration: none;
        }
    </style>
</head>
<body>

<div class="dashboard">
    <h2>Welcome, <?php echo ucfirst($userType) . " " . htmlspecialchars($username); ?></h2>
    
    <ul>
        <?php if ($userType === 'pharmacist'): ?>
            <li><a href="add_medication_form.php">Add Medication</a></li>
            <li><a href="view_inventory.php">View Inventory</a></li>
            <li><a href="view_sales.php">View Sales</a></li>
            <li><a href="add_prescription_form.php">Add Prescription</a></li>
        <?php else: ?>
            <li><a href="view_prescriptions.php">View My Prescriptions</a></li>
            <li><a href="request_refill.php">Request Refill</a></li>
        <?php endif; ?>
    </ul>

    <div class="logout">
        <a href="logout.php">Logout</a>
    </div>
</div>

</body>
</html>
