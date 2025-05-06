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

    public function addPrescription($patientUserName, $medicationId, $dosageInstructions, $quantity)  {
        $stmt = $this->connection->prepare(
            "SELECT userId FROM Users WHERE userName = ? AND userType = 'patient'"
        );
        $stmt->bind_param("s", $patientUserName);
        $stmt->execute();
        $stmt->bind_result($patientId);
        $stmt->fetch();
        $stmt->close();
        
        if ($patientId){
            $stmt = $this->connection->prepare(
                "INSERT INTO prescriptions (userId, medicationId, dosageInstructions, quantity) VALUES (?, ?, ?, ?)"
            );
            $stmt->bind_param("iisi", $patientId, $medicationId, $dosageInstructions, $quantity);
            $stmt->execute();
            $stmt->close();
            echo "Prescription added successfully";
        }else{
            echo "failed to add prescription";
        }
    }

    public function getAllPrescriptions() {
        $result = $this->connection->query("SELECT * FROM  prescriptions join medications on prescriptions.medicationId= medications.medicationId");
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    public function MedicationInventory() {
        /*
        Complete this function to test the functionality of
        MedicationInventoryView and implement it in the server
        */
        //Write code here
            $result = $this->connection->query(
                "SELECT medications.medicationName, medications.dosage, medications.manufacturer, inventory.quantityAvailable
                 FROM medications
                 JOIN inventory ON medications.medicationId = inventory.medicationId"
            );
            return $result->fetch_all(MYSQLI_ASSOC);
        }
    }

    /*public function addUser($userName, $contactInfo, $userType) {
     //Write Code here
        $stmt = $this->connection->prepare(
            "INSERT INTO Users (userName, contactInfo, userType) VALUES (?, ?, ?)"
        );
        $stmt->bind_param("sss", $userName, $contactInfo, $userType);
        $stmt->execute();
        $stmt->close();
        echo "User added successfully.";
    }
    }*/

    public function addUser($userName, $contactInfo, $userType) {
        // first check if user exists
        $stmt = $this->connection->prepare("select userId from users where userName = ?");
        $stmt->bind_param("s", $userName);
        $stmt->execute();
        $stmt->store_result();
    
        if ($stmt->num_rows > 0) {
            echo "User already exists.";
            $stmt->close();
            return;
        }
    
        $stmt->close();
    
        // insert new user
        $stmt = $this->connection->prepare("insert into users (userName, contactInfo, userType) values (?, ?, ?)");
        $stmt->bind_param("sss", $userName, $contactInfo, $userType);
    
        if ($stmt->execute()) {
            echo "User added successfully.";
        } else {
            echo "Error adding user: " . $stmt->error;
        }
    
        $stmt->close();
    }
    public function addMedication($medicationName, $dosage, $manufacturer) {
        $stmt = $this->connection->prepare(
            "INSERT INTO medications (medicationName, dosage, manufacturer) VALUES (?, ?, ?)"
        );
    
        $stmt->bind_param("sss", $medicationName, $dosage, $manufacturer);
    
        if ($stmt->execute()) {
            echo "Medication added successfully.";
        } else {
            echo "Error adding medication: " . $stmt->error;
        }
    
        $stmt->close();
    }
    

    //Add Other needed functions here
}
?>
