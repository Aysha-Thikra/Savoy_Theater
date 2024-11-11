<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: member_login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "savoy");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$stmt = $conn->prepare("SELECT user_id, first_name, last_name, username, email, phone_number FROM users WHERE user_id = ?");
$stmt->bind_param("s", $_SESSION['user_id']);
$stmt->execute();
$stmt->bind_result($user_id, $first_name, $last_name, $username, $email, $phone_number);
$stmt->fetch();
$stmt->close();

// Retrieving user's booking information with movie names
$stmt = $conn->prepare("SELECT m.movie_name, b.date, b.time, b.parking_vehicle, b.seats 
                        FROM booking b 
                        JOIN movie m ON b.movie_id = m.movie_id 
                        WHERE b.user_id = ?");
$stmt->bind_param("s", $_SESSION['user_id']);
$stmt->execute();
$stmt->bind_result($movie_name, $date, $time, $parking_vehicle, $seats);
$booking = array();
while ($stmt->fetch()) {
    $booking[] = array(
        'movie_name' => $movie_name,
        'date' => $date,
        'time' => $time,
        'parking_vehicle' => $parking_vehicle,
        'seats' => $seats
    );
}
$stmt->close();

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="../image/faviconsav.ico">
    <link rel="stylesheet" href="../css/member-dashboard.css">
    <style>
        :root {
            --main-color: #c0392b;
            --body-bg: #232121; 
            --box-bg: #302d2d;
            --text-color: #ffffff;
            --table-border: #302d2d;
        }

        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            background-color: var(--body-bg);
            color: var(--text-color);
        }

        .container {
            padding: 20px;
            margin: auto;
        }

        .profile-section {
            background-color: var(--box-bg);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .profile-section h1 {
            color: var(--main-color);
            margin-bottom: 20px;
        }

        .table {
            width: 100%;
            background-color: var(--box-bg);
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            overflow: hidden; 
        }

        .table th, .table td {
            padding: 12px;
            border: 1px solid var(--table-border);
            color: var(--text-color);
            text-align: center;
            vertical-align: middle;
        }

        .table th {
            background-color: var(--main-color);
            color: #ffffff;
        }

        .table td:last-child {
            border-top-right-radius: 10px; 
            border-bottom-right-radius: 10px;
        }

        .btn {
            background-color: var(--main-color);
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            border-radius: 20px;
            text-decoration: none;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #BB7F7F;
        }

        @media (max-width: 576px) {
            .container {
                padding: 10px;
            }

            .profile-section {
                padding: 15px;
            }

            .table th, .table td {
                padding: 8px;
            }

            .btn {
                padding: 8px 16px;
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="section-header" style="margin-left: 30px;">
         Booking History
    </div>

    <div class="container mt-5" style=" margin-right: 50px;">
        <div class="profile-section">
            <h1>Profile</h1>
            <table class="table">
                <tr>
                    <th>First Name</th>
                    <td><?php echo htmlspecialchars($first_name); ?></td>
                </tr>
                <tr>
                    <th>Last Name</th>
                    <td><?php echo htmlspecialchars($last_name); ?></td>
                </tr>
                <tr>
                    <th>Username</th>
                    <td><?php echo htmlspecialchars($username); ?></td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td><?php echo htmlspecialchars($email); ?></td>
                </tr>
                <tr>
                    <th>Phone Number</th>
                    <td><?php echo htmlspecialchars($phone_number); ?></td>
                </tr>
            </table>
        </div>

        <div class="profile-section">
            <h1>Booking Details</h1>
            <?php if (empty($booking)): ?>
                <p>No booking records found.</p>
            <?php else: ?>
                <table class="table">
                    <thead>
                    <tr>
                        <th>Movie Name</th>
                        <th>Show Date</th>
                        <th>Show Time</th>
                        <th>Parking Vehicle</th>
                        <th>Booked Seats</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($booking as $booking): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($booking['movie_name']); ?></td>
                            <td><?php echo htmlspecialchars($booking['date']); ?></td>
                            <td><?php echo htmlspecialchars($booking['time']); ?></td>
                            <td><?php echo htmlspecialchars($booking['parking_vehicle']); ?></td>
                            <td><?php echo htmlspecialchars($booking['seats']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>

        <a href="booking.php" class="btn" style=" margin-bottom: 50px;">Back to Home</a>
    </div>
</body>
</html>
