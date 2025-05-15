<?php
session_start();
require_once 'PharmacyDatabase.php';

$db = new PharmacyDatabase();
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $userType = $_POST['userType']; // 'pharmacist' or 'patient'

    // Look for the user in the database
    $stmt = $db->connection->prepare("SELECT userId, userName, userType FROM Users WHERE userName = ? AND userType = ?");
    $stmt->bind_param("ss", $username, $userType);
    $stmt->execute();
    $stmt->bind_result($userId, $fetchedName, $fetchedType);
    $stmt->fetch();
    $stmt->close();

    if ($userId) {
        // Set session variables
        $_SESSION['userId'] = $userId;
        $_SESSION['username'] = $fetchedName;
        $_SESSION['userType'] = $fetchedType;

        // Redirect to correct dashboard
        if ($fetchedType === 'pharmacist') {
            header("Location: pharmacist_dashboard.php");
        } elseif ($fetchedType === 'patient') {
            header("Location: patient_dashboard.php");
        }
        exit();
    } else {
        $error = "Invalid username or user type.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - Pharmacy Portal</title>
    <style>
        body {
            font-family: Arial;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f7f7f7;
        }
        .login-container {
            background-color: white;
            padding: 25px 40px;
            border: 1px solid #ccc;
            box-shadow: 0 0 10px #ccc;
            border-radius: 5px;
        }
        h2 { text-align: center; }
        form { display: flex; flex-direction: column; }
        input, select, button {
            margin: 10px 0;
            padding: 10px;
            font-size: 16px;
        }
        .error {
            color: red;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="login-container">
    <h2>Pharmacy Portal Login</h2>

    <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>

    <form method="POST" action="">
        <label>Username:</label>
        <input type="text" name="username" required>

        <label>User Type:</label>
        <select name="userType" required>
            <option value="">-- Select User Type --</option>
            <option value="pharmacist">Pharmacist</option>
            <option value="patient">Patient</option>
        </select>

        <button type="submit">Login</button>
    </form>
</div>
</body>
</html>
