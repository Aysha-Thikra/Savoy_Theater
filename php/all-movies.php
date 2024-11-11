<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Movies</title>
    <link rel="icon" type="image/x-icon" href="../image/faviconsav.ico">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g==" crossorigin="anonymous" />
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../css/member-dashboard.css">
    <link rel="stylesheet" href="../css/grid.css">
    <style>
        /* Add this CSS code at the end of your CSS file */
        .movies-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            grid-gap: 20px;
        }

        .movie-item {
            text-decoration: none;
            color: white;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            overflow: hidden;
            transition: transform 0.3s ease;
            margin-bottom: 20px;
            margin-left: 20px;
        }

        .movie-item:hover {
            transform: translateY(-5px);
        }

        .movie-poster {
            width: 100%;
            height: auto;
        }

        .movie-item-content {
            padding: 10px;
        }

        .movie-item-title {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .movie-infos {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .movie-info {
            display: flex;
            align-items: center;
        }

        .movie-info span {
            margin-left: 5px;
        }

        .more-info-btn {
            background-color: #c0392b;
            color: #fff;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s ease;
            margin-top: 10px;
        }

        .movie-item .movie-item-title {
            color: white;
        }

        .more-info-btn:hover {
            background-color: #a93226;
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
                <a href="#" id="home-link" class="logo"><img src="../logo/savoy.png" alt="Logo"></a>
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
    <div class="section">
        <div class="container">
            <div class="section-header">
                All Movies
            </div>
            <div class="movies-grid">
                <?php
                    // Database connection
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $dbname = "savoy";

                    // Create connection
                    $conn = new mysqli($servername, $username, $password, $dbname);

                    // Check connection
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    // SQL query to retrieve movie data
                    $sql = "SELECT * FROM movie";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        // Output data of each row
                        while($row = $result->fetch_assoc()) {
                            echo '<a href="movie-details.php?movie_id=' . $row['movie_id'] . '" class="movie-item">';
                            echo '<img src="../img/movie-posters/' . $row["movie_poster"] . '" alt="Movie Poster" class="movie-poster">';
                            echo '<div class="movie-item-content">';
                            echo '<div class="movie-item-title">' . $row["movie_name"] . '</div>';
                            echo '<div class="movie-infos">';
                            echo '<div class="movie-info"><i class="bx bxs-star"></i><span>' . $row["rating"] . '</span></div>';
                            echo '<div class="movie-info"><i class="bx bxs-time"></i><span>' . $row["duration"] . '</span></div>';
                            echo '<div class="movie-info"><span>HD</span></div>';
                            echo '<div class="movie-info"><span>16+</span></div>';
                            echo '</div>';
                            echo '</div>';
                            echo '</a>';
                        }
                    } else {
                        echo "0 results";
                    }
                    $conn->close();
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
        Copyright 2024 Savoy || Aysha Thikra</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw==" crossorigin="anonymous"></script>
    <script src="member-dashboard.js"></script>
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

            document.getElementById('book-now-link').addEventListener('click', function(event) {
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
