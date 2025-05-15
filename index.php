<?php
require_once 'PharmacyDatabase.php';

$db = new PharmacyDatabase();

// Test adding a user
$db->addUser("john_doe", "john@example.com", "patient");

// Test displaying inventory
$inventory = $db->MedicationInventory();
echo "<h2>Medication Inventory</h2><pre>";
print_r($inventory);
echo "</pre>";
?>
