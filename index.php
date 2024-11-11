<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Savoy </title>
    <link rel="icon" type="image/x-icon" href="image/faviconsav.ico">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g==" crossorigin="anonymous" />
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/grid.css">
    <link rel="stylesheet" href="css/member-dashboard.css">
    <style>
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

    <!-- nav -->
    <div class="nav-wrapper">
        <div class="container">
            <div class="nav">
                <img src="savoy.png" alt="" class="logo">
                <div class="search-bar">
                    <form action="php/movie-search.php" method="GET">
                        <input type="text" name="query" placeholder="Search movies..." id="search-input">
                        <button type="submit" id="search-button"><i class="bx bx-search"></i></button>
                    </form>
                </div>
                <ul class="nav-menu" id="nav-menu">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="php/all-movies.php">All Movies</a></li>
                    <li><a href="php/about-us.php">About Us</a></li>
                    <li><a href="php/feedbacks.php">Feedbacks</a></li>
                    <li>
                        <a href="php/booking.php" class="btn btn-hover">
                            <span>Book Now</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- HERO SECTION -->
<div class="hero-section">
    <div class="hero-slide">
        <div class="owl-carousel carousel-nav-center" id="hero-carousel">
            <?php
            // Directory containing the banner images
            $bannerDir = "img/banner-posters/";

            // Get all files from the banner directory
            $bannerImages = glob($bannerDir . "*.{jpg,jpeg,png,gif}", GLOB_BRACE);

            // Loop through the images and display them in the slider
            foreach ($bannerImages as $image) {
                echo '<div class="hero-slide-item">';
                echo '<img src="' . $image . '" alt="">';
                echo '<div class="overlay"></div>';
                echo '</div>';
            }
            ?>
        </div>
    </div>
</div>


    <!-- all movies section -->
    <div class="section">
        <div class="container">
            <div class="section-header">
                All Movies
            </div>
            <div class="movies-slide carousel-nav-center owl-carousel">
            <?php
                include 'php/db_connection.php';

                // Query to fetch all movies 
                $sql = "SELECT * FROM movie";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    // Output data of each row
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<a href="php/movie-details.php?movie_id=' . $row['movie_id'] . '" class="movie-item">';
                        echo '<img src="img/movie-posters/' . $row["movie_poster"] . '" alt="">';
                        echo '<div class="movie-item-content">';
                        echo '<div class="movie-item-title">' . $row["movie_name"] . '</div>';
                        echo '<div class="movie-infos">';
                        echo '<div class="movie-info">';
                        echo '<i class="bx bxs-star"></i>';
                        echo '<span>' . $row["rating"] . '</span>';
                        echo '</div>';
                        echo '<div class="movie-info">';
                        echo '<i class="bx bxs-time"></i>';
                        echo '<span>' . $row["duration"] . '</span>';
                        echo '</div>';
                        echo '<div class="movie-info">';
                        echo '<span>' ."HD". '</span>';
                        echo '</div>';
                        echo '<div class="movie-info">';
                        echo '<span>' . "+16" . '</span>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                        echo '</a>';
                    }
                } else {
                    echo "<p>No movies found</p>";
                }

                mysqli_close($conn);
                ?>
                
            </div>
        </div>
    </div>

    <!-- Now Showing movies section -->
    <div class="section">
        <div class="container">
            <div class="section-header">
                Now Showing
            </div>
            <div class="movies-slide carousel-nav-center owl-carousel">
                <?php
                include 'php/db_connection.php';

                // Query to fetch movies with status 'Now Showing'
                $sql = "SELECT * FROM movie WHERE movie_status = 'Now Showing'";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    // Output data of each row
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<a href="php/movie-details.php?movie_id=' . $row['movie_id'] . '" class="movie-item">';
                        echo '<img src="img/movie-posters/' . $row["movie_poster"] . '" alt="">';
                        echo '<div class="movie-item-content">';
                        echo '<div class="movie-item-title">' . $row["movie_name"] . '</div>';
                        echo '<div class="movie-infos">';
                        echo '<div class="movie-info">';
                        echo '<i class="bx bxs-star"></i>';
                        echo '<span>' . $row["rating"] . '</span>';
                        echo '</div>';
                        echo '<div class="movie-info">';
                        echo '<i class="bx bxs-time"></i>';
                        echo '<span>' . $row["duration"] . '</span>';
                        echo '</div>';
                        echo '<div class="movie-info">';
                        echo '<span>' ."HD". '</span>';
                        echo '</div>';
                        echo '<div class="movie-info">';
                        echo '<span>' . "+16" . '</span>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                        echo '</a>';
                    }
                } else {
                    echo "<p>No movies found</p>";
                }

                mysqli_close($conn);
                ?>
                
            </div>
        </div>
    </div>

    <!-- Upcoming movies section -->
    <div class="section">
        <div class="container">
            <div class="section-header">
                Upcoming movies
            </div>
            <div class="movies-slide carousel-nav-center owl-carousel">
            <?php
                include 'php/db_connection.php';

                // Query to fetch movies with status 'Upcoming Showing'
                $sql = "SELECT * FROM movie WHERE movie_status = 'Upcoming movies'";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    // Output data of each row
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<a href="php/movie-details.php?movie_id=' . $row['movie_id'] . '" class="movie-item">';
                        echo '<img src="img/movie-posters/' . $row["movie_poster"] . '" alt="">';
                        echo '<div class="movie-item-content">';
                        echo '<div class="movie-item-title">' . $row["movie_name"] . '</div>';
                        echo '<div class="movie-infos">';
                        echo '<div class="movie-info">';
                        echo '<i class="bx bxs-star"></i>';
                        echo '<span>' . $row["rating"] . '</span>';
                        echo '</div>';
                        echo '<div class="movie-info">';
                        echo '<i class="bx bxs-time"></i>';
                        echo '<span>' . $row["duration"] . '</span>';
                        echo '</div>';
                        echo '<div class="movie-info">';
                        echo '<span>' ."HD". '</span>';
                        echo '</div>';
                        echo '<div class="movie-info">';
                        echo '<span>' . "+16" . '</span>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                        echo '</a>';
                    }
                } else {
                    echo "<p>No movies found</p>";
                }

                mysqli_close($conn);
                ?>
            </div>
        </div>
    </div>


    <!-- Footer Section -->
    <footer class="section">
        <div class="container">
            <div class="row">
                <div class="col-4 col-md-6 col-sm-12">
                    <img src="savoy.png" alt="" class="logo">
                    <div class="content">
                        <p style="text-align: justify;">
                        Savoy Theater has been a hallmark of cinematic excellence since its inception. We are dedicated to providing an exceptional movie-going experience, showcasing the latest blockbusters, timeless classics, and indie gems. Join us for an unforgettable journey into the world of film, where every visit is a celebration of storytelling and artistry.
                        </p>
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
                                    <li><a href="php/about-us.php">About us</a></li>
                                    <li><a href="php/all-movies.php">All Movies</a></li>
                                    <li><a href="php/feedbacks.php">Feedbacks</a></li>
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
        Copyright 2024 Savoy || Aysha Thikra</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw==" crossorigin="anonymous"></script>
    <script src="js/member-dashboard.js"></script>
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
                loadPage('php/index.php');
            });

            document.getElementById('movies-link').addEventListener('click', function(event) {
                event.preventDefault();
                loadPage('php/all-movies.php');
            });

            document.getElementById('about-link').addEventListener('click', function(event) {
                event.preventDefault();
                loadPage('php/about-us.php');
            });

            document.getElementById('feedbacks-link').addEventListener('click', function(event) {
                event.preventDefault();
                loadPage('php/feedbacks.php');
            });

            // Add event listener to "Book Now" button
            document.getElementById('book-now-btn').addEventListener('click', function(event) {
                event.preventDefault();
                loadPage('php/booking.php');
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