<html>
<head><title>Add User</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>
<h1>Add New User</h1>
<form method="POST" action="?action=addUser">
    Username: <input type="text" name="user_name" required><br>
    Contact Info: <input type="text" name="contact_info" required><br>
    User Type: 
    <select name="user_type" required>
        <option value="pharmacist">Pharmacist</option>
        <option value="patient">Patient</option>
    </select><br><br>
    <button type="submit">Add User</button>
</form>
<a href="PharmacyServer.php">Back to Home</a>
</body>
</html>