<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Promotion</title>
    <link rel="icon" type="image/x-icon" href="../image/faviconsav.ico">
    <link rel="stylesheet" href="../css/add-promotion.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-image: url('../img/bg.jpeg');">
    <div class="container mt-5">
        <div class="card">
            <div class="card-header text-white">
                <h2 align="center">Add Promotion</h2>
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
                    $banner_id = generateID('BAN', $conn, 'banner', 'banner_id');

                    $target_dir = "../img/banner-posters/";
                    $target_file = $target_dir . basename($_FILES["bannerPoster"]["name"]);
                    $uploadOk = 1;
                    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                    $check = getimagesize($_FILES["bannerPoster"]["tmp_name"]);
                    if ($check !== false) {
                        $uploadOk = 1;
                    } else {
                        echo "File is not an image.";
                        $uploadOk = 0;
                    }

                    if (file_exists($target_file)) {
                        echo "Sorry, file already exists.";
                        $uploadOk = 0;
                    }

                    if ($_FILES["bannerPoster"]["size"] > 500000) {
                        echo "Sorry, your file is too large.";
                        $uploadOk = 0;
                    }

                    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                        $uploadOk = 0;
                    }

                    if ($uploadOk == 0) {
                        echo "Sorry, your file was not uploaded.";
                    } else {
                        if (move_uploaded_file($_FILES["bannerPoster"]["tmp_name"], $target_file)) {
                            $banner_poster = basename($_FILES["bannerPoster"]["name"]);
                            $sql = "INSERT INTO banner (banner_id, banner_poster) VALUES ('$banner_id', '$banner_poster')";

                            if (mysqli_query($conn, $sql)) {
                                echo "<div class='alert alert-success'>New promotion added successfully</div>";
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
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="bannerPoster">Banner Poster</label>
                            <input type="file" class="form-control" id="bannerPoster" name="bannerPoster" required>
                        </div>
                    </div>
                    <div class="form-group d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary" onclick="window.location.href='admin-dashboard.php'" style="background-color: #5b0f0f">Cancel</button>
                        <button type="submit" class="btn btn-primary" style="background-color: #5b0f0f">Add Promotion</button>
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
