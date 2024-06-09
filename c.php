<?php
require "connection/connection.php";


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap/bootstrap.css" />

    <title>Document</title>
</head>

<body>
    <?php

    $query = "(SELECT * FROM `movie` WHERE `movie`.`status_id`='1' ORDER BY RAND() LIMIT 5) UNION (SELECT * FROM `tv_series` WHERE `tv_series`.`status_id`='1' ORDER BY RAND() LIMIT 5) ORDER BY RAND() LIMIT 10";
    $rs = Database::search($query);
    $num = $rs->num_rows;

    ?>
    <div id="myCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <?php
            for ($x = 1; $x < $num; $x++) {
            ?>
                <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="<?php echo $x; ?>" aria-label="Slide <?php echo $x + 1; ?>"></button>
            <?php
            }
            ?>
        </div>
        <div class="carousel-inner" style="width: 100%; height: 85vh;" id="imgs">
            <div class="carousel-item active">
                <img src="images/f.jpg" class="d-block w-100" alt="...">
            </div>
            <?php
            for ($x = 0; $x < $num; $x++) {
                $data = $rs->fetch_assoc();

                $table_find_query = "SELECT * FROM `movie` WHERE `movie`.`code`='" . $data["code"] . "' AND `movie`.`status_id`='1'";
                $table_find_rs = Database::search($table_find_query);
                $table_find_num = $table_find_rs->num_rows;

                // if ($table_find_num > 0) { //then it is a movie
                //     $movie_rs = Database::search("SELECT * FROM `movie_cover` WHERE `movie_cover`.`movie_code`='" . $data["code"] . "' AND `movie_cover`.`status_id`='1'");
                //     $movie_data = $movie_rs->fetch_assoc();
                // }else{

                // }
            ?>
                <div class="carousel-item">
                    <img src="images/k.jpg" class="d-block w-100" alt="...">
                </div>
            <?php
            }
            ?>

        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>


    <script src="js/bootstrap/bootstrap.bundle.min.js"></script>

</body>

</html>