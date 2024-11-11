<?php
session_start();

// Database connection variables
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "savoy";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Initialize variables for form validation
$firstNameErr = $lastNameErr = $usernameErr = $mobileNumberErr = $emailErr = $passwordErr = $confirmPasswordErr = "";
$firstName = $lastName = $username = $mobileNumber = $email = $password = $confirmPassword = "";
$signupSuccess = $signupError = $loginError = "";

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the form is submitted for sign up
    if (isset($_POST['signup'])) {
        // Validate and sanitize form data
        $firstName = test_input($_POST['firstName']);
        if (empty($firstName)) {
            $firstNameErr = "First name is required";
        } elseif (!preg_match("/^[a-zA-Z-' ]*$/", $firstName)) {
            $firstNameErr = "Only letters and white space allowed";
        }

        $lastName = test_input($_POST['lastName']);
        if (empty($lastName)) {
            $lastNameErr = "Last name is required";
        } elseif (!preg_match("/^[a-zA-Z-' ]*$/", $lastName)) {
            $lastNameErr = "Only letters and white space allowed";
        }

        $username = test_input($_POST['username']);
        if (empty($username)) {
            $usernameErr = "Username is required";
        } else {
            // Check if the username already exists
            $checkUsernameSql = "SELECT * FROM users WHERE username = '$username'";
            $result = mysqli_query($conn, $checkUsernameSql);
            if (mysqli_num_rows($result) > 0) {
                $usernameErr = "Username already exists. Try another.";
            }
        }

        $mobileNumber = test_input($_POST['mobileNumber']);
        if (empty($mobileNumber)) {
            $mobileNumberErr = "Mobile number is required";
        }

        $email = test_input($_POST['email']);
        if (empty($email)) {
            $emailErr = "Email is required";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }

        $password = test_input($_POST['password']);
        if (empty($password)) {
            $passwordErr = "Password is required";
        } elseif (strlen($password) < 8) {
            $passwordErr = "Password must be at least 8 characters";
        } elseif (!preg_match("/[A-Z]+/", $password)) {
            $passwordErr = "Password must contain at least one capital letter";
        } elseif (!preg_match("/[0-9]+/", $password)) {
            $passwordErr = "Password must contain at least one number";
        } elseif (!preg_match("/\W+/", $password)) {
            $passwordErr = "Password must contain at least one special character";
        }

        $confirmPassword = test_input($_POST['confirmPassword']);
        if (empty($confirmPassword)) {
            $confirmPasswordErr = "Confirm password is required";
        } elseif ($password !== $confirmPassword) {
            $confirmPasswordErr = "Passwords do not match";
        }

        // If there are no errors, proceed with sign-up
        if (empty($firstNameErr) && empty($lastNameErr) && empty($usernameErr) && empty($mobileNumberErr) && empty($emailErr) && empty($passwordErr) && empty($confirmPasswordErr)) {
            // Fetch the highest existing customer_id
            $result = $conn->query("SELECT user_id FROM users ORDER BY user_id DESC LIMIT 1");
            $new_user_id = "c00001";
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $last_id = $row['user_id'];
                $num = (int)substr($last_id, 1) + 1;
                $new_user_id = "c" . str_pad($num, 5, "0", STR_PAD_LEFT);
            }

            // Set user category
            $cat = 3;

            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insert user data into the database
            $sql = "INSERT INTO users (user_id, first_name, last_name, username, phone_number, email, password, user_category) 
                    VALUES ('$new_user_id', '$firstName', '$lastName', '$username', '$mobileNumber', '$email', '$hashedPassword', '$cat')";

            if (mysqli_query($conn, $sql)) {
                // Sign-up success message
                $signupSuccess = true;
                echo "<script>
                        alert('Registration successful!');
                        window.location.href = 'staff_registration.php';
                      </script>";
            } else {
                // Sign-up error message
                $signupError = "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
        }
    }
}


$conn->close();

// Function to sanitize and validate input data
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/member_login.css" />
    <title>Sign in & Sign up Form</title>
    <link rel="icon" type="image/x-icon" href="../image/faviconsav.ico">
    <script>
        // Client-side validation
        function validateForm() {
            let valid = true;

            // First name validation
            let firstName = document.forms["signupForm"]["firstName"].value;
            if (firstName === "") {
                alert("First name is required");
                valid = false;
            } else if (!/^[a-zA-Z-' ]*$/.test(firstName)) {
                alert("Only letters and white space allowed for first name");
                valid = false;
            }

            // Last name validation
            let lastName = document.forms["signupForm"]["lastName"].value;
            if (lastName === "") {
                alert("Last name is required");
                valid = false;
            } else if (!/^[a-zA-Z-' ]*$/.test(lastName)) {
                alert("Only letters and white space allowed for last name");
                valid = false;
            }

            let username = document.forms["signupForm"]["username"].value;
            if (username === "") {
                alert("Username is required");
                valid = false;
            } else if (/[^a-zA-Z0-9]/.test(username)) {
                alert("Username should only contain alphanumeric characters");
                valid = false;
            }

            // Mobile number validation
            let mobileNumber = document.forms["signupForm"]["mobileNumber"].value;
            if (mobileNumber === "") {
                alert("Mobile number is required");
                valid = false;
            }

            // Email validation
            let email = document.forms["signupForm"]["email"].value;
            if (email === "") {
                alert("Email is required");
                valid = false;
            } else if (!/\S+@\S+\.\S+/.test(email)) {
                alert("Invalid email format");
                valid = false;
            }

            // Password validation
            let password = document.forms["signupForm"]["password"].value;
            if (password === "") {
                alert("Password is required");
                valid = false;
            } else if (password.length < 8) {
                alert("Password must be at least 8 characters");
                valid = false;
            } else if (!/[A-Z]/.test(password)) {
                alert("Password must contain at least one capital letter");
                valid = false;
            } else if (!/[0-9]/.test(password)) {
                alert("Password must contain at least one number");
                valid = false;
            } else if (!/\W/.test(password)) {
                alert("Password must contain at least one special character");
                valid = false;
            }

            // Confirm password validation
            let confirmPassword = document.forms["signupForm"]["confirmPassword"].value;
            if (confirmPassword === "") {
                alert("Confirm password is required");
                valid = false;
            } else if (password !== confirmPassword) {
                alert("Passwords do not match");
                valid = false;
            }

            return valid;
        }
    </script>
</head>
<body>
<div class="container">
    <div class="forms-container">
        <div class="signin-signup">
            <!-- Sign-up form -->
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="sign-in-form" name="signupForm" onsubmit="return validateForm()">
                <h2 class="title">Sign up</h2>

                <div class="input-field">
                    <i class="fa fa-user"></i>
                    <input type="text" placeholder="First Name" name="firstName" value="<?php echo $firstName; ?>" required />
                    <span class="error"><?php echo $firstNameErr; ?></span>
                </div>

                <div class="input-field">
                    <i class="fa fa-user"></i>
                    <input type="text" placeholder="Last Name" name="lastName" value="<?php echo $lastName; ?>" required />
                    <span class="error"><?php echo $lastNameErr; ?></span>
                </div>

                <div class="input-field">
                    <i class="fa fa-user"></i>
                    <input type="text" placeholder="Username" name="username" value="<?php echo $username; ?>" required />
                    <span class="error" style="color: white;"><?php echo $usernameErr; ?></span>
                </div>

                <div class="input-field">
                    <i class="fas fa-mobile"></i>
                    <input type="text" placeholder="Mobile Number" name="mobileNumber" value="<?php echo $mobileNumber; ?>" required />
                    <span class="error"><?php echo $mobileNumberErr; ?></span>
                </div>

                <div class="input-field">
                    <i class="fas fa-envelope"></i>
                    <input type="email" placeholder="Email" name="email" value="<?php echo $email; ?>" required />
                    <span class="error"><?php echo $emailErr; ?></span>
                </div>

                <div class="input-field">
                    <i class="fas fa-lock"></i>
                    <input type="password" placeholder="Password" name="password" required />
                    <span class="error"><?php echo $passwordErr; ?></span>
                </div>

                <div class="input-field">
                    <i class="fas fa-lock"></i>
                    <input type="password" placeholder="Confirm Password" name="confirmPassword" required />
                    <span class="error"><?php echo $confirmPasswordErr; ?></span>
                </div>

                <input type="submit" class="btn" value="Sign up" name="signup" />

                <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signup']) && $signupSuccess): ?>
                    <!-- Display sign-up success message -->
                    <script>
                        alert("Registration successful!");
                        window.location.href = "staff_registration.php";
                    </script>
                <?php elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signup']) && !$signupSuccess): ?>
                    <!-- Display sign-up error message -->
                    <script>alert("<?php echo $signupError; ?>");</script>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <div class="panels-container">
        <div class="panel left-panel">
            <div class="content">
                <h3>Finished Registering Account?</h3>
                <p>Get back to the Admin Dashboard</p>
                <p>&#128071;</p>
                <button class="btn transparent" id="sign-up-btn" onclick="window.location.href='admin-dashboard.php'">Back</button>
            </div>
            <img src="../image/savoy.png" class="image" alt="" />
        </div>
    </div>
</div>
</body>
</html>
