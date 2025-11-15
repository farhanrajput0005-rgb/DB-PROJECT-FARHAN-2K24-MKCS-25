<?php
// Database connection
$servername = "localhost";
$username = "phpuser";  // your MySQL user
$password = "php123";   // your MySQL password
$dbname = "my_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $age = (int)$_POST['age'];
    $city = $conn->real_escape_string($_POST['city']);

    $sql = "INSERT INTO students (name, age, city) VALUES ('$name', $age, '$city')";

    if ($conn->query($sql) === TRUE) {
        $message = "Record submitted successfully!";
    } else {
        $message = "Error: " . $conn->error;
    }
}

// Fetch all students
$result = $conn->query("SELECT * FROM students");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Form</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        input, button { padding: 5px; margin: 5px 0; }
        table { border-collapse: collapse; width: 50%; margin-top: 20px; }
        table, th, td { border: 1px solid black; padding: 8px; text-align: left; }
    </style>
</head>
<body>
    <h2>Enter Student Information</h2>

    <?php if(isset($message)) echo "<p><strong>$message</strong></p>"; ?>

    <form method="POST">
        <label>Name:</label><br>
        <input type="text" name="name" required><br>

        <label>Age:</label><br>
        <input type="number" name="age" required><br>

        <label>City:</label><br>
        <input type="text" name="city" required><br>

        <button type="submit">Submit</button>
    </form>

    <h2>All Students</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Age</th>
            <th>City</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['age']}</td>
                        <td>{$row['city']}</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No records found.</td></tr>";
        }
        ?>
    </table>
</body>
</html>

<?php $conn->close(); ?>
