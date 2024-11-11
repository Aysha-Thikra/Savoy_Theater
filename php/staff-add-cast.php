<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Cast</title>
    <link rel="icon" type="image/x-icon" href="../image/faviconsav.ico">
    <link rel="stylesheet" href="../css/add-cast.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-image: url('../img/bg.jpeg');">
    <div class="container mt-5">
        <div class="card">
            <div class="card-header text-white">
                <h2 align="center">Add New Cast</h2>
            </div>
            <div class="card-body">
                <?php
                include 'db_connection.php';

                function generateID($prefix, $conn, $table, $id_field) {
                    $result = mysqli_query($conn, "SELECT MAX($id_field) AS max_id FROM $table");
                    $row = mysqli_fetch_assoc($result);
                    $max_id = $row['max_id'];

                    if ($max_id) {
                        $num = intval(substr($max_id, strlen($prefix))) + 1;
                        $new_id = $prefix . str_pad($num, 4, '0', STR_PAD_LEFT);
                    } else {
                        $new_id = $prefix . '0001';
                    }

                    return $new_id;
                }

                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $cast_id = generateID('CAST', $conn, 'cast', 'cast_id');
                    $movie_id = $_POST['movie-id'];
                    $cast_name = $_POST['cast-name'];

                    // Handle file upload
                    $target_dir = "../img/cast-images/";
                    $target_file = $target_dir . basename($_FILES["cast-image"]["name"]);
                    $uploadOk = 1;
                    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                    // Check if image file is a actual image or fake image
                    $check = getimagesize($_FILES["cast-image"]["tmp_name"]);
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
                    if ($_FILES["cast-image"]["size"] > 500000) {
                        echo "Sorry, your file is too large.";
                        $uploadOk = 0;
                    }

                    // Allow certain file formats
                    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                        $uploadOk = 0;
                    }

                    // Check if $uploadOk is set to 0 by an error
                    if ($uploadOk == 0) {
                        echo "Sorry, your file was not uploaded.";
                    // If everything is ok, try to upload file
                    } else {
                        if (move_uploaded_file($_FILES["cast-image"]["tmp_name"], $target_file)) {
                            $cast_image = basename($_FILES["cast-image"]["name"]);
                            $sql = "INSERT INTO cast (cast_id, movie_id, cast_name, cast_image) VALUES ('$cast_id', '$movie_id', '$cast_name', '$cast_image')";

                            if (mysqli_query($conn, $sql)) {
                                echo "<div class='alert alert-success'>New cast member added successfully</div>";
                            } else {
                                echo "<div class='alert alert-danger'>Error: " . $sql . "<br>" . mysqli_error($conn) . "</div>";
                            }
                        } else {
                            echo "<div class='alert alert-danger'>Sorry, there was an error uploading your file.</div>";
                        }
                    }

                    mysqli_close($conn);
                }
                ?>
                <form id="add-cast-form" action="add-cast.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="movie-id">Movie ID:</label>
                        <select class="form-control" id="movie-id" name="movie-id" required>
                            <?php
                            include 'db_connection.php';
                            $sql = "SELECT movie_id, movie_name FROM movie";
                            $result = mysqli_query($conn, $sql);

                            if (mysqli_num_rows($result) > 0) {
                                while($row = mysqli_fetch_assoc($result)) {
                                    echo "<option value='" . $row["movie_id"] . "'>" . $row["movie_id"] . " - " . $row["movie_name"] . "</option>";
                                }
                            } else {
                                echo "<option value=''>No movies available</option>";
                            }

                            mysqli_close($conn);
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="cast-name">Cast Name:</label>
                        <input type="text" class="form-control" id="cast-name" name="cast-name" required>
                    </div>
                    <div class="form-group">
                        <label for="cast-image">Cast Image:</label>
                        <input type="file" class="form-control" id="cast-image" name="cast-image" accept="image/*" required>
                    </div>
                    <div class="form-group d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary" onclick="window.location.href='staff-dashboard.php'" style="background-color: #5b0f0f">Cancel</button>
                        <button type="submit" class="btn btn-primary" style="background-color: #5b0f0f" onclick="window.location.href='staff-dashboard.php'">Add Cast</button>
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
