<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "savoy";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch movie ID based on the provided movie name
$movieName = $_POST['movieName'];

$sql = "SELECT movie_id FROM movie WHERE movie_name = '$movieName'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $movieId = $row["movie_id"];
    echo $movieId;
} else {
    echo "0"; // Movie not found
}

$conn->close();
?>
