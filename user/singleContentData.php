<?php
require "../connection/connection.php";
session_start();

if (!empty($_GET["movie"]) && !empty($_GET["tv"]) && !empty($_GET["code"])) {

    $movie = $_GET["movie"];
    $tv = $_GET["tv"];
    $code = $_GET["code"];

    $type;

    if ($movie == "t") {

        $type = 1;
        $rs = Database::search("SELECT * FROM `movie` WHERE `movie`.`code`='" . $code . "' AND `movie`.`status_id`='1'");
        $data = $rs->fetch_assoc();

        $img_rs = Database::search("SELECT * FROM `movie_cover` WHERE `movie_cover`.`movie_code`='" . $code . "' AND `movie_cover`.`status_id`='1'");
        $img_data = $img_rs->fetch_assoc();
    } else if ($tv == "t") {

        $type = 2;
        $rs = Database::search("SELECT * FROM `tv_series` WHERE `tv_series`.`code`='" . $code . "' AND `tv_series`.`status_id`='1'");
        $data = $rs->fetch_assoc();

        $img_rs = Database::search("SELECT * FROM `tv_series_cover` WHERE `tv_series_cover`.`tv_series_code`='" . $code . "' AND `tv_series_cover`.`status_id`='1'");
        $img_data = $img_rs->fetch_assoc();
    }

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $data["name"]; ?></title>

        <link rel="stylesheet" href="../css/bootstrap/bootstrap.css" />
        <link rel="stylesheet" href="../css/sementic/semantic.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
        <link rel="icon" href="../logo/logo.png" />
    </head>

    <body>
        <div class="container-fluid" style="background-color: black;">
            <div class="row">

                <?php include "header.php"; ?>
                <div class="col-12">
                    <div class="row" id="body">
                        <div class="col-12">
                            <div class="row">

                                <div class="pb-3">
                                    <div class="d-grid gap-3" style="grid-template-columns: 1fr 2fr;">
                                        <div class="bg-light border rounded-3">
                                            <img style="width :500px; height:325px; background-repeat:no-repeat; background-size:cover; background-image:url('<?php echo $img_data["link"]; ?>')" />
                                            <div class="position-absolute d-flex justify-content-center align-items-center" style="margin-top: -70px; width:32.9%; height:10%; background-color: black; opacity:0.8;">
                                                <span class="btn m-0"> <!--favourite-->

                                                    <?php
                                                    if (!empty($_SESSION["user"]) && isset($_SESSION["user"])) {
                                                        $favourite_rs = Database::search("SELECT * FROM `favourite` WHERE `favourite`.`status_id`='1' AND `favourite`.`user_id`='" . $_SESSION["user"]["id"] . "' 
                                                        AND `favourite`.`code`='" . $code . "' AND `favourite`.`type_id`='" . $type . "'");

                                                        if ($favourite_rs->num_rows == 0) { //new

                                                    ?>
                                                            <lord-icon src="https://cdn.lordicon.com/ytuosppc.json" trigger="hover" style="width:45px;height:45px" onclick="favourite('<?php echo $type; ?>','<?php echo $code; ?>');">
                                                            </lord-icon>
                                                        <?php

                                                        } else { //have record
                                                        ?>
                                                            <lord-icon src="https://cdn.lordicon.com/iwaotjbp.json" trigger="hover" colors="primary:#e83a30,secondary:#ebe6ef" style="width:45px;height:45px" onclick="favourite('<?php echo $type; ?>','<?php echo $code; ?>');">
                                                            </lord-icon>
                                                        <?php
                                                        }
                                                    } else {
                                                        ?>
                                                        <lord-icon src="https://cdn.lordicon.com/ytuosppc.json" trigger="hover" style="width:45px;height:45px" onclick="alert('Please LogIn First');">
                                                        </lord-icon>
                                                    <?php
                                                    }

                                                    ?>

                                                </span>
                                                <span class="btn m-0"><!--like-->
                                                    <?php
                                                    if (!empty($_SESSION["user"])) { //loged in

                                                        $user_subscription_rs = Database::search("SELECT * FROM `user_subscription` INNER JOIN `subscription` 
                                                        ON `subscription`.`id`=`user_subscription`.`subscription_id`
                                                        INNER JOIN `user` ON `user`.`id`=`user_subscription`.`user_id` 
                                                        WHERE `user`.`id`='" . $_SESSION["user"]["id"] . "' AND `user_subscription`.`status_id`='1'");
                                                        if ($user_subscription_rs->num_rows == 1) {
                                                            // $nosubdata = false;
                                                            $user_subscription_data = $user_subscription_rs->fetch_assoc();
                                                        } else {
                                                            // $nosubdata = true;
                                                        }
                                                    }

                                                    // if ($nosubdata == false) {
                                                    if (!empty($_SESSION["user"]) && $user_subscription_data["subscription_id"] != 1) { //log in not basic

                                                        $reaction_rs = Database::search("SELECT * FROM `reaction` WHERE `reaction`.`status_id`='1' AND `reaction`.`user_id`='" . $_SESSION["user"]["id"] . "'
                                                            AND `reaction`.`type_id`='" . $type . "' AND `reaction`.`code`='" . $code . "' AND `reaction`.`like`='1'");

                                                        if ($reaction_rs->num_rows == 1) {
                                                    ?>
                                                            <img src="../icon/thumred.png" style="width:45px;height:35px" onclick="like('<?php echo $type; ?>','<?php echo $code; ?>');" />
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <img src="../icon/thumb up.svg" style="width:45px;height:45px" onclick="like('<?php echo $type; ?>','<?php echo $code; ?>');" />

                                                        <?php
                                                        }
                                                    } else if (!empty($_SESSION["user"]) && $user_subscription_data["subscription_id"] == 1) { //loged in basic
                                                        ?>
                                                        <img src="../icon/thumb up.svg" style="width:45px;height:45px" onclick="window.location.href='price.php';" />

                                                    <?php
                                                    } else {
                                                    ?>
                                                        <img src="../icon/thumb up.svg" style="width:45px;height:45px" onclick="alert('LogIn First');" />

                                                    <?php
                                                    }
                                                    // }
                                                    ?>
                                                </span>
                                                <span class="btn m-0"><!--un like-->
                                                    <?php
                                                    // if ($nosubdata == false) {
                                                    if (!empty($_SESSION["user"]) && $user_subscription_data["subscription_id"] != 1) {

                                                        $reaction_rs = Database::search("SELECT * FROM `reaction` WHERE `reaction`.`status_id`='1' AND `reaction`.`user_id`='" . $_SESSION["user"]["id"] . "'
                                                        AND `reaction`.`type_id`='" . $type . "' AND `reaction`.`code`='" . $code . "' AND `reaction`.`dis_like`='1'");

                                                        if ($reaction_rs->num_rows == 1) {
                                                    ?>
                                                            <lord-icon src="https://cdn.lordicon.com/wwneckwc.json" trigger="hover" colors="primary:#c71f16,secondary:#e83a30" style="width:50px;height:50px" onclick="unlike('<?php echo $type; ?>','<?php echo $code; ?>');">
                                                            </lord-icon>
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <lord-icon src="https://cdn.lordicon.com/gclzwloa.json" trigger="hover" style="width:50px;height:50px" onclick="unlike('<?php echo $type; ?>','<?php echo $code; ?>');">
                                                            </lord-icon>
                                                        <?php
                                                        }
                                                    } else if (!empty($_SESSION["user"]) && $user_subscription_data["subscription_id"] == 1) {
                                                        ?>
                                                        <lord-icon src="https://cdn.lordicon.com/gclzwloa.json" trigger="hover" style="width:50px;height:50px" onclick="window.location.href='price.php';">
                                                        </lord-icon>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <lord-icon src="https://cdn.lordicon.com/gclzwloa.json" trigger="hover" style="width:50px;height:50px" onclick="alert('LogIn First');">
                                                        </lord-icon>
                                                    <?php
                                                    }
                                                    // }
                                                    ?>
                                                </span>
                                                <span class="btn m-0"><!--add to cart-->
                                                    <?php
                                                    if (!empty($_SESSION["user"])) {

                                                        $cart_rs = Database::search("SELECT * FROM `cart` WHERE `cart`.`status_id`='1' AND `cart`.`user_id`='" . $_SESSION["user"]["id"] . "'
                                                        AND `cart`.`type_id`='" . $type . "' AND `cart`.`code`='" . $code . "'");

                                                        if ($cart_rs->num_rows == 1) {
                                                    ?>
                                                            <lord-icon src="https://cdn.lordicon.com/ggihhudh.json" trigger="hover" colors="primary:#ffffff,secondary:#911710,tertiary:#e83a30" style="width:50px;height:50px" onclick="addToCart('<?php echo $type; ?>','<?php echo $code; ?>');">
                                                            </lord-icon>
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <lord-icon src="https://cdn.lordicon.com/lpddubrl.json" trigger="hover" style="width:50px;height:50px" onclick="addToCart('<?php echo $type; ?>','<?php echo $code; ?>');">
                                                            </lord-icon>
                                                        <?php
                                                        }
                                                    } else {
                                                        ?>
                                                        <lord-icon src="https://cdn.lordicon.com/lpddubrl.json" trigger="hover" style="width:50px;height:50px" onclick="alert('LogIn First');">
                                                        </lord-icon>
                                                    <?php
                                                    }
                                                    ?>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="column ">
                                            <div class="bg-dark text-white border rounded-3">
                                                <span class="ui red right ribbon label">
                                                    <i class="bi bi-hand-thumbs-up-fill"></i>&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <?php
                                                    $like_rs = Database::search("SELECT SUM(`like`) AS `like` FROM `reaction` WHERE `reaction`.`status_id`='1' AND `reaction`.`type_id`='" . $type . "' 
                                                    AND `reaction`.`code`='" . $data["code"] . "'");

                                                    $like_data = $like_rs->fetch_assoc();

                                                    $dis_like_rs = Database::search("SELECT SUM(`dis_like`) AS `dis_like` FROM `reaction` WHERE `reaction`.`status_id`='1' AND `reaction`.`type_id`='" . $type . "' 
                                                    AND `reaction`.`code`='" . $data["code"] . "'");

                                                    $dis_like_data = $dis_like_rs->fetch_assoc();
                                                    ?>
                                                    <?php echo $like_data["like"]; ?>/<?php echo intval($dis_like_data["dis_like"]) + intval($like_data["like"]); ?>&nbsp;&nbsp;&nbsp;&nbsp;
                                                </span>
                                                <table class="ms-2" <?php
                                                                    if ($type == 1) {
                                                                    ?> style="margin-top: -3%;" <?php
                                                                                            }
                                                                                                ?>>
                                                    <thead>
                                                        <th class="fs-2"><?php echo strtoupper($data["name"]); ?></th>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td class="col-2 ps-4 pt-3">Released Date :</td>
                                                            <td class="pt-3">
                                                                <?php
                                                                $date = explode(" ", $data["date_time"]);
                                                                echo $date["0"];
                                                                ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="col-2 ps-4">Directed By :</td>
                                                            <td><?php echo $data["director"]; ?></td>
                                                        </tr>
                                                        <?php
                                                        if ($type == 1) {

                                                            $length_rs = Database::search("SELECT * FROM `movie_url` INNER JOIN `movie` 
                                                            ON `movie`.`id`=`movie_url`.`movie_id` WHERE `movie`.`id`='" . $data["id"] . "'");

                                                            $length_data = $length_rs->fetch_assoc();
                                                        ?>
                                                            <tr>
                                                                <td class="col-2 ps-4">Length :</td>
                                                                <td><?php echo $length_data["lenght"]; ?></td>
                                                            </tr>
                                                        <?php
                                                        }
                                                        ?>

                                                        <tr>
                                                            <td class="col-2 ps-4 align-top">Description :</td>
                                                            <td><?php echo $data["description"]; ?></td>
                                                        </tr>
                                                    </tbody>
                                                </table>

                                                <div class="row mt-4 ms-4">
                                                    <?php

                                                    if ($movie == "t") {
                                                        $download_rs = Database::search("SELECT * FROM `movie_url` WHERE `movie_url`.`movie_id`='" . $data["id"] . "'");
                                                        $download_data = $download_rs->fetch_assoc();
                                                    ?>
                                                        <span class="btn btn-primary col-3 d-grid ms-3" onclick="movie('<?php echo $type; ?>','<?php echo $data['code']; ?>'<?php
                                                                                                                                                                            if (isset($_GET['b']) && !empty($_GET['b'])) {
                                                                                                                                                                            ?>
                                                            ,'<?php echo $_GET['b']; ?>'
                                                            <?php
                                                                                                                                                                            }
                                                            ?>);">Watch Online</span>
                                                        <?php
                                                        if (!empty($_SESSION["user"])) { //loged in

                                                            if (isset($_GET["b"]) && !empty($_GET["b"])) { //bought

                                                        ?>
                                                                <a class="btn btn-warning col-3 d-grid ms-3" id="movieDownloadA" onclick="downloadMovie('<?php echo $type; ?>','<?php echo $data['code']; ?>')">Download</a>
                                                                <?php

                                                            } else {

                                                                if ($user_subscription_data["subscription_id"] == "1") { //basic user
                                                                ?>
                                                                    <a class="btn btn-warning col-3 d-grid ms-3" href="price.php">Download</a>
                                                                    <?php
                                                                } else {
                                                                    $download_rs = Database::search("SELECT * FROM `download` 
                                                                    WHERE `download`.`user_id`='" . $_SESSION["user"]["id"] . "' AND `download`.`status_id`='1'");

                                                                    if ($download_rs->num_rows > 0) { //has priviously downloaded

                                                                        $this_date_time = new DateTime();
                                                                        $tz = new DateTimeZone("Asia/Colombo");
                                                                        $this_date_time->setTimezone($tz);

                                                                        $year = $this_date_time->format("Y");
                                                                        $month = $this_date_time->format("m");

                                                                        $downloaded_count = 0;

                                                                        for ($x = 0; $x < $download_rs->num_rows; $x++) {

                                                                            $downloaded_data = $download_rs->fetch_assoc();

                                                                            $downloaded_date_time = strtotime($downloaded_data["date_time"]);
                                                                            $downloaded_month = date("m", $downloaded_date_time);
                                                                            $downloaded_year = date("Y", $downloaded_date_time);

                                                                            if ($downloaded_year == $year) {
                                                                                if ($downloaded_month == $month) {

                                                                                    $downloaded_count++;
                                                                                }
                                                                            }
                                                                        }

                                                                        $subscription_rs = Database::search("SELECT * FROM `user_subscription` INNER JOIN `subscription` ON `subscription`.`id`=`user_subscription`.`subscription_id`
                                                                        WHERE `subscription`.`status_id`='1' AND `user_subscription`.`user_id`='" . $_SESSION["user"]["id"] . "' AND `user_subscription`.`status_id`='1' ");

                                                                        $subscription_data = $subscription_rs->fetch_assoc();

                                                                        $download_limit_rs = Database::search("SELECT * FROM `subscription` WHERE `subscription`.`id`='" . $subscription_data["subscription_id"] . "'");
                                                                        $download_limit_data = $download_limit_rs->fetch_assoc();

                                                                        if ($downloaded_count > $download_limit_data["download_limit"]) {
                                                                    ?>
                                                                            <a class="btn btn-warning col-3 d-grid ms-3" id="movieDownloadA" onclick="alert('Your Download Limit Has Been Reached');">Download</a>
                                                                        <?php
                                                                        } else {
                                                                        ?>
                                                                            <a class="btn btn-warning col-3 d-grid ms-3" id="movieDownloadA" onclick="downloadMovie('<?php echo $type; ?>','<?php echo $data['code']; ?>')">Download</a>
                                                                        <?php
                                                                        }
                                                                    } else {
                                                                        ?>
                                                                        <a class="btn btn-warning col-3 d-grid ms-3" id="movieDownloadA" onclick="downloadMovie('<?php echo $type; ?>','<?php echo $data['code']; ?>')">Download</a>
                                                                    <?php
                                                                    }
                                                                    ?>

                                                            <?php
                                                                }
                                                            }
                                                        } else {
                                                            ?>
                                                            <a class="btn btn-warning col-3 d-grid ms-3" onclick="alert('Please Log In First');">Download</a>
                                                        <?php
                                                        }
                                                        ?>
                                                    <?php
                                                    } else if ($tv == "t") {
                                                        $download_rs = Database::search("SELECT * FROM `episode` WHERE `episode`.`tv_series_id`='" . $data["id"] . "'");
                                                        $download_data = $download_rs->fetch_assoc();
                                                    ?>
                                                        <span class="btn btn-primary col-3 d-grid ms-3" onclick="selectEpi();">Watch Online</span>
                                                        <?php
                                                        // if ($nosubdata == false) {
                                                        if (!empty($_SESSION["user"])) { //loged in

                                                            if (isset($_GET["b"]) && !empty($_GET["b"])) { //bought

                                                        ?>
                                                                <a class="btn btn-warning col-3 d-grid ms-3" id="spiDownId" onclick="downloadEpisodeSelect()">Download</a>
                                                                <?php

                                                            } else {

                                                                if ($user_subscription_data["subscription_id"] == "1") { //basic user
                                                                ?>
                                                                    <a class="btn btn-warning col-3 d-grid ms-3" href="price.php">Download</a>
                                                                    <?php
                                                                } else {

                                                                    $download_rs = Database::search("SELECT * FROM `download` 
                                                                    WHERE `download`.`user_id`='" . $_SESSION["user"]["id"] . "' AND `download`.`status_id`='1'");

                                                                    if ($download_rs->num_rows > 0) { //has priviously downloaded

                                                                        $this_date_time = new DateTime();
                                                                        $tz = new DateTimeZone("Asia/Colombo");
                                                                        $this_date_time->setTimezone($tz);

                                                                        $year = $this_date_time->format("Y");
                                                                        $month = $this_date_time->format("m");

                                                                        $downloaded_count = 0;

                                                                        for ($x = 0; $x < $download_rs->num_rows; $x++) {

                                                                            $downloaded_data = $download_rs->fetch_assoc();

                                                                            $downloaded_date_time = strtotime($downloaded_data["date_time"]);
                                                                            $downloaded_month = date("m", $downloaded_date_time);
                                                                            $downloaded_year = date("Y", $downloaded_date_time);

                                                                            if ($downloaded_year == $year) {
                                                                                if ($downloaded_month == $month) {

                                                                                    $downloaded_count++;
                                                                                }
                                                                            }
                                                                        }

                                                                        $subscription_rs = Database::search("SELECT * FROM `user_subscription` INNER JOIN `subscription` ON `subscription`.`id`=`user_subscription`.`subscription_id`
                                                                        WHERE `subscription`.`status_id`='1' AND `user_subscription`.`user_id`='" . $_SESSION["user"]["id"] . "' AND `user_subscription`.`status_id`='1' ");

                                                                        $subscription_data = $subscription_rs->fetch_assoc();


                                                                        $download_limit_rs = Database::search("SELECT * FROM `subscription` WHERE `subscription`.`id`='" . $subscription_data["subscription_id"] . "'");
                                                                        $download_limit_data = $download_limit_rs->fetch_assoc();

                                                                        if ($downloaded_count > $download_limit_data["download_limit"]) {
                                                                    ?>
                                                                            <a class="btn btn-warning col-3 d-grid ms-3" id="spiDownId" onclick="alert('Your Download Limit Has Been Reached');">Download</a>
                                                                        <?php
                                                                        } else {
                                                                        ?>
                                                                            <a class="btn btn-warning col-3 d-grid ms-3" id="spiDownId" onclick="downloadEpisodeSelect()">Download</a>
                                                                        <?php
                                                                        }
                                                                    } else {
                                                                        ?>
                                                                        <a class="btn btn-warning col-3 d-grid ms-3" id="spiDownId" onclick="downloadEpisodeSelect()">Download</a>
                                                                    <?php
                                                                    }

                                                                    ?>
                                                            <?php
                                                                }
                                                            }
                                                        } else {
                                                            ?>
                                                            <a class="btn btn-warning col-3 d-grid ms-3" onclick="alert('Please Log In First');">Download</a>
                                                        <?php
                                                        }
                                                        // }
                                                        ?>
                                                    <?php
                                                    }
                                                    ?>
                                                    <!-- <span class="btn btn-success col-3 d-grid ms-3" type="submit" id="payhere-payment" onclick="pay();">Buy</span> -->
                                                </div>

                                                <div class="row mt-4 ms-4">
                                                    <div class="col-5">
                                                        <div class="row">
                                                            <?php
                                                            if ($tv == "t") {

                                                            ?>
                                                                <select class="form-control d-none" onchange="tv_episode(value,'<?php echo $type; ?>','<?php echo $data['code'] ?>'<?php
                                                                                                                                                                                    if (isset($_GET['b']) && !empty($_GET['b'])) {
                                                                                                                                                                                    ?>
                                                                    ,'<?php echo $_GET['b']; ?>'
                                                                    <?php
                                                                                                                                                                                    }
                                                                    ?>);" id="epiSelect">
                                                                    <option>Select Episode</option>
                                                                    <?php

                                                                    $url_rs = Database::search("SELECT * FROM `episode` WHERE `episode`.`tv_series_id`='" . $data["id"] . "'");
                                                                    $url_num = $url_rs->num_rows;
                                                                    for ($y = 0; $y < $url_num; $y++) {
                                                                        $url_data = $url_rs->fetch_assoc();
                                                                    ?>
                                                                        <!-- <option value="<?php echo $url_data["url"]; ?>"><?php echo $url_data["name"] ?></option> -->
                                                                        <option value="<?php echo $url_data["id"]; ?>"><?php echo $url_data["name"] ?></option>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </select>

                                                                <select class="form-control d-none" onchange="downloadEpisode('<?php echo $type; ?>','<?php echo $data['code'] ?>');" id="epiSelectDownload">
                                                                    <option>Select Episode</option>
                                                                    <?php

                                                                    $url_rs = Database::search("SELECT * FROM `episode` WHERE `episode`.`tv_series_id`='" . $data["id"] . "'");
                                                                    $url_num = $url_rs->num_rows;
                                                                    for ($y = 0; $y < $url_num; $y++) {
                                                                        $url_data = $url_rs->fetch_assoc();
                                                                    ?>
                                                                        <!-- <option value="<?php echo $url_data["url"]; ?>"><?php echo $url_data["name"] ?></option> -->
                                                                        <option value="<?php echo $url_data["id"]; ?>"><?php echo $url_data["name"] ?></option>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </select>
                                                            <?php

                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="col-12" id="cont">
                                    <div class="row">

                                        <?php

                                        if ($movie == "t") {

                                            // $url_rs = Database::search("SELECT * FROM `movie_url` WHERE `movie_url`.`movie_id`='" . $data["id"] . "'");
                                            // $url_data = $url_rs->fetch_assoc();

                                        ?>

                                            <div class="container-fluid pb-3 d-none" id="movieDiv">
                                                <div class="d-grid gap-3">
                                                    <div class="bg-light border rounded-3">

                                                        <iframe id="movieSource" width="100%" height="500" src="" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                                                        <!-- use below when video is in the project -->

                                                        <!-- <video width="100%" controls autoplay poster="<?php echo $img_data["link"]; ?>" id="movieSource">
                                                            <source src="" type="">
                                                        </video> -->

                                                    </div>
                                                </div>
                                            </div>

                                        <?php

                                        } else if ($tv == "t") {
                                        ?>

                                            <div class="container-fluid pb-3 d-none" id="epiDiv">
                                                <div class="d-grid gap-3">
                                                    <div class="bg-light border rounded-3">


                                                        <iframe id="epi" width="100%" height="500" src="" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>

                                                        <!-- use below when video is in the project -->
                                                        <!-- <video width="100%" controls autoplay id="epi"  poster="<?php echo $img_data["link"]; ?>">
                                                            <source src="" type="" >
                                                        </video> -->

                                                    </div>
                                                </div>
                                            </div>

                                        <?php
                                        }

                                        ?>


                                    </div>
                                </div>

                            </div>

                        </div>

                        <!-- comments -->
                        <div class="col-12 my-5 ">
                            <div class="row">

                                <?php

                                $comment_rs = Database::search("SELECT * FROM `comment` WHERE `comment`.`type_id`='" . $type . "' AND `code`='" . $code . "' AND `comment`.`status_id`='1' ORDER BY `comment`.`date_time` DESC");
                                $comment_num = $comment_rs->num_rows;

                                if ($comment_num > 0) {

                                ?>

                                    <div class="ui comments ms-5">
                                        <h3 class="ui dividing header text-white" style="margin-left: -20px;">Comments</h3>
                                        <span class="row d-flex flex-row align-items-start" style="max-height:350px; overflow-y: scroll;">

                                            <?php

                                            for ($z = 0; $z < $comment_num; $z++) {
                                                $comment_data = $comment_rs->fetch_assoc();

                                                $user_rs = Database::search("SELECT * FROM `user` INNER JOIN `profile_image` ON `user`.`id`=`profile_image`.`user_id` 
                                                WHERE `user`.`id`='" . $comment_data["user_id"] . "'");
                                                $user_data = $user_rs->fetch_assoc();
                                            ?>

                                                <div class="comment bg-dark px-4 py-2 rounded
                                                <?php
                                                if (!empty($_SESSION["user"])) { //loged in
                                                ?>
                                                <?php
                                                    if ($comment_data["user_id"] != $_SESSION["user"]["id"]) {
                                                ?>
                                                    d-flex justify-content-start
                                                    <?php
                                                    } else {
                                                    ?>
                                                    d-flex justify-content-start align-items-center 
                                                    <?php
                                                    }
                                                }
                                                    ?>">

                                                    <a class="avatar mt-0 pt-0
                                                    <?php
                                                    if (empty($_SESSION["user"])) {
                                                    ?>
                                                        me-3
                                                        <?php
                                                    }
                                                        ?>" style="margin-left: -5%;">
                                                        <img src="<?php echo $user_data["link"]; ?>" style="width:50px; margin-right: -100%;">
                                                    </a>

                                                    <div class="content">
                                                        <a class="author  text-white"><?php echo $user_data["first_name"] . " " . $user_data["last_name"]; ?></a>
                                                        <div class="metadata">
                                                            <div class="date  text-white"><?php echo $comment_data["date_time"]; ?></div>
                                                        </div>
                                                        <div class="text  text-white" id="commentText<?php echo $comment_data["id"]; ?>">
                                                            <?php echo $comment_data["comment"]; ?>
                                                        </div>
                                                    </div>
                                                    <?php
                                                    if (!empty($_SESSION["user"])) { //loged in
                                                        if ($comment_data["user_id"] == $_SESSION["user"]["id"]) {
                                                    ?>
                                                            <lord-icon src="https://cdn.lordicon.com/edxgdhxu.json" trigger="hover" style="width:38px;height:38px; right:0px; margin-left: auto;" onclick="loadComment('<?php echo $comment_data['id']; ?>');">
                                                            </lord-icon>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </div>

                                            <?php
                                            }

                                            ?>
                                        </span>

                                        <!-- add comment -->
                                        <form class="ui reply form">
                                            <?php
                                            if (!empty($_SESSION["user"])) { //loged in
                                                if ($user_subscription_data["subscription_id"] == "1") {

                                            ?>

                                                    <div class="ui primary submit labeled icon button" onclick="window.location.href='price.php'">
                                                        <img style="margin-left: -40px; margin-right: 10px;" src="https://img.icons8.com/external-prettycons-flat-prettycons/20/000000/external-send-social-media-prettycons-flat-prettycons.png" /> <span id="sendCommentBtn">Add Comment</span>
                                                    </div>

                                                <?php

                                                } else {
                                                ?>

                                                    <div class="field">
                                                        <textarea id="new_comment" class="bg-dark text-white"></textarea>
                                                    </div>
                                                    <div class="ui primary submit labeled icon button" onclick="addC('<?php echo $type; ?>','<?php echo $code; ?>','<?php echo $comment_data['id']; ?>');">
                                                        <img style="margin-left: -40px; margin-right: 10px;" src="https://img.icons8.com/external-prettycons-flat-prettycons/20/000000/external-send-social-media-prettycons-flat-prettycons.png" /> <span id="sendCommentBtn">Add Comment</span>
                                                    </div>

                                                <?php
                                                }
                                            } else {
                                                ?>
                                                <div class="ui primary submit labeled icon button" onclick="alert('Please Log In First');">
                                                    <img style="margin-left: -40px; margin-right: 10px;" src="https://img.icons8.com/external-prettycons-flat-prettycons/20/000000/external-send-social-media-prettycons-flat-prettycons.png" /> <span id="sendCommentBtn">Add Comment</span>
                                                </div>
                                            <?php
                                            }
                                            ?>

                                        </form>
                                    </div>

                                <?php

                                } else {
                                ?>
                                    <div class="ui comments">
                                        <h3 class="ui dividing header text-white">Comments</h3>

                                        <div class="comment">
                                            <label class="form-label text-secondary">No Comments Availiable</label>
                                        </div>

                                        <!-- add comment -->
                                        <form class="ui reply form">
                                            <div class="field">
                                                <textarea id="new_comment" class="bg-dark text-white"></textarea>
                                            </div>
                                            <div class="ui primary submit labeled icon button" onclick="addC('<?php echo $type; ?>','<?php echo $code; ?>','<?php echo $comment_data['id']; ?>');">
                                                <i class="icon edit"></i> <span id="sendCommentBtn">Add Comment</span>
                                            </div>
                                        </form>
                                    </div>

                                <?php
                                }

                                ?>



                                <div class="ui comments mt-0 pt-0 ms-5 ps-5 border border-0 border-start border-secondary">

                                    <h3 class="ui dividing header text-white">Suggestions</h3>
                                    <div class="comment">

                                        <!-- card -->
                                        <div class="row row-cols-1 row-cols-md-3 g-4 ms-5" style="height:300px; width:650px; overflow-y: scroll;z-index: 10; ">
                                            <?php
                                            $suggestion_rs = Database::search("((SELECT * FROM `movie` ORDER BY RAND() LIMIT 10) UNION (SELECT * FROM `tv_series` ORDER BY RAND() LIMIT 10)) ORDER BY RAND()");
                                            if ($suggestion_rs->num_rows > 0) {
                                                for ($s = 0; $s < $suggestion_rs->num_rows; $s++) {
                                                    $suggestion_data = $suggestion_rs->fetch_assoc();

                                                    $s_type_rs = Database::search("SELECT * FROM `movie` WHERE `movie`.`code`='" . $suggestion_data["code"] . "' AND `movie`.`status_id`='1'");
                                                    if ($s_type_rs->num_rows == 1) { //movie

                                                        $movie_cover_rs = Database::search("SELECT * FROM `movie` 
                                                        INNER JOIN `movie_cover` ON `movie`.`id`=`movie_cover`.`movie_id` 
                                                        WHERE `movie`.`code`='" . $suggestion_data["code"] . "' AND `movie`.`status_id`='1'");
                                                        $movie_cover_data = $movie_cover_rs->fetch_assoc();
                                            ?>
                                                        <div class="col" onclick="singleContentLoad('m','<?php echo $suggestion_data['code']; ?>');">
                                                            <div style="width:200px; height:125px;">
                                                                <img src="<?php echo $movie_cover_data["link"]; ?>" class="card-img-top h-100" />
                                                            </div>
                                                        </div>
                                                        <?php
                                                    } else {
                                                        $s_type_rs = Database::search("SELECT * FROM `tv_series` WHERE `tv_series`.`code`='" . $suggestion_data["code"] . "' AND `tv_series`.`status_id`='1'");
                                                        if ($s_type_rs->num_rows == 1) { //tv

                                                            $tv_series_cover_rs = Database::search("SELECT * FROM `tv_series` 
                                                            INNER JOIN `tv_series_cover` ON `tv_series`.`id`=`tv_series_cover`.`tv_series_id` 
                                                            WHERE `tv_series`.`code`='" . $suggestion_data["code"] . "' AND `tv_series`.`status_id`='1'");
                                                            $tv_series_cover_data = $tv_series_cover_rs->fetch_assoc();
                                                        ?>
                                                            <div class="col" onclick="singleContentLoad('t','<?php echo $suggestion_data['code']; ?>');">
                                                                <div style="width:200px; height:125px;">
                                                                    <img src="<?php echo $tv_series_cover_data["link"]; ?>" class="card-img-top h-100" />
                                                                </div>
                                                            </div>
                                            <?php
                                                        }
                                                    }
                                                }
                                            }
                                            ?>
                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>
                    </div>
                </div>

                <?php
                if (!empty($_SESSION["user"])) {
                ?>
                    <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 20;">
                        <div id="liveToast2" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                            <div class="toast-header bg-warning text-white">
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


                <?php include "../common/footer.php"; ?>

            </div>
        </div>

        <script type="text/javascript" src="https://www.payhere.lk/lib/payhere.js"></script>
        <script src="https://cdn.lordicon.com/ritcuqlt.js"></script>
        <script src="../js/other/singleContent.js"></script>
    </body>

    </html>

<?php

} else {
?>
    <script>
        alert("Something went wrong");
        window.location.href = 'index.php';
    </script>
<?php
}


?>