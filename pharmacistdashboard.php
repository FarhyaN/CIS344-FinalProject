<?php
session_start();
if (!isset($_SESSION['userId']) || $_SESSION['userType'] !== 'pharmacist') {
    header("Location: login.php");
    exit();
}
?>

<h2>Welcome, Pharmacist <?= htmlspecialchars($_SESSION['userName']) ?></h2>
<ul>
        <li><a href="add_medication_form.php">Add New Medication</a></li>
        <li><a href="add_prescription_form.php">Add New Prescription</a></li>
        <li><a href="view_prescriptions.php">View All Prescriptions</a></li>
        <li><a href="view_inventory.php">View Medication Inventory</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</body>
</html>

