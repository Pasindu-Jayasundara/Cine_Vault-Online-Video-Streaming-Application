<?php
require "../connection/connection.php";

$shop_rs = Database::search("SELECT * FROM `shop`");
$shop_data = $shop_rs->fetch_assoc();

session_start();

if (!empty($_SESSION["user"])) {
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title><?php echo $shop_data["name"]; ?> | Purchased History</title>

        <link rel="stylesheet" href="../css/bootstrap/bootstrap.min.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css" />
        <link rel="icon" href="<?php echo $shop_data["logo_link"]; ?>" />

        <link rel="stylesheet" href="../css/other/purchasedHistory.css"/>
    </head>

    <body>
        <div class="container-fluid bg-black text-white min-vh-100">
            <div class="row">

                <?php include "header.php"; ?>
                <span class="button-76 d-flex justify-content-center align-items-center position-absolute" style="width:150px; margin-top:40%"  id="scrollBtn">More&nbsp;&nbsp; <i class="bi bi-arrow-down"></i></span>

                <div class="col-12 min-vh-100">
                    <div class="row" id="body">
                    
                   

                        <div class="row row-cols-1 row-cols-md-6 g-4">
                            <?php
                            $rs = Database::search("SELECT * FROM `purchase_history` INNER JOIN `purchased_item_code` ON `purchased_item_code`.`purchase_history_purchase_history_id`=`purchase_history`.`purchase_history_id` 
                            WHERE `purchased_item_code`.`status_id`='1' AND `purchase_history`.`user_id`='" . $_SESSION["user"]["id"] . "' ORDER BY `purchase_history`.`date_time` DESC");

                            if ($rs->num_rows > 0) {

                                for ($x = 0; $x < $rs->num_rows; $x++) {
                                    $data = $rs->fetch_assoc();

                                    $code = $data["purchased_item_code"];

                                    $type_rs = Database::search("SELECT * FROM `movie` WHERE `movie`.`code`='" . $code . "'");
                                    if ($type_rs->num_rows > 0) { //it is a movie

                                        $movie_rs = Database::search("SELECT `movie`.`link` AS `link`,
                                        `movie`.`code` AS `code`,
                                        `movie`.`name` AS `name`,
                                        `movie`.`description` AS `description`,
                                        `movie`.`date_time` AS `date_time`,
                                        `movie`.`id` AS `id`
                                        FROM `movie` INNER JOIN `movie_cover` ON `movie`.`id`=`movie_cover`.`movie_id` 
                                        INNER JOIN `movie_url` ON `movie_url`.`movie_id`=`movie`.`id` 
                                        WHERE `movie_cover`.`status_id`='1' AND `movie`.`status_id`='1' AND `movie`.`code`='" . $code . "'");

                                        if ($movie_rs->num_rows == 1) {
                                            $movie_data = $movie_rs->fetch_assoc();

                            ?>
                                            <div class="col" data-aos="zoom-in-up">
                                                <div class="card h-100 bg-info">
                                                    <img src="<?php echo $movie_data["link"]; ?>" onclick="window.location.href='singleContentData.php?movie=t&tv=f&code=<?php echo $code; ?>&b=t';" class="card-img-top" style="width:100%; height:200px; object-fit: cover; background-position: center; " alt="...">
                                                    <div class="card-body bg-dark" style="max-height: 20vh; overflow-y: scroll;">
                                                        <h5 class="card-title"><?php echo $movie_data["name"]; ?></h5>
                                                        <p class="card-text">
                                                            <?php echo $movie_data["description"]; ?>
                                                        </p>
                                                    </div>
                                                    <div class="card-footer bg-black d-flex justify-content-between align-items-center">
                                                        <small class="text-muted"><?php echo $data["date_time"]; ?></small>
                                                        <i class="bi bi-trash3 text-warning" onclick="delectFromPurchasedHistory('<?php echo $code; ?>','<?php echo $data['purchased_item_code_id'] ?>')"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php

                                        }
                                    } else { //check tv
                                        $tv_type_rs = Database::search("SELECT * FROM `tv_series` WHERE `tv_series`.`code`='" . $code . "'");
                                        if ($tv_type_rs->num_rows == 1) {

                                            $tv_rs = Database::search("SELECT `tv_series_cover`.`link` AS `link`,
                                            `tv_series`.`code` AS `code`,
                                            `tv_series`.`name` AS `name`,
                                            `tv_series`.`description` AS `description`,
                                            `tv_series`.`date_time` AS `date_time`,
                                            `tv_series`.`id` AS `id` FROM `tv_series` INNER JOIN `tv_series_cover` ON `tv_series`.`id`=`tv_series_cover`.`tv_series_id` 
                                            WHERE `tv_series_cover`.`status_id`='1' AND `tv_series`.`status_id`='1' AND `tv_series`.`code`='" . $code . "' 
                                            GROUP BY `tv_series`.`code`");

                                            if ($tv_rs->num_rows == 1) {
                                                $tv_data = $tv_rs->fetch_assoc();

                                            ?>
                                                <div class="col" data-aos="zoom-in-up">
                                                    <div class="card h-100 bg-info">
                                                        <img src="<?php echo $tv_data["link"]; ?>" onclick="window.location.href='singleContentData.php?movie=f&tv=t&code=<?php echo $code; ?>&b=t';" class="card-img-top" style="width:100%; height:200px; object-fit: cover; background-position: center; " alt="...">
                                                        <div class="card-body bg-dark" style="max-height: 20vh; overflow-y: scroll;">
                                                            <h5 class="card-title"><?php echo $tv_data["name"]; ?></h5>
                                                            <p class="card-text">
                                                                <?php echo $tv_data["description"]; ?>
                                                            </p>
                                                        </div>
                                                        <div class="card-footer bg-black d-flex justify-content-between align-items-center">
                                                            <small class="text-muted"><?php echo $data["date_time"]; ?></small>
                                                            <i class="bi bi-trash3 text-warning" onclick="delectFromPurchasedHistory('<?php echo $code; ?>','<?php echo $data['purchased_item_code_id'] ?>')"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                <?php

                                            }
                                        }
                                    }
                                }
                            } else {
                                // echo "donthave baught item";
                                ?>
                                <div class="vw-100 d-flex vh-100 flex-column justify-content-center align-items-center ">
                                    <p class="fs-3 text-warning mb-5" style="margin-top: -15%;">Don't Have A Purchased History</p>
                                    <img src="../design_images/purrchasehistory.png" style="width: 300px;" alt="">
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                        
                    </div>
                </div>

                <?php include "../common/footer.php"; ?>

            </div>
        </div>

        <script src="../js/other/purchasedHistory.js"></script>
    </body>

    </html>

<?php
} else {
    header("Location:index.php");
}
?>