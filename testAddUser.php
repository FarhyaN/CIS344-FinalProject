<?php
require_once 'PharmacyDatabase.php';

// create the object
$db = new PharmacyDatabase();

// sample user data
$userName = "john_doe";
$contactInfo = "john@example.com";
$userType = "patient"; // or "pharmacist"

// call the method to add the user
$db->addUser($userName, $contactInfo, $userType);
?>
