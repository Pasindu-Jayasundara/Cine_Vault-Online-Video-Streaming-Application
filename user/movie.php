<?php
require "../connection/connection.php";
session_start();

$shop_rs = Database::search("SELECT * FROM `shop`");
$shop_data = $shop_rs->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $shop_data["name"]; ?> | Movies</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="../css/bootstrap/bootstrap.css" />
    <link rel="icon" href="<?php echo $shop_data["logo_link"]; ?>" />


</head>

<body>
    <div class="container-fluid" style="background-color: #000000;">
        <div class="row text-white">

            <?php include "header.php"; ?>

            <div class="col-12 m-0 p-0" style="min-height: 100vh;">
                <div class="row m-0 p-0 d-flex justify-content-evenly align-items-center" id="body">

                    <?php
                    $upcomming_rs = Database::search("SELECT * FROM `upcomming_content` WHERE `upcomming_content`.`status_id`='1' ORDER BY RAND()");
                    if ($upcomming_rs->num_rows > 0) {

                    ?>

                        <!-- left -->
                        <div id="carouselExampleSlidesOnly" data-aos="fade-left" class="carousel slide w-25" data-bs-ride="carousel">
                            <p class="text-center fs-4 text-warning bg-dark ">Upcomming</p>
                            <div class="carousel-inner" style="width: 100%; height: 55vh;" id="leftCarousel">
                                <?php
                                for ($y = 0; $y < $upcomming_rs->num_rows; $y++) {
                                    $upcomming_data = $upcomming_rs->fetch_assoc();

                                ?>
                                    <div class="carousel-item" style="width: 100%; height: 55vh;">
                                        <div class="d-flex justify-content-center align-items-center" style="width: 100%; height:20%; background-color: #320242; margin-top:90%; position: absolute;">
                                            <p class="text-white">Release Date : <?php echo $upcomming_data["release_date"]; ?></p>
                                        </div>
                                        <img src="<?php echo $upcomming_data["url"]; ?>" style="height: 100%;" class="d-block w-100" alt="...">
                                    </div>
                                <?php

                                }
                                ?>
                            </div>
                        </div>

                    <?php

                    }
                    ?>

                    <!-- center -->

                    <?php

                    $query = "SELECT * FROM `movie` ORDER BY RAND() LIMIT 10";
                    $rs = Database::search($query);
                    $num = $rs->num_rows;

                    ?>
                    <!-- carousel -->
                    <div id="myCarousel" data-aos="zoom-in" class="carousel slide w-50" data-bs-ride="carousel">
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
                            <?php
                            for ($x = 0; $x < $num; $x++) {
                                $data = $rs->fetch_assoc();

                                $table_find_query = "SELECT * FROM `movie` WHERE `movie`.`code`='" . $data["code"] . "'";
                                $table_find_rs = Database::search($table_find_query);
                                $table_find_num = $table_find_rs->num_rows;

                                if ($table_find_num > 0) { //then it is a movie
                                    $movie_rs = Database::search("SELECT * FROM `movie_cover` WHERE `movie_cover`.`movie_code`='" . $data["code"] . "'");
                                    $movie_data = $movie_rs->fetch_assoc();
                            ?>

                                    <div class="carousel-item" style="width: 100%; height: 85vh;">
                                        <img src="<?php echo $movie_data["link"]; ?>" style="width: 100%; height: 85vh; background-size: cover; object-fit: cover;">

                                        <div class="container">
                                            <div class="carousel-caption text-start w-100 p-3" style="margin-left: -15%; height:18vh; margin-bottom: -3%; background-color: rgba(0, 0, 0, 0.444);">
                                                <span class="fs-2 fw-bold"><?php echo $data['name']; ?></span>
                                                <span class="ms-5"><a class="btn btn-lg btn-primary" href="singleContentData.php?movie=t&tv=f&code=<?php echo $data["code"]; ?>">Watch Now</a></span>
                                            </div>
                                        </div>
                                    </div>

                            <?php
                                }
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


                    <?php
                    $upcomming_rs = Database::search("SELECT * FROM `upcomming_content` WHERE `upcomming_content`.`status_id`='1' ORDER BY RAND()");
                    if ($upcomming_rs->num_rows > 0) {

                    ?>

                        <!-- right -->
                        <div id="carouselExampleSlidesOnly" data-aos="fade-right" class="carousel slide w-25" data-bs-ride="carousel">
                            <p class="text-center fs-4 text-warning bg-dark ">Upcomming</p>
                            <div class="carousel-inner" style="width: 100%; height: 55vh;" id="rightCarousel">
                                <?php
                                for ($x = 0; $x < $upcomming_rs->num_rows; $x++) {
                                    $upcomming_data = $upcomming_rs->fetch_assoc();

                                ?>
                                    <div class="carousel-item" style="width: 100%; height: 55vh;">
                                        <div class="d-flex justify-content-center align-items-center" style="width: 100%; height:20%; background-color: #320242; margin-top:90%; position: absolute;">
                                            <p class="text-white">Release Date : <?php echo $upcomming_data["release_date"]; ?></p>
                                        </div>
                                        <img src="<?php echo $upcomming_data["url"]; ?>" style="height: 100%;" class="d-block w-100" alt="...">
                                    </div>
                                <?php

                                }
                                ?>
                            </div>
                        </div>

                    <?php

                    }
                    ?>


                    <!-- highest ratings -->
                    <p class="mt-5">Highest Rating</p>
                    <!-- content -->
                    <div class="col-12">
                        <div class="row">

                            <div class="container-fluid pb-3">
                                <div class="d-grid gap-3 p-2">

                                    <!-- cards -->
                                    <div class="d-flex flex-row" style="overflow-x: scroll;" data-aos="fade-up" id="highRatingCardDiv">

                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- most populer -->
                    <p class="mt-2">Most Populer</p>
                    <!-- content -->
                    <div class="col-12">
                        <div class="row">

                            <div class="container-fluid pb-3">
                                <div class="d-grid gap-3 p-2">

                                    <!-- cards -->
                                    <div class="d-flex flex-row" style="overflow-x: scroll;" data-aos="fade-up" id="mostPopulerCardDiv">

                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- content -->
                    <p>Explorer</p>
                    <div class="col-12" style="margin-top: -3%;">
                        <div class="row mb-4">

                            <div class="container-fluid pb-3">
                                <div class="d-grid gap-3 p-2">

                                    <!-- cards -->
                                    <div class="row row-cols-1 row-cols-md-5 g-4" data-aos="zoom-in-up" id="cardDiv">

                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                    <?php
                    if (!empty($_SESSION["user"])) {
                    ?>
                        <div class="toast-container position-fixed bottom-0 end-0 p-3">
                            <div id="liveToast2" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                                <div class="toast-header bg-secondary text-white">
                                    <?php
                                    $img_rs = Database::search("SELECT * FROM `profile_image` INNER JOIN `user` ON `user`.`id`=`profile_image`.`user_id` 
                                    WHERE `user`.`id`='" . $_SESSION["user"]["id"] . "' AND `user`.`status_id`='1' AND `profile_image`.`status_id`='1'");

                                    if ($img_rs->num_rows == 1) {
                                        $img_data = $img_rs->fetch_assoc();
                                    ?>
                                        <img src="<?php echo $img_data["link"]; ?>" class="rounded me-2" style="width:20px;" />
                                    <?php
                                    }
                                    ?>
                                    <strong class="me-auto">Message</strong>
                                    <small id="time2"></small>
                                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                                </div>
                                <div class="toast-body" id="msg2">

                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>

            <?php include "../common/footer.php"; ?>

        </div>
    </div>

    <script src="../js/other/movie.js"></script>
</body>

</html>