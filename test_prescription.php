<?php
include 'PharmacyDatabase.php';

$db = new PharmacyDatabase();

// Example usage:
$db->addPrescription("john_doe", 1, "take twice daily", 30);
?>
