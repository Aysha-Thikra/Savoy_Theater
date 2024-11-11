<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedbacks</title>
    <link rel="icon" type="image/x-icon" href="img/faviconsav.ico">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g==" crossorigin="anonymous" />
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../css/member-dashboard.css">
    <link rel="stylesheet" href="../css/grid.css">

    <style>
        .write-review-btn {
            background-color: #c0392b;
            color: #ffffff;
            padding: 10px 20px;
            border: none;
            border-radius: 20px;
            cursor: pointer;
        }

        .feedback-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .feedback-card {
            background-color: #ffffff;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            width: calc(50% - 20px);
            padding: 20px;
            position: relative;
            overflow: hidden;
            margin-top: 20px;
        }

        .feedback-card:before {
            content: '';
            position: absolute;
            top: -50px;
            right: -50px;
            width: 200px;
            height: 200px;
            background-color: #751313;
            border-radius: 50%;
            z-index: 0;
        }

        .feedback-card:after {
            content: '';
            position: absolute;
            bottom: -50px;
            left: -50px;
            width: 200px;
            height: 200px;
            background-color: #751313;
            border-radius: 50%;
            z-index: 0;
        }

        .profile-img {
            position: relative;
            background-color: #ffffff;
            border: 3px solid #751313;
            border-radius: 50%;
            width: 80px;
            height: 80px;
            overflow: hidden;
            margin-bottom: 10px;
            z-index: 1;
            float: left;
            margin-right: 20px;
        }

        .profile-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .client-info {
            overflow: hidden;
            z-index: 1;
            position: relative;
            margin-left: 100px;
        }

        .client-name {
            font-weight: bold;
            font-size: 20px;
            color: #333333;
        }

        .rating {
            display: flex;
            align-items: center;
            margin: 10px 0;
        }

        .stars {
            color: #ffab00;
            font-size: 20px;
        }

        .testimonial {
            font-size: 16px;
            color: black;
            background: #f0f4f8;
            padding: 15px;
            border-radius: 10px;
            position: relative;
            z-index: 1;
            clear: both;
            font-style: italic;
        }

        .quotes {
            color: #f0f4f8;
            font-size: 40px;
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 1;
        }

        @media (max-width: 600px) {
            .feedback-card {
                width: 100%;
            }
            .profile-img {
                width: 60px;
                height: 60px;
            }
            .client-name {
                font-size: 18px;
            }
            .stars {
                font-size: 18px;
            }
            .testimonial {
                font-size: 14px;
            }
            .client-info {
                margin-left: 80px;
            }
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
                    <form action="movie-search.php" method="GET">
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
                <a href="booking.php" class="btn btn-hover">Book Now</a>
            </div>
        </div>
    </nav>

    <!-- Content Container -->
    <div id="section">
        <div class="container">
            <div class="section-header" style="margin-top: 40px;">
                Feedbacks
            </div>
            <div class="col-12 col-md-6">
                <button class="write-review-btn" onclick="window.location.href='write-review.php';">Write a Review</button>
            </div>
            <div class="feedback-container">
                <?php
                $servername = "localhost";
                $username = "root";
                $password = "";
                $database = "savoy";

                $conn = mysqli_connect($servername, $username, $password, $database);

                // Check connection
                if (!$conn) {
                    die("Connection failed: " . mysqli_connect_error());
                }

                // Fetching feedbacks from the database
                $sql = "SELECT username, feedback FROM feedbacks";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    // Output data of each row
                    while($row = mysqli_fetch_assoc($result)) {
                        echo "<div class='feedback-card'>
                                <div class='profile-img'>
                                    <img src='../img/client.png' alt='Profile Image'>
                                </div>
                                <div class='client-info'>
                                    <div class='client-name'>".$row['username']."</div>
                                    <div class='rating'>
                                        <div class='stars'>★★★★☆</div>
                                    </div>
                                </div>
                                <div class='testimonial'>“  ".$row['feedback'].  "”</div>
                                <div class='quotes'>“ “</div>
                            </div>";
                    }
                } else {
                    echo "<p>No feedbacks yet.</p>";
                }

                // Close connection
                mysqli_close($conn);
                ?>
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
                            Savoy Theater has been a hallmark of cinematic excellence since its inception. We are dedicated to providing an exceptional movie-going experience, showcasing the latest blockbusters, timeless classics, and indie gems. Join us for an unforgettable journey into the world of film, where every visit is a celebration of storytelling and artistry.
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
                loadPage('../index.php');
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

            // Add event listener to "Book Now" button
            document.getElementById('book-now-btn').addEventListener('click', function(event) {
                event.preventDefault();
                loadPage('booking.php');
            });

            document.getElementById('search-button').addEventListener('click', function(event) {
                event.preventDefault();
                let query = document.getElementById('search-input').value;
                alert('Search feature not implemented yet. You searched for: ' + query);
            });
        });
    </script>

</body>
</html>
