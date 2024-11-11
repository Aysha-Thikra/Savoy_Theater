<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Form</title>
    <link rel="icon" type="image/x-icon" href="../image/faviconsav.ico">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;700;900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background: url(../img/bg.jpeg);
        }

        .feedback-form {
            background-color: #751313;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 700px;
            padding: 20px;
            position: relative;
            overflow: hidden;
            margin-top: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
            color: #ffffff;
        }

        .form-group input[type="text"],
        .form-group textarea {
            width: calc(100% - 40px);
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            background: #ccc;
            outline: none;
            margin-right: 20px;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }

        .submit-btn,
        .create-account-btn  {
            background-color: #ffffff;
            color: #751313;
            padding: 10px 20px;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            width: calc(100% - 40px);
            font-size: 16px;
            margin-right: 20px;
        }

        .submit-btn:hover,
        .create-account-btn:hover {
            background-color: #a52c20;
        }

    </style>
    <script>
        function validatePhoneNumber(phone) {
            const phoneRegex = /^\+\d{1,2}\d{10}$/;
            return phoneRegex.test(phone);
        }

        function checkUsername() {
            const username = document.getElementById('username').value;
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'write-review.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    if (response.exists) {
                        document.getElementById('user_id').value = response.user_id;
                    } else {
                        document.getElementById('user_id').value = '';
                        alert('Username is not registered.');
                        document.getElementById('username').focus();
                    }
                }
            };
            xhr.send('check_username=1&username=' + encodeURIComponent(username));
        }

        function validateForm() {
            const phone = document.getElementById('phone').value;
            if (!validatePhoneNumber(phone)) {
                alert('Phone number must include the country code and be in the format +CCXXXXXXXXXX.');
                return false;
            }
            return true;
        }
    </script>
</head>
<body>

    <!-- Feedback Form -->
    <div class="feedback-form">
        <form id="feedback-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" onsubmit="return validateForm()">
            <div class="form-group">
                <label for="username">Registered Username:</label>
                <input type="text" id="username" name="username" required onblur="checkUsername()">
                <input type="hidden" id="user_id" name="user_id">
            </div>
            <div class="form-group">
                <label for="phone">Phone Number:</label>
                <input type="text" id="phone" name="phone" required>
            </div>
            <div class="form-group">
                <label for="review">Review:</label>
                <textarea id="review" name="review" rows="4" required></textarea>
            </div>
            <button type="submit" class="submit-btn">Submit Feedback</button>
            <p style="text-align:center; color: white;">Don't have an account ? &#128071;</p>
            <button type="button" class="create-account-btn" onclick="window.location.href='register.php'">Create Account</button>
        </form>
    </div>

</body>
</html>

<?php
// Establishing a connection to the database
$servername = "localhost";
$username = "root";
$password = "";
$database = "savoy";

$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Function to sanitize user input
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Function to generate feedback_id
function generateID($prefix, $conn, $table, $id_field) {
    $result = mysqli_query($conn, "SELECT MAX($id_field) AS max_id FROM $table");
    $row = mysqli_fetch_assoc($result);
    $max_id = $row['max_id'];
    
    if ($max_id) {
        $num = intval(substr($max_id, strlen($prefix))) + 1;
        $new_id = $prefix . str_pad($num, 4, '0', STR_PAD_LEFT);
    } else {
        $new_id = $prefix . '0001';
    }

    return $new_id;
}

// Check if the AJAX request to validate username
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['check_username'])) {
    $username = $_POST['username'];
    $sql = "SELECT user_id FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id);
        $stmt->fetch();
        $response = array("exists" => true, "user_id" => $user_id);
    } else {
        $response = array("exists" => false, "user_id" => null);
    }
    echo json_encode($response);
    
    $stmt->close();
    mysqli_close($conn);
    exit();
}

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['check_username'])) {
    // Initialize variables
    $username = $phone = $review = "";
    $user_id = 0; 

    // Sanitize user input
    $username = sanitize_input($_POST["username"]);
    $phone = sanitize_input($_POST["phone"]);
    $review = sanitize_input($_POST["review"]);

    // Validate phone number
    if (!preg_match('/^\+\d{1,2}\d{10}$/', $phone)) {
        echo "<script>alert('Phone number must include the country code and be in the format +CCXXXXXXXXXX.'); window.history.back();</script>";
        exit();
    }

    // Check if the username is provided and registered
    if (!empty($username)) {
        $sql = "SELECT user_id FROM users WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($user_id);
            $stmt->fetch();
        } else {
            echo "<script>alert('Username is not registered.'); window.history.back();</script>";
            exit();
        }
        $stmt->close();
    }

    // Generate feedback_id
    $prefix = 'FEED';
    $table = 'feedbacks';
    $id_field = 'feedback_id';
    $feedback_id = generateID($prefix, $conn, $table, $id_field);

    // Inserting feedback data into the feedbacks table
    $sql = "INSERT INTO feedbacks (feedback_id, user_id, username, phone_number, feedback) 
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $feedback_id, $user_id, $username, $phone, $review);

    if ($stmt->execute()) {
        echo "<script>alert('Feedback submitted successfully!'); window.location.href = 'feedbacks.php';</script>";
        exit(); // Stop further execution
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

// Close connection
mysqli_close($conn);
?>
