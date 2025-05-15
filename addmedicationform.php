<?php
session_start();
require_once 'PharmacyDatabase.php';

// Redirect if not a pharmacist
if (!isset($_SESSION['userType']) || $_SESSION['userType'] !== 'pharmacist') {
    header("Location: login.php");
    exit;
}

$message = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $medicationName = $_POST['medicationName'];
    $dosage = $_POST['dosage'];
    $manufacturer = $_POST['manufacturer'];

    $db = new PharmacyDatabase();
    ob_start(); // capture echoed output
    $db->addMedication($medicationName, $dosage, $manufacturer);
    $message = ob_get_clean();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Medication</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #eef2f3;
            padding: 40px;
        }
        .form-container {
            background-color: #fff;
            max-width: 500px;
            margin: auto;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
        }
        input[type=text], button {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border-radius: 6px;
            border: 1px solid #ccc;
        }
        button {
            background-color: #007BFF;
            color: white;
            border: none;
        }
        button:hover {
            background-color: #0056b3;
        }
        .message {
            margin-top: 15px;
            text-align: center;
            color: green;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Add New Medication</h2>
    <form method="POST" action="">
        <label>Medication Name:</label>
        <input type="text" name="medicationName" required>

        <label>Dosage:</label>
        <input type="text" name="dosage" required>

        <label>Manufacturer:</label>
        <input type="text" name="manufacturer" required>

        <button type="submit">Add Medication</button>
    </form>

    <?php if ($message): ?>
        <div class="message"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>
</div>

</body>
</html>
