<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $conn = new mysqli("127.0.0.1", "root", "", "college_database","3308");


    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $student_name = $_POST['student_name'];
    $branch = $_POST['branch'];
    $caste = $_POST['caste'];
    $percentage = $_POST['percentage'];

    // Fetch colleges that meet the criteria
    $sql = "SELECT college_name, branch, cutoff, caste, location, category
            FROM college_info
            WHERE branch = ? AND caste = ? AND cutoff <= ?
            ORDER BY cutoff DESC";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssd", $branch, $caste, $percentage);
    $stmt->execute();
    $result = $stmt->get_result();

    echo "<h1 style='text-align: center;'>Filtered Colleges</h1>";
    echo "<table>";
    echo "<tr><th>College Name</th><th>Branch</th><th>Cutoff</th><th>Caste</th><th>Location</th><th>Category</th></tr>";

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . htmlspecialchars($row['college_name']) . "</td>
                    <td>" . htmlspecialchars($row['branch']) . "</td>
                    <td>" . htmlspecialchars($row['cutoff']) . "</td>
                    <td>" . htmlspecialchars($row['caste']) . "</td>
                    <td>" . htmlspecialchars($row['location']) . "</td>
                    <td>" . htmlspecialchars($row['category']) . "</td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='6'>No colleges found matching your criteria.</td></tr>";
    }

    echo "</table>";

    $stmt->close();
    $conn->close();
}
?>
