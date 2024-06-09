<?php
session_start();
require "../connection/connection.php";

if (!empty($_SESSION["admin"])) {

    $shop_rs = Database::search("SELECT * FROM `shop`");
    $shop_data = $shop_rs->fetch_assoc();

    $date = new DateTime();
    $tz = new DateTimeZone("Asia/Colombo");
    $date->setTimezone($tz);
    $today = $date->format("Y-m-d H:i:s");

    $this_year_month = date("Y-m", strtotime($today));
    $this_year = date("Y", strtotime($today));
    $monthName = date("F", strtotime($today));

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $shop_data["name"]; ?> | Admin - Dashboard</title>

        <link rel="stylesheet" href="../css/bootstrap/bootstrap.css" />
        <link rel="stylesheet" href="../css/bootstrap/bootstrap.min.css" />
        <link rel="stylesheet" href="../css/other/sidebars.css">
        <link rel="stylesheet" href="../css/sementic/semantic.css">

        <link rel="icon" href="<?php echo $shop_data["logo_link"]; ?>" />

        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>


    </head>

    <body>

        <div class="container-fluid d-flex ps-0">

            <?php include "sidebar.php"; ?>

            <div class="col-10 vh-100" style="overflow-y: scroll; overflow-x: hidden;">
                <div class="row mb-4">

                    <div class="d-flex">
                        <p class="fw-bold" style="margin-top: 4%; margin-bottom: 0%; z-index: 5;"><?php echo $shop_data["name"]; ?> Performance</p>
                        <div class="col-md-2 ms-4" style="margin-top: 3.5%; margin-bottom: 0%; z-index: 5;">
                            <?php
                            $available_year_rs = Database::search("SELECT * FROM `summary_year`");
                            if ($available_year_rs->num_rows > 0) {

                            ?>
                                <select class="form-select" id="selectYear" required onchange="loadChardData();">
                                    <?php
                                    for ($x = 0; $x < $available_year_rs->num_rows; $x++) {
                                        $available_year_data = $available_year_rs->fetch_assoc();
                                    ?>
                                        <option value="<?php echo $available_year_data["summary_year"]; ?>" <?php
                                                                                                            if ($this_year == $available_year_data["summary_year"]) {
                                                                                                            ?> selected <?php
                                                                                                                    }
                                                                                                                        ?>><?php echo $available_year_data["summary_year"]; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                    <!-- chart div -->
                    <div id="curve_chart" style="width: 80%; height: 500px; margin-top: -4%; margin-bottom: -2%; z-index: 1;"></div>


                    <!-- cards -->
                    <p class="fw-bold" style="margin-top: 4%; margin-bottom: 0%; z-index: 5;"><?php echo $shop_data["name"]; ?> Performance At :&nbsp;&nbsp;&nbsp; <span class="fw-normal"><?php echo $monthName . " / " . $this_year; ?></span></p>
                    <div class="row row-cols-1 row-cols-md-5 g-4 ">
                        <div class="col">
                            <div class="card">
                                <div class="card-header bg-success text-white fw-bold">Active Users</div>
                                <div class="card-body d-flex justify-content-center">
                                    <?php
                                    $a_u_rs = Database::search("SELECT COUNT(`user`.`id`) AS `count` FROM `user` INNER JOIN `user_subscription` ON `user`.`id`=`user_subscription`.`user_id`
                                    WHERE `user`.`status_id`='1' AND `user_subscription`.`date_time` LIKE '" . $this_year_month . "%'");
                                    $a_u_data = $a_u_rs->fetch_assoc();
                                    ?>
                                    <p class="card-text"><?php echo $a_u_data["count"]; ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card">
                                <div class="card-header bg-success text-white fw-bold">Basic Subscriptions</div>
                                <div class="card-body d-flex justify-content-center">
                                    <?php
                                    $b_s_rs = Database::search("SELECT COUNT(*) AS `basic` FROM `user_subscription` 
                                    INNER JOIN `user` ON `user`.`id`=`user_subscription`.`user_id` 
                                    WHERE `user`.`status_id`='1' AND `user_subscription`.`status_id`='1' AND `user_subscription`.`subscription_id`='1' 
                                    AND `user_subscription`.`date_time` LIKE '" . $this_year_month . "%'");
                                    $b_s_data = $b_s_rs->fetch_assoc();
                                    ?>
                                    <p class="card-text"><?php echo $b_s_data["basic"]; ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card">
                                <div class="card-header bg-success text-white fw-bold">Pro Subscriptions</div>
                                <div class="card-body d-flex justify-content-center">
                                    <?php
                                    $p_s_rs = Database::search("SELECT COUNT(*) AS `pro` FROM `user_subscription` INNER JOIN `user` ON `user`.`id`=`user_subscription`.`user_id` 
                                    WHERE `user`.`status_id`='1' AND `user_subscription`.`status_id`='1' AND `user_subscription`.`subscription_id`='2' 
                                    AND `user_subscription`.`date_time` LIKE '" . $this_year_month . "%'");
                                    $p_s_data = $p_s_rs->fetch_assoc();
                                    ?>
                                    <p class="card-text"><?php echo $p_s_data["pro"]; ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card">
                                <div class="card-header bg-success text-white fw-bold">Primium Subscriptions</div>
                                <div class="card-body d-flex justify-content-center">
                                    <?php
                                    $pri_s_rs = Database::search("SELECT COUNT(*) AS `primium` FROM `user_subscription` INNER JOIN `user` ON `user`.`id`=`user_subscription`.`user_id` 
                                    WHERE `user`.`status_id`='1' AND `user_subscription`.`status_id`='1' AND `user_subscription`.`subscription_id`='3' 
                                    AND `user_subscription`.`date_time` LIKE '" . $this_year_month . "%'");
                                    $pri_s_data = $pri_s_rs->fetch_assoc();
                                    ?>
                                    <p class="card-text"><?php echo $pri_s_data["primium"]; ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card">
                                <div class="card-header bg-success text-white fw-bold">Monthly Income</div>
                                <div class="card-body d-flex justify-content-center">
                                    <?php
                                    $basic_price_rs = Database::search("SELECT `subscription`.`price` FROM `subscription` WHERE `subscription`.`id`='1'");
                                    $basic_price_data = $basic_price_rs->fetch_assoc();

                                    $pro_price_rs = Database::search("SELECT `subscription`.`price` FROM `subscription` WHERE `subscription`.`id`='2'");
                                    $pro_price_data = $pro_price_rs->fetch_assoc();

                                    $primium_price_rs = Database::search("SELECT `subscription`.`price` FROM `subscription` WHERE `subscription`.`id`='3'");
                                    $primium_price_data = $primium_price_rs->fetch_assoc();

                                    $price = (doubleval($basic_price_data["price"]) * $b_s_data["basic"]) + (doubleval($pro_price_data["price"]) * $p_s_data["pro"]) + (doubleval($primium_price_data["price"]) * $pri_s_data["primium"]);

                                    ?>
                                    <p class="card-text"><?php echo $price; ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card">
                                <div class="card-header bg-success text-white fw-bold">Total Movies</div>
                                <div class="card-body d-flex justify-content-center">
                                    <?php
                                    $movi_count_rs = Database::search("SELECT COUNT(*) AS `mc` FROM `movie` WHERE `movie`.`status_id`='1'");
                                    $movi_count_data = $movi_count_rs->fetch_assoc();
                                    ?>
                                    <p class="card-text"><?php echo $movi_count_data["mc"]; ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card">
                                <div class="card-header bg-success text-white fw-bold">Total Tv-Series</div>
                                <div class="card-body d-flex justify-content-center">
                                    <?php
                                    $tv_count_rs = Database::search("SELECT COUNT(*) AS `tc` FROM `tv_series` WHERE `tv_series`.`status_id`='1'");
                                    $tv_count_data = $tv_count_rs->fetch_assoc();
                                    ?>
                                    <p class="card-text"><?php echo $tv_count_data["tc"]; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- cards -->

                </div>

                <hr />

                <div class="row" style="margin-top: -2%;">

                    <div class="row row-cols-1 row-cols-md-3 g-4 d-flex justify-content-evenly">

                        <div class="col">
                            <label class="fs-4 mb-3">Heighest Rating Movie</label>
                            <?php
                            $h_r_m_rs = Database::search("SELECT *
                            FROM `movie` INNER JOIN `movie_cover` ON `movie`.`id`=`movie_cover`.`movie_id`
                            WHERE `movie`.`status_id`='1' AND `movie_cover`.`status_id`='1' AND
                             `movie`.`rating` IN(
                            SELECT MAX(`rating`)
                            FROM `movie`
                            WHERE `movie`.`status_id`='1')");

                            $h_r_m_data = $h_r_m_rs->fetch_assoc();

                            ?>
                            <div class="card h-100">
                                <img src="<?PHP echo $h_r_m_data["link"]; ?>" class="card-img-top" style="height:100%" />
                                <div class="card-body">
                                    <h5 class="card-title">Ratings</h5>
                                    <p class="card-text"><?PHP echo $h_r_m_data["rating"]; ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <label class="fs-4 mb-3">Heighest Rating Tv-Series</label>
                            <?php
                            $h_r_tv_rs = Database::search("SELECT *
                            FROM `tv_series` INNER JOIN `tv_series_cover` ON `tv_series`.`id`=`tv_series_cover`.`tv_series_id`
                            WHERE `tv_series`.`status_id`='1' AND `tv_series_cover`.`status_id`='1' AND
                             `tv_series`.`rating` IN(
                            SELECT MAX(`rating`)
                            FROM `tv_series`
                            WHERE `tv_series`.`status_id`='1')");

                            $h_r_tv_data = $h_r_tv_rs->fetch_assoc();

                            ?>
                            <div class="card h-100">
                                <img src="../images/k.jpg" class="card-img-top" style="height:100%" />
                                <div class="card-body">
                                    <h5 class="card-title">Ratings</h5>
                                    <p class="card-text"><?PHP echo $h_r_tv_data["rating"]; ?></p>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>

        <script src="../js/other/dashboard.js"></script>


    </body>

    </html>

<?php
} else {
    header("Location:index.php");
}
?>