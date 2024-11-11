<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Details</title>
    <link rel="icon" type="image/x-icon" href="../image/faviconsav.ico">
    <link rel="stylesheet" href="../css/movie-details.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* movie-details.css */
        :root {
            --main-color: #c0392b;
            --body-bg: #181616;
            --box-bg: #221f1f;
            --text-color: #ffffff;
        }

        /* Button styling */
        .info-button {
            display: inline-block;
            padding: 10px 20px;
            margin-left: 300px;
            margin-right: 300px;
            font-size: 18px;
            border: none;
            border-radius: 20px;
            background-color: var(--main-color);
            color: var(--text-color);
            text-decoration: none;
            transition: background-color 0.3s ease;
            text-align: center;
        }

        .info-button:hover {
            background-color: #b77d76;
        }

        .info-button.disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }

        /* Additional info styling */
        .additional-info {
            margin-top: 20px;
        }

        .additional-info .info ul {
            list-style: none;
            padding: 0;
        }

        .additional-info .info ul li {
            margin-bottom: 10px;
            color: var(--text-color);
        }

        .additional-info .info ul li i {
            margin-right: 10px;
        }

        /* Container styling */
        .container {
            background-color: var(--body-bg);
            color: var(--text-color);
            padding: 20px;
        }

        /* Movie details section */
        .movie-details {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        /* Movie info */
        .movie-info {
            width: 60%;
        }

        .movie-info h1 {
            font-size: 58px;
        }

        .movie-info p {
            font-size: 18px;
            margin-top: 10px;
        }

        /* Movie poster */
        .movie-poster {
            width: 200px;
            text-align: center;
        }

        .movie-poster img {
            max-width: 100%;
            border-radius: 5px;
        }

        /* Cast section */
        .cast {
            margin-top: 40px;
        }

        .cast h2 {
            font-size: 24px;
        }

        .cast-list {
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-start;
            margin-top: 20px;
        }

        .cast-member {
            text-align: center;
            width: 25%;
            margin-bottom: 20px;
        }

        .cast-member img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 10px;
            border: 3px solid var(--main-color);
        }

        .cast-member span {
            display: block;
            font-size: 16px;
        }

    </style>
</head>

<body>
    <div class="container">
        <main class="content">
            <section class="movie-details">
                <div class="movie-info">
                    <?php
                    include 'db_connection.php';

                    if (isset($_GET['movie_id'])) {
                        $movie_id = $_GET['movie_id'];

                        // Query to fetch movie details
                        $movie_query = "SELECT * FROM movie WHERE movie_id = '$movie_id'";
                        $result = mysqli_query($conn, $movie_query);

                        if (mysqli_num_rows($result) > 0) {
                            $row = mysqli_fetch_assoc($result);
                            echo '<h1>' . $row["movie_name"] . '</h1>';
                            echo '<p>' . $row["description"] . '</p>';
                            echo '<div class="additional-info">';
                            echo '<div class="info">';
                            
                            // Modified Book Now button to include the movie_id in the URL
                            echo '<a href="booking.php?movie_id=' . $movie_id . '" class="info-button">Book Now</a>';
                            
                            // Fetching movie trailer link
                            $trailer_link = $row["trailer_url"];

                            // Checking if the trailer link is available
                            if (!empty($trailer_link)) {
                                echo '<a href="' . $trailer_link . '" class="info-button">Watch Trailer</a>';
                            } else {
                                echo '<a href="#" class="info-button disabled">Watch Trailer</a>';
                            }

                            echo '<br>';
                            echo '<ul>';
                            echo '<li style="font-size: 18px;"><i class="fas fa-calendar-alt"></i> <strong>Release Date :</strong> &nbsp; ' . $row["release_date"] . '</li>';
                            echo '<li style="font-size: 18px;"><i class="fas fa-clock"></i> <strong>Duration :</strong> &nbsp; ' . $row["duration"] . '</li>';
                            echo '<li style="font-size: 18px;"><i class="fas fa-star"></i> <strong>Rating :</strong> &nbsp; ' . $row["rating"] . '</li>';

                            // Query to fetch show details
                            $show_query = "SELECT * FROM shows WHERE movie_id = '$movie_id'";
                            $show_result = mysqli_query($conn, $show_query);

                            // Fetching show time and show date
                            if (mysqli_num_rows($show_result) > 0) {
                                $show_row = mysqli_fetch_assoc($show_result);
                                echo '<li style="font-size: 18px;"><i class="fas fa-bullseye"></i> <strong>Show time :</strong> &nbsp; ' . $show_row["start_time"] . '</li>';
                                echo '<li style="font-size: 18px;"><i class="fas fa-check-square"></i> <strong>Show Date :</strong> &nbsp; ' . $show_row["start_date"] . '</li>';
                            } else {
                                echo '<li style="font-size: 18px;"><i class="fas fa-bullseye"></i> <strong>Show time :</strong> &nbsp; N/A</li>';
                                echo '<li style="font-size: 18px;"><i class="fas fa-check-square"></i> <strong>Show Date :</strong> &nbsp; N/A</li>';
                            }

                            echo '<li style="font-size: 18px;"><i class="fas fa-film"></i> <strong>Genre :</strong> &nbsp; ' . $row["movie_category"] . '</li>';
                            echo '</ul>';
                            echo '</div>';
                            echo '</div>';
                        } else {
                            echo "<p>No movie details found</p>";
                        }
                    } else {
                        echo "<p>No movie selected</p>";
                    }

                    mysqli_close($conn);
                    ?>
                </div>
                <div class="movie-poster">
                    <?php
                    if (isset($_GET['movie_id'])) {
                        $movie_id = $_GET['movie_id'];
                        include 'db_connection.php';

                        // Query to fetch movie poster
                        $poster_query = "SELECT movie_poster FROM movie WHERE movie_id = '$movie_id'";
                        $result = mysqli_query($conn, $poster_query);

                        if (mysqli_num_rows($result) > 0) {
                            $row = mysqli_fetch_assoc($result);
                            echo '<img src="../img/movie-posters/' . $row["movie_poster"] . '" alt="">';
                        } else {
                            echo "<p>No movie poster found</p>";
                        }

                        mysqli_close($conn);
                    } else {
                        echo "<p>No movie selected</p>";
                    }
                    ?>
                </div>
            </section>
            <section class="cast">
                <h2>The Cast</h2>
                <div class="cast-list">
                    <?php
                    if (isset($_GET['movie_id'])) {
                        $movie_id = $_GET['movie_id'];
                        include 'db_connection.php';

                        // Query to fetch cast details for the selected movie
                        $cast_query = "SELECT * FROM cast WHERE movie_id = '$movie_id'";
                        $cast_result = mysqli_query($conn, $cast_query);

                        if (mysqli_num_rows($cast_result) > 0) {
                            while ($cast_row = mysqli_fetch_assoc($cast_result)) {
                                echo '<div class="cast-member">';
                                echo '<img src="../img/cast-images/' . $cast_row["cast_image"] . '" alt="">';
                                echo '<span>' . $cast_row["cast_name"] . '</span>';
                                echo '</div>';
                            }
                        } else {
                            echo "<p>No cast details found</p>";
                        }

                        mysqli_close($conn);
                    } else {
                        echo "<p>No movie selected</p>";
                    }
                    ?>
                </div>
            </section>
        </main>
    </div>
</body>

</html>
