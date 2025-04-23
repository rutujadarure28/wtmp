<?php
$servername = "localhost";
$username = "root";  // Change if needed
$password = "";      // Change if needed
$dbname = "schemes_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$schemeName = $_POST['schemeName'];
$category = $_POST['category'];
$eligibility = implode(", ", $_POST['eligibility']);
$benefits = implode(", ", $_POST['benefits']);
$documents = implode(", ", $_POST['documents']);
$applicationSteps = implode(", ", $_POST['applicationSteps']);

// Insert data into database
$sql = "INSERT INTO schemes (scheme_name, category, eligibility, benefits, documents, application_steps) 
        VALUES ('$schemeName', '$category', '$eligibility', '$benefits', '$documents', '$applicationSteps')";

if ($conn->query($sql) === TRUE) {
    echo "New scheme added successfully!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
