<?php
session_start();
require_once 'PharmacyDatabase.php';

// Redirect unauthorized users
if (!isset($_SESSION['userType']) || $_SESSION['userType'] !== 'pharmacist') {
    header("Location: login.php");
    exit;
}

$db = new PharmacyDatabase();
$message = "";

// Load patient usernames and medication list for the form
$patients = $db->connection->query("SELECT userName FROM Users WHERE userType = 'patient'")->fetch_all(MYSQLI_ASSOC);
$medications = $db->connection->query("SELECT medicationId, medicationName FROM Medications")->fetch_all(MYSQLI_ASSOC);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $patientUserName = $_POST['patientUserName'];
    $medicationId = $_POST['medicationId'];
    $dosageInstructions = $_POST['dosageInstructions'];
    $quantity = (int)$_POST['quantity'];

    ob_start();
    $db->addPrescription($patientUserName, $medicationId, $dosageInstructions, $quantity);
    $message = ob_get_clean();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Prescription</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #eef2f3;
            padding: 40px;
        }
        .form-container {
            background-color: #fff;
            max-width: 550px;
            margin: auto;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
        }
        select, input[type=text], input[type=number], textarea, button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
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
    <h2>Prescribe Medication</h2>
    <form method="POST" action="">
        <label for="patientUserName">Select Patient:</label>
        <select name="patientUserName" required>
            <option value="">-- Select Patient --</option>
            <?php foreach ($patients as $patient): ?>
                <option value="<?php echo htmlspecialchars($patient['userName']); ?>">
                    <?php echo htmlspecialchars($patient['userName']); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="medicationId">Select Medication:</label>
        <select name="medicationId" required>
            <option value="">-- Select Medication --</option>
            <?php foreach ($medications as $med): ?>
                <option value="<?php echo $med['medicationId']; ?>">
                    <?php echo htmlspecialchars($med['medicationName']); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Dosage Instructions:</label>
        <textarea name="dosageInstructions" rows="3" required></textarea>

        <label>Quantity:</label>
        <input type="number" name="quantity" min="1" required>

        <button type="submit">Add Prescription</button>
    </form>

    <?php if ($message): ?>
        <div class="message"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>
</div>

</body>
</html>
