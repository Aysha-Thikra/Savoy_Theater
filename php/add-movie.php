<?php
include 'db_connection.php';

// Function to generate unique ID
function generateID($prefix, $conn, $table, $id_field) {
    $result = mysqli_query($conn, "SELECT MAX($id_field) AS max_id FROM $table");
    $row = mysqli_fetch_assoc($result);
    $max_id = $row['max_id'];

    if ($max_id) {
        $num = intval(substr($max_id, 1)) + 1;
        $new_id = $prefix . str_pad($num, 4, '0', STR_PAD_LEFT);
    } else {
        $new_id = $prefix . '0001';
    }

    return $new_id;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $movie_id = generateID('M', $conn, 'movie', 'movie_id');
    $show_id = generateID('S', $conn, 'shows', 'show_id');

    $movie_name = mysqli_real_escape_string($conn, $_POST['movie-name']);
    $language = mysqli_real_escape_string($conn, $_POST['language']);
    $hero = mysqli_real_escape_string($conn, $_POST['hero']);
    $heroine = mysqli_real_escape_string($conn, $_POST['heroin']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $movie_category = mysqli_real_escape_string($conn, $_POST['movie-category']);
    $trailer_url = mysqli_real_escape_string($conn, $_POST['trailer-url']);
    $duration = mysqli_real_escape_string($conn, $_POST['duration']);
    $movie_status = mysqli_real_escape_string($conn, $_POST['movie-status']);
    $rating = mysqli_real_escape_string($conn, $_POST['rating']);
    $start_time = mysqli_real_escape_string($conn, $_POST['start-time']);
    $end_time = mysqli_real_escape_string($conn, $_POST['end-time']);
    $release_date = mysqli_real_escape_string($conn, $_POST['release-date']);
    $start_date = mysqli_real_escape_string($conn, $_POST['start-date']);
    $end_date = mysqli_real_escape_string($conn, $_POST['end-date']);

    // Handle file upload
    $target_dir = "../img/movie-posters/";
    $target_file = $target_dir . basename($_FILES["movie-poster"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["movie-poster"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["movie-poster"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["movie-poster"]["tmp_name"], $target_file)) {
            // File is uploaded, now save movie details in the database
            $movie_poster = basename($_FILES["movie-poster"]["name"]);

            $sql_movie = "INSERT INTO movie (movie_id, movie_name, movie_poster, language, hero, heroine, description, movie_category, trailer_url, duration, movie_status, rating, release_date) 
                          VALUES ('$movie_id', '$movie_name', '$movie_poster', '$language', '$hero', '$heroine', '$description', '$movie_category', '$trailer_url', '$duration', '$movie_status', '$rating', '$release_date')";

            $sql_show = "INSERT INTO shows (show_id, movie_id, start_time, end_time, start_date, end_date) 
                         VALUES ('$show_id', '$movie_id', '$start_time', '$end_time', '$start_date', '$end_date')";

            if (mysqli_query($conn, $sql_movie) && mysqli_query($conn, $sql_show)) {
                echo "<script>alert('New movie added successfully'); window.location.href='admin-dashboard.php';</script>";
            } else {
                echo "Error: " . $sql_movie . "<br>" . mysqli_error($conn);
                echo "Error: " . $sql_show . "<br>" . mysqli_error($conn);
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Movie</title>
    <link rel="icon" type="image/x-icon" href="../image/faviconsav.ico">
    <link rel="stylesheet" href="../css/add-movie.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-image: url('../img/bg.jpeg');">
    <div class="container mt-5" style="margin-bottom: 50px;">
    <div class="card">
    <div class="card-header text-white">
        <h2 align="center">Add New Movie</h2>
    </div>
    <div class="card-body">
        <form id="add-movie-form" action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="movie-name">Movie Name:</label>
                <input type="text" class="form-control" id="movie-name" name="movie-name" required>
            </div>
            <div class="form-group">
                <label for="movie-poster">Movie Poster:</label>
                <input type="file" class="form-control" id="movie-poster" name="movie-poster" accept="image/*" required>
            </div>
            <div class="form-group">
                <label for="language">Language:</label>
                <input type="text" class="form-control" id="language" name="language" required>
            </div>
            <div class="form-group">
                <label for="hero">Hero:</label>
                <input type="text" class="form-control" id="hero" name="hero" required>
            </div>
            <div class="form-group">
                <label for="heroin">Heroin:</label>
                <input type="text" class="form-control" id="heroin" name="heroin" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
            </div>
            <div class="form-group">
                <label for="movie-category">Movie Category:</label>
                <select class="form-control" id="movie-category" name="movie-category" required>
                    <option value="Action">Action</option>
                    <option value="Drama">Drama</option>
                    <option value="Comedy">Comedy</option>
                    <option value="Horror">Horror</option>
                    <option value="Romance">Romance</option>
                    <option value="Thriller">Thriller</option>
                    <option value="Animation">Animation</option>
                    <option value="Fantasy">Fantasy</option>
                    <option value="Historical Film">Historical Film</option>
                    <option value="Science Fiction">Science Fiction</option>
                    <option value="Crime Film">Crime Film</option>
                    <option value="Adventure">Adventure</option>
                    <option value="Documentary">Documentary</option>
                </select>
            </div>
            <div class="form-group">
                <label for="trailer-url">Trailer URL:</label>
                <input type="url" class="form-control" id="trailer-url" name="trailer-url" required>
            </div>
            <div class="form-group">
                <label for="duration">Duration:</label>
                <input type="text" class="form-control" id="duration" name="duration" pattern="\d{2}h \d{2}min \d{2}s" placeholder="00h 00min 00s" required>
            </div>
            <div class="form-group">
                <label for="movie-status">Movie Status:</label>
                <select class="form-control" id="movie-status" name="movie-status" required>
                    <option value="Now Showing">Now Showing</option>
                    <option value="Upcoming movies">Upcoming movies</option>
                </select>
            </div>
            <div class="form-group">
                <label for="rating">Rating:</label>
                <input type="number" class="form-control" id="rating" name="rating" min="1" max="10" step="0.1" required>
            </div>
            <div class="form-group">
                <label for="start-time">Start Time:</label>
                <select class="form-control" id="start-time" name="start-time" required>
                    <option value="09:00 AM">09:00 AM</option>
                    <option value="12:00 PM">12:00 PM</option>
                    <option value="03:00 PM">03:00 PM</option>
                    <option value="06:00 PM">06:00 PM</option>
                    <option value="09:00 PM">09:00 PM</option>
                </select>
            </div>
            <div class="form-group">
                <label for="end-time">End Time:</label>
                <select class="form-control" id="end-time" name="end-time" required>
                    <option value="11:00 AM">11:00 AM</option>
                    <option value="02:00 PM">02:00 PM</option>
                    <option value="05:00 PM">05:00 PM</option>
                    <option value="08:00 PM">08:00 PM</option>
                    <option value="11:00 PM">11:00 PM</option>
                </select>
            </div>
            <div class="form-group">
                <label for="release-date">Release Date:</label>
                <input type="date" class="form-control" id="release-date" name="release-date" required>
            </div>
            <div class="form-group">
                <label for="start-date">Start Date:</label>
                <input type="date" class="form-control" id="start-date" name="start-date" required>
            </div>
            <div class="form-group">
                <label for="end-date">End Date:</label>
                <input type="date" class="form-control" id="end-date" name="end-date" required>
            </div>
            <div class="form-group d-flex justify-content-between">
                <button type="button" class="btn btn-secondary" onclick="window.location.href='admin-dashboard.php'" style="background-color: #5b0f0f ; border-radius: 20px; padding: 10px 25px;">Cancel</button>
                <button type="submit" class="btn btn-primary" style="background-color: #5b0f0f; border-radius: 20px; padding: 10px 25px;">Add Movie</button>
            </div>
        </form>
    </div>
</div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
