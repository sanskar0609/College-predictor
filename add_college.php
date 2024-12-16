<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $conn = new mysqli("127.0.0.1", "root", "", "college_database","3308");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $college_name = $_POST['college_name'];
    $branch = $_POST['branch'];
    $general_cutoff = $_POST['general_cutoff'];
    $obc_cutoff = $_POST['obc_cutoff'];
    $sc_cutoff = $_POST['sc_cutoff'];
    $st_cutoff = $_POST['st_cutoff'];
    $location = $_POST['location'];
    $category = $_POST['category'];

    $sql = "INSERT INTO college_info (college_name, branch, cutoff, caste, location, category)
            VALUES 
            ('$college_name', '$branch', $general_cutoff, 'General', '$location', '$category'),
            ('$college_name', '$branch', $obc_cutoff, 'OBC', '$location', '$category'),
            ('$college_name', '$branch', $sc_cutoff, 'SC', '$location', '$category'),
            ('$college_name', '$branch', $st_cutoff, 'ST', '$location', '$category')";

    if ($conn->query($sql) === TRUE) {
        echo "College data added successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
