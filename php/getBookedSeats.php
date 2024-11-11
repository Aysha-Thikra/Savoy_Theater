<?php
include 'db_connection.php';

// Check if date and time are sent via POST request
if(isset($_POST['date']) && isset($_POST['time'])) {
    // Sanitize the input to prevent SQL injection
    $date = mysqli_real_escape_string($conn, $_POST['date']);
    $time = mysqli_real_escape_string($conn, $_POST['time']);

    // Construct the SQL query to fetch booked seats for the given date and time
    $query = "SELECT seats FROM booking WHERE date = '$date' AND time = '$time'";
    $result = mysqli_query($conn, $query);

    // Initialize an array to store booked seats
    $bookedSeats = [];

    // Fetch booked seats and store them in the array
    while($row = mysqli_fetch_assoc($result)) {
        $seats = explode(",", $row['seats']); // Split the seats string into an array
        $bookedSeats = array_merge($bookedSeats, $seats); // Merge the arrays
    }

    // Send the booked seats as a comma-separated string
    echo implode(",", $bookedSeats);
} else {
    // If date and time are not provided, return an error message
    echo "Error: Date and time are required parameters.";
}

// Close the database connection
mysqli_close($conn);
?>
