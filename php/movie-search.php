<?php
include 'db_connection.php';

if (isset($_GET['query'])) {
    $search_query = $_GET['query'];

    // SQL query to search for movies
    $sql = "SELECT * FROM movie WHERE movie_name LIKE '%$search_query%'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        // If exactly one movie is found, redirect to movie-details.php with movie_id
        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            $movie_id = $row['movie_id'];
            header("Location: movie-details.php?movie_id=$movie_id");
            exit();
        } else {
            // If multiple movies are found, display search results (could link to movie-details.php for each result)
            echo "<h2>Search Results:</h2>";
            echo "<ul>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<li><a href="movie-details.php?movie_id=' . $row['movie_id'] . '">' . $row['movie_name'] . '</a></li>';
            }
            echo "</ul>";
        }
    } else {
        echo "No movies found.";
    }

    mysqli_close($conn);
} else {
    echo "Please enter a search query.";
}
?>
