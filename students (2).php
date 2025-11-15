<?php
// Database configuration
$servername = "localhost";
$username = "phpuser";  // your MySQL user
$password = "php123";   // your MySQL password
$dbname = "my_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create table if it doesn't exist
$conn->query("CREATE TABLE IF NOT EXISTS students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50),
    age INT,
    city VARCHAR(50)
)");

// Handle form submission
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
<html lang="en">
<head>
<meta charset="UTF-8">
<title>AI Student Form</title>
<link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&display=swap" rel="stylesheet">
<style>
/* Global */
body {
    margin: 0;
    font-family: 'Orbitron', sans-serif;
    background: #000; /* dark black background */
    color: #fff;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    align-items: center;
    overflow-x: hidden;
    position: relative;
}

/* Animated background lines */
@keyframes lineMove {
    0% { transform: translateX(0); }
    100% { transform: translateX(-100%); }
}

.background-lines {
    position: fixed;
    top: 0; left: 0;
    width: 200%;
    height: 100%;
    background: repeating-linear-gradient(
        0deg,
        rgba(0,255,255,0.05) 0px,
        rgba(0,255,255,0.05) 1px,
        transparent 1px,
        transparent 20px
    );
    animation: lineMove 15s linear infinite;
    z-index: -2;
}

/* Header */
h2 {
    text-align: center;
    font-size: 2.5rem;
    margin: 30px 0;
    background: linear-gradient(90deg, #00f0ff, #ff00e0);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    animation: glow 2s infinite alternate;
}

@keyframes glow {
    0% { text-shadow: 0 0 10px #00f0ff, 0 0 20px #ff00e0; }
    100% { text-shadow: 0 0 20px #00f0ff, 0 0 30px #ff00e0; }
}

/* Form */
form {
    background: rgba(255,255,255,0.05);
    padding: 30px;
    border-radius: 15px;
    backdrop-filter: blur(10px);
    box-shadow: 0 0 30px rgba(0,0,0,0.5);
    width: 350px;
    animation: fadeIn 1s ease forwards;
    margin-bottom: 20px;
}

input, button {
    width: 100%;
    padding: 12px;
    margin: 10px 0;
    border: none;
    border-radius: 8px;
    outline: none;
    font-size: 1rem;
    transition: all 0.3s ease;
}

input {
    background: rgba(255,255,255,0.1);
    color: #fff;
}

input:focus {
    background: rgba(255,255,255,0.2);
    box-shadow: 0 0 10px #00f0ff;
}

button {
    background: linear-gradient(90deg, #00f0ff, #ff00e0);
    color: #fff;
    cursor: pointer;
    font-weight: bold;
    text-transform: uppercase;
}

button:hover {
    transform: scale(1.05);
    box-shadow: 0 0 15px #00f0ff, 0 0 20px #ff00e0;
}

/* Message */
.message {
    margin: 15px 0;
    text-align: center;
    font-size: 1.2rem;
    color: #00ffea;
    animation: glow 1.5s infinite alternate;
}

/* Table */
table {
    border-collapse: collapse;
    margin-top: 20px;
    width: 80%;
    text-align: left;
    border-radius: 10px;
    overflow: hidden;
    opacity: 0;
    transform: translateY(20px);
    transition: all 0.8s ease;
}

table.show {
    opacity: 1;
    transform: translateY(0);
}

th, td {
    padding: 15px;
    background: rgba(255,255,255,0.05);
}

th {
    background: linear-gradient(90deg, #00f0ff, #ff00e0);
    color: #fff;
}

tr:nth-child(even) td {
    background: rgba(255,255,255,0.02);
}

/* Fade in animation */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Hide/Show button */
#toggleBtn {
    background: #111;
    color: #00f0ff;
    margin-top: 15px;
    width: 200px;
}

#toggleBtn:hover {
    color: #ff00e0;
    transform: scale(1.05);
}
</style>
</head>
<body>
<div class="background-lines"></div>

<h2>AI Student Registration</h2>

<?php if($message) echo "<div class='message'>$message</div>"; ?>

<form method="POST">
    <input type="text" name="name" placeholder="Name" required>
    <input type="number" name="age" placeholder="Age" required>
    <input type="text" name="city" placeholder="City" required>
    <button type="submit">Submit</button>
</form>

<button id="toggleBtn">Show/Hide Students Data</button>

<table id="studentsTable">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Age</th>
        <th>City</th>
    </tr>
    <?php
    if ($result && $result->num_rows > 0) {
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

<script>
// Hide/Show Table
const toggleBtn = document.getElementById('toggleBtn');
const table = document.getElementById('studentsTable');

toggleBtn.addEventListener('click', () => {
    table.classList.toggle('show');
});
</script>

</body>
</html>

<?php $conn->close(); ?>
