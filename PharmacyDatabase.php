<?php
class PharmacyDatabase {
    private $host = "localhost";
    private $port = "3306";
    private $database = "pharmacy_portal_db";
    private $user = "root";
    private $password = "";
    private $connection;

    public function __construct() {
        $this->connect();
    }

    private function connect() {
        $this->connection = new mysqli($this->host, $this->user, $this->password, $this->database, $this->port);
        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
        echo "Successfully connected to the database";
    }

    // Add prescription for a patient
    public function addPrescription($patientUserName, $medicationId, $dosageInstructions, $quantity) {
        $stmt = $this->connection->prepare(
            "SELECT userId FROM Users WHERE userName = ? AND userType = 'patient'"
        );
        $stmt->bind_param("s", $patientUserName);
        $stmt->execute();
        $stmt->bind_result($patientId);
        $stmt->fetch();
        $stmt->close();
        
        if ($patientId) {
            $stmt = $this->connection->prepare(
                "INSERT INTO prescriptions (userId, medicationId, dosageInstructions, quantity, prescribedDate) 
                 VALUES (?, ?, ?, ?, NOW())"
            );
            $stmt->bind_param("iisi", $patientId, $medicationId, $dosageInstructions, $quantity);
            $stmt->execute();
            $stmt->close();
            echo "Prescription added successfully";
        } else {
            echo "Failed to add prescription: patient not found";
        }
    }

    // Get all prescriptions with medication info
    public function getAllPrescriptions() {
        $result = $this->connection->query(
            "SELECT * FROM prescriptions 
             JOIN medications ON prescriptions.medicationId = medications.medicationId"
        );
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    // Fetch data from MedicationInventoryView
    public function MedicationInventory() {
        $result = $this->connection->query("SELECT * FROM MedicationInventoryView");
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    // Add user if not exists
    public function addUser($userName, $contactInfo, $userType) {
        $stmt = $this->connection->prepare("SELECT userId FROM Users WHERE userName = ?");
        $stmt->bind_param("s", $userName);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            echo "User already exists.";
        } else {
            $stmt->close();
            $stmt = $this->connection->prepare(
                "INSERT INTO Users (userName, contactInfo, userType) VALUES (?, ?, ?)"
            );
            $stmt->bind_param("sss", $userName, $contactInfo, $userType);
            if ($stmt->execute()) {
                echo "User added successfully.";
            } else {
                echo "Failed to add user.";
            }
        }
        $stmt->close();
    }

    // Add a new medication
    public function addMedication($medicationName, $dosage, $manufacturer) {
        $stmt = $this->connection->prepare(
            "INSERT INTO Medications (medicationName, dosage, manufacturer) VALUES (?, ?, ?)"
        );
        $stmt->bind_param("sss", $medicationName, $dosage, $manufacturer);

        if ($stmt->execute()) {
            echo "Medication added successfully.";
        } else {
            echo "Failed to add medication.";
        }
        $stmt->close();
    }

    // Get user details and associated prescriptions
    public function getUserDetails($userId) {
        $stmt = $this->connection->prepare(
            "SELECT 
                u.userId, u.userName, u.contactInfo, u.userType,
                p.prescriptionId, p.medicationId, p.prescribedDate,
                p.dosageInstructions, p.quantity, p.refillCount,
                m.medicationName, m.dosage AS medDosage, m.manufacturer
            FROM 
                Users u
            LEFT JOIN 
                Prescriptions p ON u.userId = p.userId
            LEFT JOIN 
                Medications m ON p.medicationId = m.medicationId
            WHERE 
                u.userId = ?"
        );
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>