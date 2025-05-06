<?php
require_once 'PharmacyDatabase.php';

// create the object
$db = new PharmacyDatabase();

// sample medication data
$medicationName = "Amoxicillin";
$dosage = "500mg";
$manufacturer = "Pfizer";

// call the method
$db->addMedication($medicationName, $dosage, $manufacturer);
?>
