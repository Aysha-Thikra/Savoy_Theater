<?php
    session_start();

    if (!isset($_SESSION['user_id'])) {
        header("Location: member_login.php");
        exit();
    }

    $user_id = $_SESSION['user_id'];
    $username = $_SESSION['username'];

    include 'db_connection.php';

    // Initialize variables
    $movie_name = "";
    $release_date = "";
    $duration = "";
    $rating = "";
    $trailer_url = "";
    $movie_category = "";
    $start_time = "N/A";
    $end_time = "N/A";
    $start_date = "N/A";
    $end_date = "N/A";
    $poster_path = "";

    // Check if movie name is selected from the dropdown menu
    if(isset($_GET['movie_id'])) {
        $movie_id = $_GET['movie_id'];

        // Fetch movie details based on the movie_id
        $movie_query = "SELECT * FROM movie WHERE movie_id = '$movie_id'";
        $result = mysqli_query($conn, $movie_query);

        if(mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $movie_name = $row["movie_name"];
            $release_date = $row["release_date"];
            $duration = $row["duration"];
            $rating = $row["rating"];
            $trailer_url = $row["trailer_url"];
            $movie_category = $row["movie_category"];
            $poster_path = $row["movie_poster"];

            // Fetch show details
            $show_query = "SELECT * FROM shows WHERE movie_id = '$movie_id'";
            $show_result = mysqli_query($conn, $show_query);

            if(mysqli_num_rows($show_result) > 0) {
                $show_row = mysqli_fetch_assoc($show_result);
                $start_date = $show_row["start_date"];
                $end_date = $show_row["end_date"];
                $start_time = $show_row["start_time"];
                $end_time = $show_row["end_time"];
            } else {
                $start_time = "N/A";
                $start_date = "N/A";
            }
        } else {
            // No movie details found
            $movie_name = "No movie details found";
        }
    } else {
        // No movie selected
        $movie_name = "No movie selected";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking</title>
    <link rel="icon" type="image/x-icon" href="../image/faviconsav.ico">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g==" crossorigin="anonymous" />
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../css/member-dashboard.css">
    <link rel="stylesheet" href="../css/grid.css">
    <link rel="stylesheet" href="../css/booking.css">
    <style>
        /* Username Field Styles */
        .username-input {
            margin-top: 20px;
            text-align: center;
        }

        .username-input label {
            color: var(--text-color);
            font-size: 18px;
            margin-bottom: 10px;
            display: block;
        }

        .username-input input[type="text"] {
            padding: 15px;
            border-radius: 25px;
            border: 2px solid #c0392b;
            font-size: 16px;
            width: 25%;
            background-color: #f8f9fa;
            color: #333;
            transition: border-color 0.3s ease, background-color 0.3s ease;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .username-input input[type="text"]:focus {
            border-color: var(--main-color);
            background-color: #fff;
            outline: none;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
        }

        /* Booking Modal Styles */
    .modal {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 1; /* Sit on top */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgb(0,0,0); /* Fallback color */
        background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
    }

    /* Modal Content */
    .modal-content {
        background-color: #fefefe;
        margin: 10% auto; /* 10% from the top and centered */
        padding: 20px;
        border: 1px solid #888;
        width: 60%; /* Could be more or less, depending on screen size */
        border-radius: 10px;
        position: relative;
        color: black;
    }

    /* Close Button */
    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    /* Modal Header */
    .modal-content h2 {
        text-align: center;
    }

    /* Modal Buttons */
    .modal-buttons {
        text-align: center;
        margin-top: 20px;
    }

    .modal-buttons button {
        background-color: #c0392b;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 20px;
        cursor: pointer;
        font-size: 16px;
        transition: background-color 0.3s ease;
        margin-right: 10px;
    }

    .modal-buttons button:hover {
        background-color: #BB7F7F;
    }

    /* Search bar styling */
    .search-bar {
            display: flex;
            align-items: center;
            position: relative;
        }

        .search-bar form {
            display: flex;
            align-items: center;
            position: relative;
        }

        .search-bar input[type="text"] {
            padding: 10px;
            border-radius: 5px;
            font-size: 16px;
            outline: none;
            width: 300px;
        }

        .search-bar button {
            background-color: #c0392b;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 20px;
            cursor: pointer;
            margin-left: -55px;
            transition: background-color 0.3s ease;
        }

        .search-bar button:hover {
            background-color: #b77d76;
        }

        .search-bar input[type="text"]::placeholder {
            color: #999;
            font-style: italic;
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="nav-wrapper">
        <div class="container">
            <div class="nav">
                <a href="#" id="home-link" class="logo"><img src="../savoy.png" alt="Logo"></a>
                <div class="search-bar">
                    <form action="../php/movie-search.php" method="GET">
                        <input type="text" name="query" placeholder="Search movies..." id="search-input">
                        <button type="submit" id="search-button"><i class="bx bx-search"></i></button>
                    </form>
                </div>
                <ul class="nav-menu">
                    <li><a href="../index.php">Home</a></li>
                    <li><a href="all-movies.php">All Movies</a></li>
                    <li><a href="about-us.php">About Us</a></li>
                    <li><a href="feedbacks.php">Feedbacks</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Content Container -->
    <div id="section">
        <div class="container">
            <div class="section-header" style="margin-top: 90px;">
                Booking
            </div>

            <h1 style="margin-bottom: 10px; color: #c0392b; font-size: 40px;">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?> !</h1>
            <div>
            <a href="profile.php" class="btn btn-secondary"style="margin-bottom: 50px;"><i class="bx bx-user"></i>&nbsp;&nbsp;&nbsp;Profile</a>&nbsp;&nbsp;&nbsp;
            <a href="logout.php" class="btn btn-danger">Logout</a>
            </div>

            <!-- Movie Selection Dropdown -->
            <div class="movie-selection">
                <label for="movie-dropdown">Select a Movie:</label>
                <select id="movie-dropdown" onchange="getMovieDetails(this.value)">
                    <option value="" disabled selected>Select your option</option>
                    <?php
                        // Fetch all movies from the database
                        $movie_query = "SELECT * FROM movie";
                        $result = mysqli_query($conn, $movie_query);

                        // Loop through each movie to populate the dropdown
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<option value="' . $row['movie_id'] . '">' . $row['movie_name'] . '</option>';
                        }
                    ?>
                </select>
            </div>

            <!-- Movie Details and Poster -->
            <div class="movie-details-container">
                <div class="movie-poster">
                    <img id="movie-poster" src="../img/movie-posters/<?php echo $poster_path; ?>" alt="Movie Poster">
                </div>
                <div class="movie-info">
                    <p><strong style="color: #c0392b;">Movie Name:</strong> <span id="movie-name"><?php echo $movie_name; ?></span></p>
                    <p><strong style="color: #c0392b;">Release Date:</strong> <span id="release-date"><?php echo $release_date; ?></span></p>
                    <p><strong style="color: #c0392b;">Duration:</strong> <span id="duration"><?php echo $duration; ?></span></p>
                    <p><strong style="color: #c0392b;">Rating:</strong> <span id="rating"><?php echo $rating; ?></span></p>
                    <p><strong style="color: #c0392b;">Show Time:</strong> <span id="show-time"><?php echo $start_time . ' - '. $end_time; ?></span></p>
                    <p><strong style="color: #c0392b;">Show Date:</strong> <span id="show-date"><?php echo $start_date; ?></span></p>
                    <p><strong style="color: #c0392b;">Genre:</strong> <span id="movie-category"><?php echo $movie_category; ?></span></p>
                </div>
            </div>

                        <!-- Number of Children and Adults -->
            <div class="audience-count">
                <div>
                    <label for="num-children">Number of Children:</label>
                    <input type="number" id="num-children" name="num-children" min="0" onchange="updateNumChildren()">
                </div>
                <div>
                    <label for="num-adults">Number of Adults:</label>
                    <input type="number" id="num-adults" name="num-adults" min="0" onchange="updateNumAdults()">
                </div>
            </div>


                        <!-- Seats -->
            <div class="seats-contaidiv">
                <div class="seats" id="normal-seats">
                    <h3 style="margin-bottom: 20px; margin-top: 30px; text-align: center; font-size: 30px;">Normal Seats</h3>
                    <div class="seat-row" style="margin-bottom: 20px;"></div>
                </div>
                <div class="seats" id="odc-seats">
                    <h3 style="margin-bottom: 20px; text-align: center; font-size: 30px;">ODC Seats</h3>
                    <div class="seat-row" style="margin-bottom: 20px;"></div>
                </div>
                <div class="seats" id="balcony-seats">
                    <h3 style="margin-bottom: 20px; text-align: center; font-size: 30px;">Balcony Seats</h3>
                    <div class="seat-row" style="margin-bottom: 20px;"></div>
                </div>
            </div>
    
            </div>

              <!-- Parking Selection Dropdown -->
              <div class="parking-selection">
                <label for="parking-dropdown">Select Parking:</label>
                <select id="parking-dropdown">
                    <option value="" disabled selected>Select parking</option>
                    <option value="No Parking">No Parking</option>
                    <option value="Bike">Bike</option>
                    <option value="Car">Car</option>
                    <option value="Van">Van</option>
                </select>
            </div>

              <!-- Book Ticket Button -->
            <div class="book-ticket">
                <button onclick="openBookingModal()">Book Ticket</button>
            </div>
        </div>
    </div>

    <!-- Booking Modal -->
    <div id="booking-modal" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="closeBookingModal()">&times;</span>
                    <h2>Booking Details</h2>
                    <p><strong>Username:</strong> <span id="modal-username"></span></p>
                    <p><strong>Movie ID:</strong> <span id="modal-movie-id"></span></p>
                    <p><strong>Movie Name:</strong> <span id="modal-movie-name"></span></p>
                    <p><strong>Show Date:</strong> <span id="modal-show-date"></span></p>
                    <p><strong>Show Time:</strong> <span id="modal-show-time"></span></p>
                    <p><strong>Selected Seats:</strong> <span id="modal-selected-seats"></span></p>
                    <p><strong>Number of Children:</strong> <span id="modal-num-children"></span></p>
                    <p><strong>Number of Adults:</strong> <span id="modal-num-adults"></span></p>
                    <p><strong>Parking type:</strong> <span id="modal-parking-vehicle"></span></p>
                    <p><strong>Total Amount:</strong> Rs. <span id="modal-total-amount"></span></p>
                    <div class="modal-buttons">
                        <button onclick="payNow()">Pay Now</button>
                        <button onclick="closeBookingModal()">Cancel</button>
                    </div>
                </div>
            </div>


    <!-- FOOTER SECTION -->
    <footer class="section">
        <div class="container">
            <div class="row">
                <div class="col-4 col-md-6 col-sm-12">
                    <img src="../savoy.png" alt="" class="logo">
                    <div class="content">
                        <p style="text-align: justify;">
                        Savoy Theater has been a hallmark of cinematic excellence since its inception. We are dedicated to providing an exceptional movie-going experience                        , showcasing the latest blockbusters, timeless classics, and indie gems. Join us for an unforgettable journey into the world of film, where every visit is a celebration of storytelling and artistry.
                        </p>
                        <div class="social-list">
                            <a href="#" class="social-item">
                                <i class="bx bxl-facebook"></i>
                            </a>
                            <a href="#" class="social-item">
                                <i class="bx bxl-twitter"></i>
                            </a>
                            <a href="#" class="social-item">
                                <i class="bx bxl-instagram"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-8 col-md-6 col-sm-12">
                    <div class="row">
                        <div class="col-3 col-md-6 col-sm-6">
                            <div class="content">
                                <div class="logo"></div>
                                <p><b>General</b></p>
                                <ul class="footer-menu">
                                    <li><a href="#">About us</a></li>
                                    <li><a href="#">All Movies</a></li>
                                    <li><a href="#">Feedbacks</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- COPYRIGHT SECTION -->
    <div class="copyright">
        Copyright 2024 Savoy || Aysha Thikra
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw==" crossorigin="anonymous"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('content-container');

            function loadPage(url) {
                fetch(url)
                .then(response => response.text())
                .then(html => {
                    container.innerHTML = html;
                })
                .catch(error => {
                    console.error('Error loading page:', error);
                });
            }

            // Add event listeners to navigation links
            document.getElementById('home-link').addEventListener('click', function(event) {
                event.preventDefault();
                loadPage('.../index.php');
            });

            document.getElementById('movies-link').addEventListener('click', function(event) {
                event.preventDefault();
                loadPage('all-movies.php');
            });

            document.getElementById('about-link').addEventListener('click', function(event) {
                event.preventDefault();
                loadPage('about-us.php');
            });

            document.getElementById('feedbacks-link').addEventListener('click', function(event) {
                event.preventDefault();
                loadPage('feedbacks.php');
            });

            document.getElementById('search-button').addEventListener('click', function(event) {
                event.preventDefault();
                let query = document.getElementById('search-input').value;
                alert('Search feature not implemented yet. You searched for: ' + query);
            });
        });

        function getMovieDetails(movieId) {
            // Make an AJAX request to retrieve movie details
            $.ajax({
                type: 'GET',
                url: 'booking.php?movie_id=' + movieId,
                success: function(data) {
                    $('#section').html(data);
                }
            });
        }
    </script>
    <script>
        // Embed PHP variables into JavaScript
        var userId = "<?php echo $user_id; ?>";
        var username = "<?php echo htmlspecialchars($username, ENT_QUOTES, 'UTF-8'); ?>";

        // Global variables to store the number of children and adults
        var numChildren = 0;
        var numAdults = 0;
        var selectedSeatNumbers = [];
        
        

                // Function to create seats dynamically
        function createSeats(container, seatType, count) {
            var seatRow = container.find('.seat-row');
            for (var i = 1; i <= count; i++) {
                var seat = $('<div>', {
                    class: 'seat ' + seatType + '-seat',
                    text: seatType + i
                }).click(function() {
                    toggleSeatSelection($(this));
                });
                seatRow.append(seat);
            }
        }

        // Call the function to create seats
        $(document).ready(function() {
            createSeats($('#normal-seats'), 'N', 150);
            createSeats($('#odc-seats'), 'ODC', 150);
            createSeats($('#balcony-seats'), 'B', 200);
        });

        // Function to toggle seat selection
        function toggleSeatSelection(seat) {
            if (numChildren === 0 && numAdults === 0) {
                alert("Please enter the number of children and adults first.");
                return;
            }

            if (selectedSeatNumbers.length >= 10 && !seat.hasClass('selected')) {
                alert("You can only book up to 10 seats at a time.");
                return;
            }

            if (seat.hasClass('selected')) {
                seat.removeClass('selected');
                var index = selectedSeatNumbers.indexOf(seat.text());
                if (index > -1) {
                    selectedSeatNumbers.splice(index, 1);
                }
            } else {
                var totalSeats = numChildren + numAdults;
                if (selectedSeatNumbers.length < totalSeats) {
                    seat.addClass('selected');
                    selectedSeatNumbers.push(seat.text());
                } else {
                    alert('You can only select ' + totalSeats + ' seats.');
                }
            }

            console.log(selectedSeatNumbers);
        }

        // Dummy book ticket function (you can replace it with actual booking logic)
        function bookTicket() {
            var selectedSeats = document.querySelectorAll('.seat.selected');
            var selectedSeatNumbers = [];
            selectedSeats.forEach(function(seat) {
                selectedSeatNumbers.push(seat.textContent);
            });
            alert('Selected seats: ' + selectedSeatNumbers.join(', '));
        }

        function updateNumChildren() {
            numChildren = parseInt(document.getElementById('num-children').value) || 0;
            if (numChildren + numAdults > 10) {
                alert('Total count of children and adults cannot exceed 10.');
                return;
            }
            updateTotalSeats();
        }

        // Function to update the number of adults
        function updateNumAdults() {
            numAdults = parseInt(document.getElementById('num-adults').value) || 0;
            if (numChildren + numAdults > 10) {
                alert('Total count of children and adults cannot exceed 10.');
                return;
            }
            updateTotalSeats();
        }

        // Function to open the booking modal
        function openBookingModal() {
            console.log("Opening booking modal...");
            var movieName = document.getElementById("movie-name").textContent;
            var showDate = document.getElementById("show-date").textContent;
            var showTime = document.getElementById("show-time").textContent;
            var selectedSeats = document.querySelectorAll(".seat.selected").length;
            var totalAmount = calculateTotalAmount(selectedSeatNumbers.length);
            var parkingVehicle = document.getElementById("parking-dropdown").value;
            var username = "<?php echo htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8'); ?>";

            // AJAX request to fetch movie ID based on the movie name
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "get_movie_id.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var movieId = this.responseText;
                    document.getElementById("modal-username").textContent = username; 
                    document.getElementById("modal-movie-id").textContent = movieId;
                    document.getElementById("modal-movie-name").textContent = movieName;
                    document.getElementById("modal-show-date").textContent = showDate;
                    document.getElementById("modal-show-time").textContent = showTime;
                    document.getElementById("modal-selected-seats").textContent = selectedSeatNumbers.join(', ');
                    document.getElementById("modal-num-children").textContent = numChildren;
                    document.getElementById("modal-num-adults").textContent = numAdults;
                    document.getElementById("modal-parking-vehicle").textContent = parkingVehicle;
                    document.getElementById("modal-total-amount").textContent = totalAmount;

                    var modal = document.getElementById("booking-modal");
                    modal.style.display = "block";
                }
            };
            xhr.send("movieName=" + movieName);
        }



        // Function to close the booking modal
        function closeBookingModal() {
            var modal = document.getElementById("booking-modal");
            modal.style.display = "none";
        }

        // Function to calculate the total amount
        function calculateTotalAmount(selectedSeats) {
            var childPrice = 500;
            var adultPrice = 1000;
            var parkingPrice = 0;

            // Retrieve the selected parking value
            var parking = document.getElementById('parking-dropdown').value;

            // Assign the parking price based on the selected parking
            switch (parking) {
                case 'Bike':
                    parkingPrice = 50;
                    break;
                case 'Car':
                    parkingPrice = 100;
                    break;
                case 'Van':
                    parkingPrice = 150;
                    break;
                default:
                    parkingPrice = 0; // No parking selected
            }

            // Calculate the total price
            var totalAmount = (numChildren * childPrice) + (numAdults * adultPrice) + parkingPrice;
            return totalAmount;
        }
        // Function to handle payment
        function payNow() {
            var username = "<?php echo htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8'); ?>"; // Get username from PHP session
            var movieName = document.getElementById("modal-movie-name").textContent;
            var showDate = document.getElementById("modal-show-date").textContent;
            var showTime = document.getElementById("modal-show-time").textContent;
            var numChildren = document.getElementById("modal-num-children").textContent;
            var numAdults = document.getElementById("modal-num-adults").textContent;
            var totalAmount = document.getElementById("modal-total-amount").textContent;
            var parking = document.getElementById("parking-dropdown").value;

            // Get selected seats
            var selectedSeats = [];
            $(".seat.selected").each(function() {
                selectedSeats.push($(this).text().trim()); // Extract the seat number as string without the 'N' prefix
            });

            // Log the details for debugging purposes
            console.log("Username:", username);
            console.log("Movie Name:", movieName);
            console.log("Show Date:", showDate);
            console.log("Show Time:", showTime);
            console.log("Number of Children:", numChildren);
            console.log("Number of Adults:", numAdults);
            console.log("Parking:", parking);
            console.log("Total Amount:", totalAmount);
            console.log("Selected Seats:", selectedSeats);

            // Save booking details
            saveBooking(username, movieName, showDate, showTime, numChildren, numAdults, parking, totalAmount, selectedSeats);
        }

        // Function to save booking details
        function saveBooking(username, movieName, showDate, showTime, numChildren, numAdults, parking, totalAmount, selectedSeats) {
            // AJAX request to save booking details
            $.ajax({
                type: 'POST',
                url: 'save_booking.php',
                data: {
                    username: username,
                    movieName: movieName,
                    showDate: showDate,
                    showTime: showTime,
                    numChildren: numChildren,
                    numAdults: numAdults,
                    parking: parking,
                    totalAmount: totalAmount,
                    seats: selectedSeats.join(", ") // Convert selected seats array to a comma-separated string
                },
                success: function(response) {
                    console.log(response); // Log the response for debugging purposes
                    // Handle the response accordingly
                    alert(response);
                    closeBookingModal(); // Close the modal after booking
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
</script>



    

</body>
</html>
