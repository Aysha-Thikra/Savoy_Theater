<?php
include 'db_connection.php';

$numChildren = isset($_POST['numChildren']) ? $_POST['numChildren'] : 0;
$numAdults = isset($_POST['numAdults']) ? $_POST['numAdults'] : 0;

$totalSeats = $numChildren + $numAdults;

$normalSeats = 150;
$odcSeats = 150;
$balconySeats = 200;

?>

<div class="seats-container">
    <div class="seats">
        <h3>Normal Seats</h3>
        <div class="seat-row">
            <?php
                for ($i = 1; $i <= $normalSeats; $i++) {
                    if ($i <= $totalSeats) {
                        echo '<div class="seat normal-seat">N' . $i . '</div>';
                    } else {
                        echo '<div class="seat disabled">N' . $i . '</div>';
                    }
                }
            ?>
        </div>
    </div>
    <div class="seats">
        <h3>ODC Seats</h3>
        <div class="seat-row">
            <?php
                for ($i = 1; $i <= $odcSeats; $i++) {
                    if ($i <= $totalSeats) {
                        echo '<div class="seat odc-seat">ODC' . $i . '</div>';
                    } else {
                        echo '<div class="seat disabled">ODC' . $i . '</div>';
                    }
                }
            ?>
        </div>
    </div>
    <div class="seats">
        <h3>Balcony Seats</h3>
        <div class="seat-row">
            <?php
                for ($i = 1; $i <= $balconySeats; $i++) {
                    if ($i <= $totalSeats) {
                        echo '<div class="seat balcony-seat">B' . $i . '</div>';
                    } else {
                        echo '<div class="seat disabled">B' . $i . '</div>';
                    }
                }
            ?>
        </div>
    </div>
</div>
