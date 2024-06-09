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
    <title><?php echo $shop_data["name"]; ?> | Favourite</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="../css/bootstrap/bootstrap.css" />
    <link rel="stylesheet" href="../css/other/favourite.css"/>
    <link rel="icon" href="<?php echo $shop_data["logo_link"]; ?>" />
</head>

<body>
    <div class="container-fluid bg-black" style="overflow-x: hidden;">
        <div class="row">

            <?php include "header.php"; ?>

            <div class="col-12 min-vh-100">
                <div class="row m-0 p-0" id="body">

                    <?php
                    if (!empty($_SESSION["user"])) {
                    ?>

                        <!-- content -->
                        <div class="col-12">
                            <div class="row min-vh-100">

                                <div class="container-fluid pb-3">
                                    <div class="d-grid gap-3 p-2">

                                        <!-- cards -->
                                        <div class="row row-cols-1 row-cols-md-5 g-4 "  id="cardDiv">

                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>

                    <?php

                    } else {
                        ?>
                        <div class="mt-5">
                            <h2 class="text-warning text-center fw-normal">
                                Please Log In to Your Account To Find Your Favourite Content
                            </h2>
                        </div>
                        <div class="d-flex justify-content-center">
                            <img src="../design_images/loginnew.png" class="position-absolute" style="width:30%; margin-top: 5%;"/>
                        </div>
                        <?php
                    }
                    ?>

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

    <script src="../js/other/favourite.js"></script>
</body>

</html>