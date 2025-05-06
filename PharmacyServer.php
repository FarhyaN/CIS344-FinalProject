<?php
require_once 'PharmacyDatabase.php';

class PharmacyPortal {
    private $db;

    public function __construct() {
        $this->db = new PharmacyDatabase();
    }

    public function handleRequest() {
        $action = $_GET['action'] ?? 'home';

        switch ($action) {
            case 'addPrescription':
                $this->addPrescription();
                break;
            case 'viewPrescriptions':
                $this->viewPrescriptions();
                break;
            case 'viewInventory':
                $this->viewInventory();
                break;
            case 'addUser':
                $this->addUser();
                break;
            default:
                $this->home();
            case 'addUser':
                $this->addUser();
                break;
            case 'viewInventory':
                $this->viewInventory();
                break;
        }
    }

    private function home() {
        include 'templates/home.php';
    }

    private function addPrescription() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $patientUserName = $_POST['patient_username'];
            $medicationId= $_POST['medication_id'];
            $dosageInstructions = $_POST['dosage_instructions'];
            $quantity = $_POST['quantity'];

            $this->db->addPrescription($patientUserName, $medicationId, $dosageInstructions, $quantity);
            header("Location:?action=viewPrescriptions&message=Prescription Added");
        } else {
            include 'templates/addPrescription.php';
        }
    }

    private function viewPrescriptions() {
        $prescriptions = $this->db->getAllPrescriptions();
        include 'templates/viewPrescriptions.php';
    }
    private function addUser() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userName = $_POST['user_name'];
            $contactInfo = $_POST['contact_info'];
            $userType = $_POST['user_type'];
            $this->db->addUser($userName, $contactInfo, $userType);
            header("Location: PharmacyServer.php?message=User+Added");
        } else {
            include 'templates/addUser.php';
        }
    }
    private function viewInventory() {
        $inventory = $this->db->MedicationInventory();
        include 'templates/viewInventory.php';
    }
}

$portal = new PharmacyPortal();
$portal->handleRequest();
