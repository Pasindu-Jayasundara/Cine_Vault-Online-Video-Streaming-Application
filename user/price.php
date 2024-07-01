<?php
require "../connection/connection.php";
session_start();

$shop_rs = Database::search("SELECT * FROM `shop`");
$shop_data = $shop_rs->fetch_assoc();
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo $shop_data["name"]; ?> | Subscriptions</title>

    <link rel="stylesheet" href="../css/bootstrap/bootstrap.min.css" />
    <link rel="stylesheet" href="../css/other/price.css" />
    <link rel="icon" href="<?php echo $shop_data["logo_link"]; ?>" />
</head>

<body>

    <div class="container-fluid bg-black text-white">
        <div class="row">
            <?php include "../user/header.php"; ?>

            <div class="col-12">
                <div class="row d-flex justify-content-center">
                    <div class="col-8">
                        <div class="row">

                            <!-- descriptions -->
                            <div class="pricing-header p-3 pb-md-4 mx-auto text-center ">
                                <h1 class="display-4 fw-normal" data-aos="fade-down" data-aos-easing="linear" data-aos-duration="700">Subscription Plans</br></br></h1>
                                <?php
                                $pro_rs = Database::search("SELECT * FROM `subscription` WHERE `subscription`.`status_id`='1' AND `subscription`.`id`='2'");
                                $pro_data = $pro_rs->fetch_assoc();

                                $pri_rs = Database::search("SELECT * FROM `subscription` WHERE `subscription`.`status_id`='1' AND `subscription`.`id`='3'");
                                $pri_data = $pri_rs->fetch_assoc();
                                ?>
                                <p class="fs-6 text-white" data-aos="fade-up" data-aos-duration="3000">
                                    Welcome to the pricing page for CineVault Movie, your one-stop destination for all the latest and greatest films. We offer a variety of subscription options to suit your needs, whether you're a casual movie-watcher or a die-hard film buff.
                                    </br>
                                <ul class="text-start text-warning mt-5 py-5">
                                    <li class="mb-3" data-aos="fade-up" data-aos-duration="3000">
                                        <?php echo $pro_data["type"]; ?> plan includes access to our extensive library of classic and independent films, with new titles added every month. For $<?php echo $pro_data["price"]; ?> per month, you can watch as many movies as you want, whenever you want.
                                    </li>
                                    <li data-aos="fade-up" data-aos-duration="3000">
                                        <?php echo $pri_data["type"]; ?> plan offers everything in the Basic plan, plus the newest blockbuster releases and exclusive content. For $<?php echo $pri_data["price"]; ?> per month, you'll have access to all the biggest films as soon as they become available.
                                    </li>
                                </ul>
                                </p>
                            </div>

                            <!-- scroll btn -->
                            <span class="button-76 col-2" id="scrollBtn">Prices<i class="bi bi-arrow-down"></i></span>

                            <!-- price card -->
                            <div class="row row-cols-1 row-cols-md-3 mb-3 text-center ">
                                <?php

                                $subscription_rs = Database::search("SELECT * FROM `subscription` WHERE `subscription`.`status_id`='1'");
                                $subscription_num = $subscription_rs->num_rows;

                                if (isset($_SESSION["user"])) {

                                    $active_rs = Database::search("SELECT * FROM `user_subscription` WHERE `user_subscription`.`user_id`='" . $_SESSION["user"]["id"] . "' 
                                AND `user_subscription`.`status_id`='1'");

                                    $active_data = $active_rs->fetch_assoc();
                                }

                                for ($x = 0; $x < $subscription_num; $x++) {
                                    $subscription_data = $subscription_rs->fetch_assoc();

                                    $time_period_rs = Database::search("SELECT * FROM `subscription_time_period` WHERE `subscription_time_period`.`id`='" . $subscription_data["subscription_time_period_id"] . "'");
                                    $time_period_data = $time_period_rs->fetch_assoc();

                                    $active_sub;
                                    if (isset($active_data) && $active_data["subscription_id"] == $subscription_data["id"]) {
                                        $active_sub = true;
                                    } else {
                                        $active_sub = false;
                                    }
                                ?>
                                    <div class="col" data-aos="flip-left" data-aos-easing="ease-out-cubic" data-aos-duration="2000">
                                        <div class="card mb-4 rounded-3 shadow-sm <?php
                                                                                    if ($active_sub == true) {
                                                                                    ?>
                                            bg-success
                                            <?php
                                                                                    } else {
                                            ?>
                                            bg-dark
                                            <?php
                                                                                    }
                                            ?> text-white border-info">
                                            <div class="card-header py-3 bg-black">
                                                <h4 class="my-0 fw-normal"><?php echo $subscription_data["type"]; ?></h4>
                                            </div>
                                            <div class="card-body">
                                                <h1 class="card-title pricing-card-title">$<?php echo $subscription_data["price"]; ?><small class="text-muted fw-light"><?php echo $time_period_data["short_form"]; ?></small></h1>
                                                <ul class="list-unstyled mt-3 mb-4">
                                                    <?php

                                                    $features_rs = Database::search("SELECT * FROM `subscription_features` INNER JOIN `subscription_has_subscription_features` 
                                                    ON `subscription_features`.`id`=`subscription_has_subscription_features`.`subscription_features_id` INNER JOIN `subscription` 
                                                    ON `subscription_has_subscription_features`.`subscription_id`=`subscription`.`id` WHERE `subscription_features`.`status_id`='1' 
                                                    AND `subscription`.`id`='" . $subscription_data["id"] . "'
                                                    ORDER BY `subscription_features`.`date_time` ASC");

                                                    $features_num = $features_rs->num_rows;
                                                    if ($features_num > 0) {
                                                        for ($y = 0; $y < $features_num; $y++) {
                                                            $features_data = $features_rs->fetch_assoc();

                                                    ?>
                                                            <li><?php echo $features_data["feature"]; ?></li>
                                                    <?php

                                                        }
                                                    }

                                                    ?>
                                                </ul>
                                                <span class="w-100 btn btn-lg <?php
                                                                                if ($active_sub == true) {
                                                                                ?>
                                                    btn-dark
                                                    <?php
                                                                                } else {
                                                    ?>
                                                    btn-outline-primary
                                                    <?php
                                                                                }
                                                    ?> " id="payhere-payment" onclick="subscription('<?php echo $subscription_data['id']; ?>');"><?php
                                                                                                                                                    if ($active_sub == true) {
                                                                                                                                                    ?>
                                                        Active
                                                    <?php
                                                                                                                                                    } else {
                                                    ?>
                                                        Sign up
                                                    <?php
                                                                                                                                                    }
                                                    ?></span>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                }

                                ?>
                            </div>


                            <!-- conpare plans -->

                            <h2 class="display-6 text-center mb-4 mt-5" data-aos="fade-up" data-aos-anchor-placement="top-bottom">Comparison Of Features</h2>

                            <div class="table-responsive ">
                                <?php

                                $subscription_time_period_rs = Database::search("SELECT * FROM `subscription`");
                                $subscription_time_period_num = $subscription_time_period_rs->num_rows;

                                if ($subscription_time_period_num > 0) {

                                ?>
                                    <table data-aos="zoom-in" class="table text-center text-white bg-dark border-info">
                                        <thead class="border-info">
                                            <tr>
                                                <th style="width: 34%;"></th>
                                                <?php
                                                for ($x = 0; $x < $subscription_time_period_num; $x++) {
                                                    $subscription_time_period_data = $subscription_time_period_rs->fetch_assoc();
                                                ?>
                                                    <th style="width: 22%;"><?php echo $subscription_time_period_data["type"]; ?></th>
                                                <?php
                                                }
                                                ?>
                                            </tr>
                                        </thead>
                                        <tbody class="border-info">
                                            <?php

                                            $features_rs = Database::search("SELECT * FROM `subscription_features` INNER JOIN `subscription_has_subscription_features` 
                                            ON `subscription_features`.`id`=`subscription_has_subscription_features`.`subscription_features_id` INNER JOIN `subscription` 
                                            ON `subscription_has_subscription_features`.`subscription_id`=`subscription`.`id` WHERE `subscription_features`.`status_id`='1' 
                                            AND `subscription`.`id`='" . $subscription_data["id"] . "'
                                            ORDER BY `subscription_features`.`date_time` ASC");

                                            $features_num = $features_rs->num_rows;
                                            for ($y = 0; $y < $features_num; $y++) {
                                                $features_data = $features_rs->fetch_assoc();
                                            ?>
                                                <tr>
                                                    <th scope="row" class="text-start"><?php echo $features_data["feature"]; ?></th>
                                                    <td>X</td>
                                                    <td>&check;</td>
                                                    <td>&check;</td>
                                                </tr>
                                            <?php
                                            }

                                            ?>
                                        </tbody>
                                    </table>
                                <?php

                                }

                                ?>
                            </div>

                        </div>

                    </div>


                    <!-- notification -->
                    <div class="toast-container position-fixed bottom-0 end-0 p-3">
                        <div id="liveToast2" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                            <div class="toast-header text-black" id="headerColor2">

                                <strong class="me-auto text-white">Message</strong>
                                <small id="time2"></small>
                                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                            </div>
                            <div class="toast-body text-black" id="msg2">

                            </div>
                        </div>
                    </div>


                </div>
            </div>

            <?php include "../common/footer.php"; ?>
        </div>
    </div>


    <script src="../js/other/price.js"></script>
    <script type="text/javascript" src="https://www.payhere.lk/lib/payhere.js"></script>
</body>

</html>