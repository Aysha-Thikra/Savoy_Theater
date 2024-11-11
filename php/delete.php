<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $type = $_POST['type'];
    $id = $_POST['id'];

    $delete_sqls = [];

    switch ($type) {
        case 'movie':
            // Add SQL statements to delete related data for a movie
            $delete_sqls[] = "DELETE FROM movie WHERE movie_id = ?";
            break;
        case 'cast':
            // Add SQL statement to delete a cast record
            $delete_sqls[] = "DELETE FROM cast WHERE cast_id = ?";
            break;
        case 'show':
            // Add SQL statement to delete a show record
            $delete_sqls[] = "DELETE FROM shows WHERE show_id = ?";
            break;
        case 'booking':
            // Add SQL statement to delete a booking record
            $delete_sqls[] = "DELETE FROM booking WHERE booking_id = ?";
            break;
        case 'feedback':
            // Add SQL statement to delete a feedback record
            $delete_sqls[] = "DELETE FROM feedbacks WHERE feedback_id = ?";
            break;
        case 'promotion':
            // Add SQL statement to delete a promotion record
            $delete_sqls[] = "DELETE FROM banner WHERE banner_id = ?";
            break;
        default:
            echo "Invalid type!";
            exit;
    }

    // Execute all delete queries
    foreach ($delete_sqls as $sql) {
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 's', $id);

        if (!mysqli_stmt_execute($stmt)) {
            echo "Error deleting record: " . mysqli_error($conn);
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            exit;
        }
        mysqli_stmt_close($stmt);
    }

    echo "Record deleted successfully";
}

mysqli_close($conn);
?>
