<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="icon" type="image/x-icon" href="../image/faviconsav.ico">
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        /************ staff register button ***********/
        .staff-regi-btn {
            background-color: #751313;
            color: #fff;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-left: auto;
        }

        .staff-regi-btn:hover {
            background-color: #5b0f0f;
        }

    </style>
</head>

<body>
    <div class="sidebar">
        <div class="logo">
            <img src="../img/admin-logo/admin.png" alt="">
            <ul class="menu">
                <li>
                    <a href="#moviesSection">
                        <i class="fas fa-film"></i>
                        <span>Movies</span>
                    </a>
                </li>
                <li>
                    <a href="#castSection">
                        <i class="fas fa-users"></i>
                        <span>Cast</span>
                    </a>
                </li>
                <li>
                    <a href="#showsSection">
                        <i class="fas fa-calendar"></i>
                        <span>Shows</span>
                    </a>
                </li>
                <li>
                    <a href="#bookingsSection">
                        <i class="fas fa-ticket"></i>
                        <span>Bookings</span>
                    </a>
                </li>
                <li>
                    <a href="#feedbacksSection">
                        <i class="fas fa-comments"></i>
                        <span>Feedback</span>
                    </a>
                </li>
                <li>
                    <a href="#promotionsSection">
                        <i class="fas fa-gift"></i>
                        <span>Promotions</span>
                    </a>
                </li>
                <li class="logout">
                    <a href="../admin_login.php">
                        <i class="fa fa-sign-out"></i>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <div class="main--containor">
        <div class="header--wrapper">
            <div class="header--title">
                <span>Admin</span>
                <h2>Dashboard</h2>
            </div>

            <div class="user--info">
                <div class="search--box">
                    <form action="movie-search.php" method="GET">
                        <input type="text" name="query" placeholder="Search movies..." id="search-input">
                        <button type="submit" id="search-button"><i class="fas fa-search"></i></button>
                    </form>
                </div>
                <img src="../img/boy.jpeg" alt="">
            </div>
        </div>

        <div class="header--wrapper">
            <div class="header--title">
                <h2>Staff Account Registration</h2>
            </div>
            <button class="staff-regi-btn">Register Account</button>
        </div>

        <div class="card-body" id="moviesSection">
            <div class="movie-header-wrapper">
                <div class="movie-header">
                    <h2>
                        <i class="fas fa-film"></i> MOVIES
                    </h2>
                    <button class="add-movie-btn">Add Movie</button>
                </div>
            </div>
            
            <div class="responsive-table">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Movie ID</th>
                            <th>Movie Title</th>
                            <th>Duration</th>
                            <th>Movie Image</th>
                            <th>Movie Status</th>
                            <th>Release Date</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include 'db_connection.php';

                        // Query to fetch movie data from the database
                        $sql = "SELECT movie_id, movie_name, duration, movie_poster, movie_status, release_date FROM movie";
                        $result = mysqli_query($conn, $sql);

                        if (mysqli_num_rows($result) > 0) {
                            // Output data of each row
                            while($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . $row["movie_id"] . "</td>";
                                echo "<td>" . $row["movie_name"] . "</td>";
                                echo "<td>" . $row["duration"] . "</td>";
                                echo "<td><img src='../img/movie-posters/" . $row["movie_poster"] . "' alt='" . $row["movie_name"] . "' style='max-width: 100px;'></td>";
                                echo "<td>" . $row["movie_status"] . "</td>";
                                echo "<td>" . $row["release_date"] . "</td>";
                                echo "<td><button class='edit-btn'><i class='fas fa-edit'></i></button></td>";
                                echo "<td><button class='delete-btn' onclick=\"deleteRecord('movie', '" . $row['movie_id'] . "')\"><i class='fas fa-trash-alt'></i></button></td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='8'>No movies found</td></tr>";
                        }

                        mysqli_close($conn);
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="card-body" id="castSection">
    <div class="cast-header-wrapper">
        <div class="cast-header">
            <h2>
                <i class="fas fa-users"></i> CAST
            </h2>
            <button class="add-cast-btn">Add Cast</button>
        </div>
    </div>
    
    <div class="responsive-table">
        <table class="table table-bordered" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>Cast ID</th>
                    <th>Movie ID</th>
                    <th>Cast Name</th>
                    <th>Cast Image</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php
                        include 'db_connection.php';

                        // Query to fetch cast data from the database
                        $sql = "SELECT cast_id, movie_id, cast_name, cast_image FROM cast";
                        $result = mysqli_query($conn, $sql);

                        if (mysqli_num_rows($result) > 0) {
                            // Output data of each row
                            while($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . $row["cast_id"] . "</td>";
                                echo "<td>" . $row["movie_id"] . "</td>";
                                echo "<td>" . $row["cast_name"] . "</td>";
                                echo "<td><img src='../img/cast-images/" . $row["cast_image"] . "' alt='" . $row["cast_name"] . "' style='max-width: 100px;'></td>";
                                echo "<td><button class='edit-btn'><i class='fas fa-edit'></i></button></td>";
                                echo "<td><button class='delete-btn' onclick=\"deleteRecord('cast', '" . $row['cast_id'] . "')\"><i class='fas fa-trash-alt'></i></button></td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'>No cast found</td></tr>";
                        }

                        mysqli_close($conn);
                        ?>
            </tbody>
        </table>
    </div>
</div>


        <div class="card-body" id="showsSection">
            <div class="show-header-wrapper">
                <div class="show-header">
                    <h2>
                        <i class="fas fa-calendar"></i> SHOWS
                    </h2>
                </div>
            </div>
            
            <div class="responsive-table">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Show ID</th>
                            <th>Movie ID</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            include 'db_connection.php';

                            // Retrieve shows information from the database
                            $sql = "SELECT * FROM shows";
                            $result = mysqli_query($conn, $sql);

                            // Check if there are any shows
                            if (mysqli_num_rows($result) > 0) {
                                // Shows data exists, display it
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $show_id = $row['show_id'];
                                    $movie_id = $row['movie_id'];
                                    $start_time = $row['start_time'];
                                    $end_time = $row['end_time'];
                                    $start_date = $row['start_date'];
                                    $end_date = $row['end_date'];

                                    // Output the shows data in HTML format
                                    echo "<tr>";
                                    echo "<td>$show_id</td>";
                                    echo "<td>$movie_id</td>";
                                    echo "<td>$start_time</td>";
                                    echo "<td>$end_time</td>";
                                    echo "<td>$start_date</td>";
                                    echo "<td>$end_date</td>";
                                    echo "<td>";
                                    echo "<button class='edit-btn'>";
                                    echo "<i class='fas fa-edit'></i>";
                                    echo "</button>";
                                    echo "<td><button class='delete-btn' onclick=\"deleteRecord('show', '" . $row['show_id'] . "')\"><i class='fas fa-trash-alt'></i></button></td>";
                                    echo "</tr>";
                                }
                            } else {
                                // No shows data found
                                echo "No shows data found";
                            }

                        // Close the database connection
                        mysqli_close($conn);
                        ?>

                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-body" id="bookingsSection">
            <div class="booking-header-wrapper">
                <div class="booking-header">
                    <h2>
                        <i class="fas fa-ticket-alt"></i> BOOKING
                    </h2>
                </div>
            </div>
            
            <div class="responsive-table">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Booking ID</th>
                            <th>User ID</th>
                            <th>Movie ID</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Seats</th>
                            <th>Total Price</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include 'db_connection.php';

                        // Query to fetch booking data from the database
                        $sql = "SELECT booking_id, user_id, movie_id, date, time, seats, total_price FROM booking";
                        $result = mysqli_query($conn, $sql);

                        if (mysqli_num_rows($result) > 0) {
                            // Output data of each row
                            while($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . $row["booking_id"] . "</td>";
                                echo "<td>" . $row["user_id"] . "</td>";
                                echo "<td>" . $row["movie_id"] . "</td>";
                                echo "<td>" . $row["date"] . "</td>";
                                echo "<td>" . $row["time"] . "</td>";
                                echo "<td>" . $row["seats"] . "</td>";
                                echo "<td>" . $row["total_price"] . "</td>";
                                echo "<td><button class='edit-btn'><i class='fas fa-edit'></i></button></td>";
                                echo "<td><button class='delete-btn' onclick=\"deleteRecord('booking', '" . $row['booking_id'] . "')\"><i class='fas fa-trash-alt'></i></button></td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='8'>No bookings found</td></tr>";
                        }

                        mysqli_close($conn);
                        ?>
                    </tbody>
                </table>
            </div>
        </div>


        <div class="card-body" id="feedbacksSection">
            <div class="feedback-header-wrapper">
                <div class="feedback-header">
                    <h2>
                        <i class="fas fa-comments"></i> FEEDBACKS
                    </h2>
                </div>
            </div>
            
            <div class="responsive-table">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Feedback ID</th>
                            <th>User ID</th>
                            <th>Comments</th>
                            <th>Phone Number</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            include 'db_connection.php';

                            // Query to fetch feedback data from the database
                            $sql = "SELECT feedback_id, user_id, feedback, phone_number FROM feedbacks";
                            $result = mysqli_query($conn, $sql);

                            if (mysqli_num_rows($result) > 0) {
                                // Output data of each row
                                while($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td>" . $row["feedback_id"] . "</td>";
                                    echo "<td>" . $row["user_id"] . "</td>";
                                    echo "<td>" . $row["feedback"] . "</td>";
                                    echo "<td>" . $row["phone_number"] . "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='4'>No feedbacks found</td></tr>";
                            }

                            mysqli_close($conn);
                        ?>
                    </tbody>
                </table>
            </div>
        </div>


        <div class="card-body" id="promotionsSection">
            <div class="promotion-header-wrapper">
                <div class="promotion-header">
                    <h2>
                        <i class="fas fa-gift"></i> PROMOTIONS
                    </h2>
                    <button class="add-promotion-btn">Add Promotion</button>
                </div>
            </div>
            
            <div class="responsive-table">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Banner ID</th>
                            <th>Banner Poster</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            include 'db_connection.php';

                            // Query to fetch banner data from the database
                            $sql = "SELECT banner_id, banner_poster FROM banner";
                            $result = mysqli_query($conn, $sql);

                            if (mysqli_num_rows($result) > 0) {
                                // Output data of each row
                                while($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td>" . $row["banner_id"] . "</td>";
                                    echo "<td><img src='../img/banner-posters/" . $row["banner_poster"] . "' alt='Banner Poster' style='max-width: 100px;'></td>";
                                    echo "<td><button class='edit-btn'><i class='fas fa-edit'></i></button></td>";
                                    echo "<td><button class='delete-btn' onclick=\"deleteRecord('promotion', '" . $row['banner_id'] . "')\"><i class='fas fa-trash-alt'></i></button></td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='4'>No promotions found</td></tr>";
                            }

                            mysqli_close($conn);
                        ?>
                    </tbody>
                </table>
            </div>
        </div>



               <!-- Add your footer here -->
        <div class="card-body">
                <div class="footer">
                    <div class="social-icons">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                    </div>
                    <p>&copy; 2024 Savoy || By Aysha Thikra . All rights reserved.</p>
                </div>
            </div>
        </div>

    <script>
        document.querySelector('.staff-regi-btn').addEventListener('click', function() {
            window.location.href = 'staff_registration.php';
        });
    </script>
    <script>
        document.querySelector('.add-movie-btn').addEventListener('click', function() {
            window.location.href = 'add-movie.php';
        });
    </script>
    <script>
        document.querySelector('.add-cast-btn').addEventListener('click', function() {
            window.location.href = 'add-cast.php';
        });
    </script>
    <script>
        document.querySelector('.add-promotion-btn').addEventListener('click', function() {
            window.location.href = 'add-promotion.php';
        });
    </script>
    <script>
        function deleteRecord(type, id) {
            if (confirm('Are you sure you want to delete this record?')) {
                const xhr = new XMLHttpRequest();
                xhr.open("POST", "delete.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        alert(xhr.responseText);
                        location.reload(); // Reload the page to reflect changes
                    } else if (xhr.readyState === 4) {
                        alert('Error deleting record');
                    }
                };

                xhr.send("type=" + type + "&id=" + id);
            }
        }
    </script>


</body>
</html>
