<?php
include 'db_connection.php';

// Function to generate a unique ID
function generateID($prefix, $conn, $table, $id_field) {
    $result = mysqli_query($conn, "SELECT MAX($id_field) AS max_id FROM $table");
    $row = mysqli_fetch_assoc($result);
    $max_id = $row['max_id'];

    if ($max_id) {
        $num = intval(substr($max_id, strlen($prefix))) + 1;
        $new_id = $prefix . str_pad($num, 5 - strlen($prefix), '0', STR_PAD_LEFT);
    } else {
        $new_id = $prefix . '00001';
    }

    // Check if the generated ID already exists
    $query = "SELECT * FROM $table WHERE $id_field = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $new_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // If the generated ID already exists, call the function recursively
        $new_id = generateID($prefix, $conn, $table, $id_field);
    }

    return $new_id;
}

if (isset($_POST['username']) && isset($_POST['movieName']) && isset($_POST['showDate']) && isset($_POST['showTime']) && isset($_POST['numChildren']) && isset($_POST['numAdults']) && isset($_POST['parking']) && isset($_POST['totalAmount']) && isset($_POST['seats'])) {
    $username = $_POST['username'];
    $movieName = $_POST['movieName'];
    $showDate = $_POST['showDate'];
    $showTime = $_POST['showTime'];
    $numChildren = $_POST['numChildren'];
    $numAdults = $_POST['numAdults'];
    $parking = $_POST['parking'];
    $totalAmount = $_POST['totalAmount'];
    $selectedSeats = $_POST['seats'];

    // Fetch user_id based on username
    $query = "SELECT user_id FROM users WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $userId = $row['user_id'];

        // Fetch movie_id based on movieName
        $query = "SELECT movie_id FROM movie WHERE movie_name = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $movieName);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $movieId = $row['movie_id'];

            // Generate booking_id
            $bookingId = generateID('B', $conn, 'booking', 'booking_id');

            // Insert booking details into the booking table
            $query = "INSERT INTO booking (booking_id, user_id, movie_id, date, time, seats, children, adults, parking_vehicle, total_price) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ssssssssss", $bookingId, $userId, $movieId, $showDate, $showTime, $selectedSeats, $numChildren, $numAdults, $parking, $totalAmount);

            if ($stmt->execute()) {
                echo "Booking successful.";
            } else {
                echo "Error: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Error: Movie not found.";
        }
    } else {
        echo "Error: Username not found.";
    }
} else {
    echo "Error: Missing required fields.";
}

$conn->close();
?>
