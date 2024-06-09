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
    <title><?php echo $shop_data["name"]; ?> | Cart</title>

    <link rel="stylesheet" href="../css/bootstrap/bootstrap.css" />
    <link rel="stylesheet" href="../css/sementic/semantic.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="../css/other/cart.css" />
    <link rel="icon" href="<?php echo $shop_data["logo_link"]; ?>" />
</head>

<body>
    <div class="container-fluid bg-black">
        <div class="row">

            <?php include "header.php"; ?>

            <div class="col-12 min-vh-100">
                <div class="row m-0 p-0" id="body">

                    <?php
                    if (!empty($_SESSION["user"])) {
                    ?>

                        <!-- content -->
                        <div class="col-12 d-flex flex-row">
                            <div class="row min-vh-100">

                                <div class="container-fluid pb-3">
                                    <div class="d-grid gap-3 p-2">

                                        <!-- cards -->
                                        <div class="row row-cols-1 row-cols-md-5 g-4" id="cardDiv" style="width:85vw;">

                                        </div>

                                    </div>
                                </div>

                            </div>
                            <?php
                            $c_rs = Database::search("SELECT * FROM `cart` WHERE `cart`.`user_id`='" . $_SESSION["user"]["id"] . "' AND `cart`.`status_id`='1'");
                            if ($c_rs->num_rows > 0) {
                            ?>
                                <div class="row d-flex flex-column " data-aos="zoom-in-left">
                                    <div class="fw-bold bg-secondary text-white text-center">Total</div>
                                    <div class="d-flex bg-white flex-column align-items-start border border-1 border-secondary pb-4">
                                        <div class="mt-3 mb-2">Selected</div>
                                        <div>
                                            <table class="ui red table">
                                                <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Price</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbody">

                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th colspan="1" class="bg-secondary text-center text-white">Total</th>
                                                        <th class="bg-info" id="totaltr">Rs.00.00</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                        <span class="btn btn-warning d-grid col-12 mt-3 mb-2" id="payhere-payment" onclick="checkHistory();">Buy</span>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>

                        </div>

                    <?php

                    } else {
                    ?>
                        <div class="mt-5">
                            <h2 class="text-warning text-center">
                                Please Log In to Your Account To Find Your Cart Content
                            </h2>
                        </div>
                        <div class="d-flex justify-content-center">
                            <img src="../design_images/loginnew.png" class="position-absolute" style="width:30%; margin-top: 5%;" />
                        </div>
                    <?php
                    }
                    ?>


                </div>
            </div>

            <!-- warning modal -->
            <div class="modal fade" id="warning" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content bg-dark">
                        <button type="button" class="btn-close bg-white m-4" data-bs-dismiss="modal" aria-label="Close" onclick="resetLi();"></button>
                        <div class="modal-body d-flex flex-column justify-content-center align-items-center">
                            <i class="bi bi-exclamation-triangle text-warning" style="font-size: 60px;"></i>
                            <p class="text-warning mt-4 fs-4">You Have Previously Bought:</p>
                            <ul class="text-white fs-5 " id="ullist" style="align-self: flex-start;">
                                
                            </ul>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal" onclick="resetLi();">Close</button>
                            <button type="button" class="btn btn-outline-warning" onclick="pay();">Continue</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- notification -->
            <div class="toast-container position-fixed bottom-0 end-0 p-3">
                <div id="liveToast2" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-header text-black" id="headerColor2">

                        <strong class="me-auto">Message</strong>
                        <small id="time2"></small>
                        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body" id="msg2">

                    </div>
                </div>
            </div>
            <?php include "../common/footer.php"; ?>

        </div>
    </div>

    <script src="../js/other/cart.js"></script>
    <script type="text/javascript" src="https://www.payhere.lk/lib/payhere.js"></script>

</body>

</html>