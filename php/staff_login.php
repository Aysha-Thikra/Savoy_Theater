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

    // Check if the form is submitted for sign in
    if (isset($_POST['signin'])) {
        $username = test_input($_POST['username']);
        $password = test_input($_POST['password']);

        $stmt = $conn->prepare("SELECT user_id, username, phone_number, password FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($user_id, $db_username, $phone_number, $hashed_password);
            $stmt->fetch();

            if (password_verify($password, $hashed_password)) {
                $_SESSION['user_id'] = $user_id;
                $_SESSION['username'] = $db_username;
                $_SESSION['phone_number'] = $phone_number;
                header("Location: staff-dashboard.php");
                exit();
            } else {
                $loginError = "Invalid username or password.";
            }
        } else {
            $loginError = "Invalid username or password.";
        }

        $stmt->close();
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
    <title>Sign in</title>
    <link rel="icon" type="image/x-icon" href="../image/faviconsav.ico">
</head>
<body>
<div class="container">
    <div class="forms-container">
        <div class="signin-signup">
            <!-- Sign-up form -->
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="sign-up-form">

                <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signup']) && $signupSuccess): ?>
                    <!-- Display sign-up success message -->
                    <div class="alert alert-success" role="alert" style="margin-top: 10px; color: azure; background-color: #181616; padding: 10px; border-radius: 0px 20px 0px 20px;">
                        Sign up successful! Please login to continue.
                    </div>
                <?php elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signup']) && !$signupSuccess): ?>
                    <!-- Display sign-up error message -->
                    <div class="alert alert-danger" role="alert" style="margin-top: 10px; color: azure; background-color: #181616; padding: 10px; border-radius: 0px 20px 0px 20px;">
                        <?php echo $signupError; ?>
                    </div>
                <?php endif; ?>
            </form>

            <!-- Sign-in form -->
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="sign-in-form">
                <h2 class="title">Sign in</h2>

                <div class="input-field">
                    <i class="fas fa-user"></i>
                    <input type="text" placeholder="Username" name="username" required />
                </div>

                <div class="input-field">
                    <i class="fas fa-lock"></i>
                    <input type="password" placeholder="Password" name="password" required />
                </div>

                <input type="submit" value="Login" class="btn solid" name="signin" />

                <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signin']) && !empty($loginError)): ?>
                    <!-- Display login error message -->
                    <div class="alert alert-danger mt-3"><?php echo $loginError; ?></div>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <div class="panels-container">
        <div class="panel left-panel">
            <div class="content">
                <h3>Hi there !</h3>
                <p>Welcome back! Please log in to access your account and continue where you left off.</p>
            </div>
            <img src="../image/savoy.png" class="image" alt="" />
        </div>
        </div>
    </div>
</div>
</body>
</html>
