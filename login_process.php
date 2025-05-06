<?php
session_start();
require 'PharmacyDatabase.php';

$pharmacyDB = new PharmacyDatabase();
$username = $_POST['username'];
$password = $_POST['password'];

$stmt = $pharmacyDB->getConnection()->prepare("SELECT userid, password, usertype FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->bind_result($userid, $hashed_password, $usertype);
$stmt->fetch();
$stmt->close();

if ($userid && password_verify($password, $hashed_password)) {
    $_SESSION['userid'] = $userid;
    $_SESSION['username'] = $username;
    $_SESSION['usertype'] = $usertype;

    echo "Login successful! Welcome, $usertype.";
    // Redirect based on user type
    if ($usertype == 'pharmacist') {
        header("Location: pharmacist_dashboard.php");
    } else {
        header("Location: patient_dashboard.php");
    }
} else {
    echo "Login failed. Invalid username or password.";
}
?>
