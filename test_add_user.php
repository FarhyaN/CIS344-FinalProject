<?php
require_once 'PharmacyDatabase.php';

$pharmacyDb = new PharmacyDatabase();

// Test data
$userName = "john_doe";
$contactInfo = "john@example.com";
$userType = "patient";

// Add user
$result = $pharmacyDb->addUser($userName, $contactInfo, $userType);

if ($result) {
    echo "User added successfully!";
} else {
    echo "Failed to add user.";
}
?>
