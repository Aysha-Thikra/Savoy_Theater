<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <link rel="icon" type="image/x-icon" href="../image/faviconsav.ico">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g==" crossorigin="anonymous" />
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../css/member-dashboard.css">
    <link rel="stylesheet" href="../css/grid.css">

    <style>
        /* Content Container Styles */
#section {
    padding: 40px 0;
}

.section-header {
    font-size: 32px;
    font-weight: bold;
    text-align: center;
    margin-bottom: 30px;
}

.savoy-info {
    padding: 0 20px;
}

.savoy-info h2 {
    font-size: 24px;
    font-weight: bold;
    margin-bottom: 20px;
    color: #c0392b;
}

.savoy-info h3 {
    font-size: 20px;
    font-weight: bold;
    margin-top: 30px;
    margin-bottom: 10px;
    color: #c0392b;
}

.savoy-info p {
    font-size: 16px;
    line-height: 1.6;
    margin-bottom: 20px;
}

.savoy-info img {
    max-width: 100%;
    height: auto;
}

/* Responsive Styles */
@media (max-width: 768px) {
    .section-header {
        font-size: 28px;
    }

    .savoy-info h2 {
        font-size: 22px;
    }

    .savoy-info h3 {
        font-size: 18px;
    }

    .savoy-info p {
        font-size: 14px;
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
                    <li><a href="feedbacks.php" id="feedbacks-link">Feedbacks</a></li>
                </ul>
                <a href="booking.php" class="btn btn-hover" id="book-now-btn">Book Now</a> 
            </div>
        </div>
    </nav>

    <!-- Content Container -->
    <div id="section">
        <div class="container">
            <div class="section-header" style="margin-top: 40px;">
                About Savoy Theater
            </div>
            <div class="row">
                <div class="col-md-6">
                    <img src="../img/admin-logo/admin.png" alt="Savoy Theater" class="img-fluid">
                </div>
                <div class="col-md-6">
                    <div class="savoy-info">
                        <h2>Welcome to Savoy Movie Theater</h2>
                        <p>
                            Savoy Movie Theater is not just a cinema; it’s an experience. Nestled in the heart of Colombo, we have been the premier destination for movie enthusiasts since our establishment in 1950. Over the years, we have continuously evolved, embracing technological advancements to offer an unparalleled cinematic journey to our patrons.
                        </p>
                        <p>
                            At Savoy, we believe in the power of storytelling and aim to provide our patrons with an extraordinary movie-going experience. Our state-of-the-art facilities, comfortable seating, and top-notch services ensure that every visit is a memorable one.
                        </p>
                        <h3>Our Commitment</h3>
                        <p>
                            With a legacy spanning over seven decades, our commitment to excellence remains unwavering. We are dedicated to bringing the latest blockbusters, timeless classics, and indie gems to the big screen, catering to diverse tastes and preferences.
                        </p>
                        <h3>Our Mission</h3>
                        <p>
                            Our mission at Savoy Movie Theater is to celebrate the art of cinema by providing a platform for diverse stories and voices. We strive to cultivate a community of film enthusiasts and foster a deeper appreciation for the cinematic arts. Through innovation and customer-centricity, we aim to exceed expectations and set new standards in the entertainment industry.
                        </p>
                    </div>
                </div>
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
            document.getElementById('book-now-btn').addEventListener('click', function(event) { // Fixed ID here
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
