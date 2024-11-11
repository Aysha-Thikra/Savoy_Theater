<?php
include 'db_connection.php';

if(isset($_POST['username'])) {
    $username = $_POST['username'];

    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0) {
        echo "valid";
    } else {
        echo "invalid";
    }

    $stmt->close();
} else {
    echo "error";
}
?>
