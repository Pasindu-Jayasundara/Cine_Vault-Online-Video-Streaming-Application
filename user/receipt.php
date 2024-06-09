<?php
session_start();
require "../connection/connection.php";

$shop_rs = Database::search("SELECT * FROM `shop`");
$shop_data = $shop_rs->fetch_assoc();
if (!empty($_SESSION["user"]) && !empty($_GET["id"])) {

    $purchased_history_id = $_GET["id"];

    $q = "SELECT `user`.`first_name`,
    `user`.`last_name`,
    `user_email`.`email`,
    `purchase_history`.`purchase_history_id`,
    `purchase_history`.`date_time`,
    `purchase_history`.`price`

    FROM `purchase_history` 
    INNER JOIN `user` ON `user`.`id`=`purchase_history`.`user_id` 
    INNER JOIN `user_email` ON `user`.`id`=`user_email`.`user_id` 
    WHERE `purchase_history`.`user_id`='" . $_SESSION["user"]["id"] . "' 
    AND `purchase_history`.`purchase_history_id`='" . $purchased_history_id . "' 
    AND `user_email`.`status_id`='1'";
    $rs = Database::search($q);

    $data = $rs->fetch_assoc();

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $shop_data["name"]; ?> | Receipt</title>

        <link rel="icon" href="<?php echo $shop_data["logo_link"]; ?>" />

        <link rel="stylesheet" href="../css/bootstrap/bootstrap.css" />
        <link rel="stylesheet" href="../css/sementic/semantic.css" />
    </head>

    <body id="body">

        <div class="container-fluid text-white">
            <div class="row  bg-black">

                <?php include "header.php"; ?>

                <div class="col-12 min-vh-75">

                    <div class="row d-flex justify-content-center align-items-center">
                        <button type="button" class="btn-close bg-warning" onclick="window.location.href='purchasedHistory.php';" style="margin-left: 61%;" aria-label="Close"></button>

                        <div id="receipt_body" class="col-7 border border-1 border-secondary p-4" style="background-color:rgba(0, 0, 0, 0.777); min-height: 70vh; border-radius: 25px; z-index: 2;">
                            <!-- receipt head -->
                            <div class="row">
                                <div class="col-6 d-flex flex-column">
                                    <span><?php echo $data["first_name"] . " " . $data["last_name"];  ?></span>
                                    <span><?php echo $data["email"]; ?></span>
                                    <span class="mt-5">Receipt ID : 00<?php echo $data["purchase_history_id"]; ?></span>
                                </div>
                                <div class="col-6 d-flex flex-column align-items-end">
                                    <img src="<?php echo $shop_data["logo_link"]; ?>" width="50" alt="">
                                    <span><?php echo $shop_data["name"]; ?></span>
                                    <span><?php echo $shop_data["email"]; ?></span>
                                    <span><?php echo $shop_data["mobile"]; ?></span>
                                    <span><?php echo $shop_data["line_1"] . " " . $shop_data["line_2"]; ?></span>
                                    <span class="mt-5"><?php echo $data["date_time"]; ?></span>
                                </div>
                            </div>

                            <!-- receipt title -->
                            <div class="row d-flex justify-content-center fs-4 my-5">
                                Purchase Receipt
                            </div>

                            <!-- receipt body -->
                            <div class="row col-12 ms-auto mt-3">

                                <table id="table" class="ui green bg-black text-white table pb-3">
                                    <thead>
                                        <tr>
                                            <th id="a1" class="bg-black text-white"></th>
                                            <th id="a2" class="bg-black text-white">Purchase Id</th>
                                            <th id="a3" class="bg-black text-white">Name</th>
                                            <th id="a4" class="bg-black text-white">Price</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-dark">
                                        <?php
                                        $item_rs = Database::search("SELECT * FROM `purchased_item_code` 
                                        WHERE `purchased_item_code`.`purchase_history_purchase_history_id`='" . $purchased_history_id . "'");

                                        if ($item_rs->num_rows > 0) {
                                            for ($x = 0; $x < $item_rs->num_rows; $x++) {
                                                $item_data = $item_rs->fetch_assoc();

                                                $code = $item_data["purchased_item_code"];

                                                $content_rs = Database::search("SELECT * FROM `movie` WHERE `movie`.`status_id`='1' AND `movie`.`code`='" . $code . "'");
                                                if ($content_rs->num_rows == 1) { //its movie

                                                    $content_data = $content_rs->fetch_assoc();

                                        ?>
                                                    <tr>
                                                        <td><?php echo $x + 1; ?></td>
                                                        <td>00<?php echo $purchased_history_id; ?></td>
                                                        <td><?php echo $content_data["name"]; ?></td>
                                                        <td><?php echo $content_data["price"]; ?></td>
                                                    </tr>
                                                    <?php

                                                } else { //check tv

                                                    $tv_rs = Database::search("SELECT * FROM `tv_series` WHERE `tv_series`.`status_id`='1' AND `tv_series`.`code`='" . $code . "'");

                                                    if ($tv_rs->num_rows == 1) { //its tv

                                                        $content_data = $tv_rs->fetch_assoc();

                                                    ?>
                                                        <tr>
                                                            <td><?php echo $x + 1; ?></td>
                                                            <td>00<?php echo $purchased_history_id; ?></td>
                                                            <td><?php echo $content_data["name"]; ?></td>
                                                            <td><?php echo $content_data["price"]; ?></td>
                                                        </tr>
                                        <?php

                                                    }
                                                }
                                            }
                                        }
                                        ?>
                                    </tbody>
                                    <tfoot class="full-width">
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td class="bg-secondary">Total</td>
                                            <td class="bg-secondary"><?php echo $data["price"]; ?></td>
                                        </tr>
                                    </tfoot>
                                </table>

                            </div>
                            <div id="op" class="d-flex justify-content-end my-4 gap-2">
                                <span class="btn btn-success" onclick="emailReceipt();">Email</span>
                                <span class="btn btn-success" onclick="printReceipt();">Print</span>
                            </div>
                        </div>

                        <div style="width:100%; padding: 0; margin-top: -14%; margin-bottom: -1.5%; z-index: 1;">
                            <!-- wave -->
                            <svg id="wave" style="transform:rotate(0deg); transition: 0.3s" viewBox="0 0 1440 350" version="1.1" xmlns="http://www.w3.org/2000/svg">
                                <defs>
                                    <linearGradient id="sw-gradient-0" x1="0" x2="0" y1="1" y2="0">
                                        <stop stop-color="rgba(243, 106, 62, 1)" offset="0%"></stop>
                                        <stop stop-color="rgba(255, 179, 11, 1)" offset="100%"></stop>
                                    </linearGradient>
                                </defs>
                                <path style="transform:translate(0, 0px); opacity:1" fill="url(#sw-gradient-0)" d="M0,175L30,163.3C60,152,120,128,180,128.3C240,128,300,152,360,157.5C420,163,480,152,540,134.2C600,117,660,93,720,105C780,117,840,163,900,186.7C960,210,1020,210,1080,198.3C1140,187,1200,163,1260,163.3C1320,163,1380,187,1440,210C1500,233,1560,257,1620,245C1680,233,1740,187,1800,157.5C1860,128,1920,117,1980,145.8C2040,175,2100,245,2160,245C2220,245,2280,175,2340,169.2C2400,163,2460,222,2520,250.8C2580,280,2640,280,2700,239.2C2760,198,2820,117,2880,110.8C2940,105,3000,175,3060,215.8C3120,257,3180,268,3240,233.3C3300,198,3360,117,3420,75.8C3480,35,3540,35,3600,46.7C3660,58,3720,82,3780,110.8C3840,140,3900,175,3960,210C4020,245,4080,280,4140,291.7C4200,303,4260,292,4290,285.8L4320,280L4320,350L4290,350C4260,350,4200,350,4140,350C4080,350,4020,350,3960,350C3900,350,3840,350,3780,350C3720,350,3660,350,3600,350C3540,350,3480,350,3420,350C3360,350,3300,350,3240,350C3180,350,3120,350,3060,350C3000,350,2940,350,2880,350C2820,350,2760,350,2700,350C2640,350,2580,350,2520,350C2460,350,2400,350,2340,350C2280,350,2220,350,2160,350C2100,350,2040,350,1980,350C1920,350,1860,350,1800,350C1740,350,1680,350,1620,350C1560,350,1500,350,1440,350C1380,350,1320,350,1260,350C1200,350,1140,350,1080,350C1020,350,960,350,900,350C840,350,780,350,720,350C660,350,600,350,540,350C480,350,420,350,360,350C300,350,240,350,180,350C120,350,60,350,30,350L0,350Z"></path>
                                <defs>
                                    <linearGradient id="sw-gradient-1" x1="0" x2="0" y1="1" y2="0">
                                        <stop stop-color="rgba(235.334, 169.505, 148.363, 1)" offset="0%"></stop>
                                        <stop stop-color="rgba(255, 179, 11, 1)" offset="100%"></stop>
                                    </linearGradient>
                                </defs>
                                <path style="transform:translate(0, 50px); opacity:0.9" fill="url(#sw-gradient-1)" d="M0,280L30,262.5C60,245,120,210,180,215.8C240,222,300,268,360,250.8C420,233,480,152,540,105C600,58,660,47,720,64.2C780,82,840,128,900,134.2C960,140,1020,105,1080,105C1140,105,1200,140,1260,157.5C1320,175,1380,175,1440,151.7C1500,128,1560,82,1620,93.3C1680,105,1740,175,1800,192.5C1860,210,1920,175,1980,169.2C2040,163,2100,187,2160,175C2220,163,2280,117,2340,122.5C2400,128,2460,187,2520,180.8C2580,175,2640,105,2700,99.2C2760,93,2820,152,2880,192.5C2940,233,3000,257,3060,245C3120,233,3180,187,3240,151.7C3300,117,3360,93,3420,87.5C3480,82,3540,93,3600,134.2C3660,175,3720,245,3780,268.3C3840,292,3900,268,3960,245C4020,222,4080,198,4140,169.2C4200,140,4260,105,4290,87.5L4320,70L4320,350L4290,350C4260,350,4200,350,4140,350C4080,350,4020,350,3960,350C3900,350,3840,350,3780,350C3720,350,3660,350,3600,350C3540,350,3480,350,3420,350C3360,350,3300,350,3240,350C3180,350,3120,350,3060,350C3000,350,2940,350,2880,350C2820,350,2760,350,2700,350C2640,350,2580,350,2520,350C2460,350,2400,350,2340,350C2280,350,2220,350,2160,350C2100,350,2040,350,1980,350C1920,350,1860,350,1800,350C1740,350,1680,350,1620,350C1560,350,1500,350,1440,350C1380,350,1320,350,1260,350C1200,350,1140,350,1080,350C1020,350,960,350,900,350C840,350,780,350,720,350C660,350,600,350,540,350C480,350,420,350,360,350C300,350,240,350,180,350C120,350,60,350,30,350L0,350Z"></path>
                                <defs>
                                    <linearGradient id="sw-gradient-2" x1="0" x2="0" y1="1" y2="0">
                                        <stop stop-color="rgba(243, 106, 62, 1)" offset="0%"></stop>
                                        <stop stop-color="rgba(237.611, 170.977, 23.681, 1)" offset="100%"></stop>
                                    </linearGradient>
                                </defs>
                                <path style="transform:translate(0, 100px); opacity:0.8" fill="url(#sw-gradient-2)" d="M0,105L30,122.5C60,140,120,175,180,163.3C240,152,300,93,360,93.3C420,93,480,152,540,169.2C600,187,660,163,720,134.2C780,105,840,70,900,52.5C960,35,1020,35,1080,52.5C1140,70,1200,105,1260,105C1320,105,1380,70,1440,46.7C1500,23,1560,12,1620,5.8C1680,0,1740,0,1800,5.8C1860,12,1920,23,1980,40.8C2040,58,2100,82,2160,116.7C2220,152,2280,198,2340,210C2400,222,2460,198,2520,169.2C2580,140,2640,105,2700,122.5C2760,140,2820,210,2880,245C2940,280,3000,280,3060,239.2C3120,198,3180,117,3240,110.8C3300,105,3360,175,3420,192.5C3480,210,3540,175,3600,151.7C3660,128,3720,117,3780,93.3C3840,70,3900,35,3960,58.3C4020,82,4080,163,4140,192.5C4200,222,4260,198,4290,186.7L4320,175L4320,350L4290,350C4260,350,4200,350,4140,350C4080,350,4020,350,3960,350C3900,350,3840,350,3780,350C3720,350,3660,350,3600,350C3540,350,3480,350,3420,350C3360,350,3300,350,3240,350C3180,350,3120,350,3060,350C3000,350,2940,350,2880,350C2820,350,2760,350,2700,350C2640,350,2580,350,2520,350C2460,350,2400,350,2340,350C2280,350,2220,350,2160,350C2100,350,2040,350,1980,350C1920,350,1860,350,1800,350C1740,350,1680,350,1620,350C1560,350,1500,350,1440,350C1380,350,1320,350,1260,350C1200,350,1140,350,1080,350C1020,350,960,350,900,350C840,350,780,350,720,350C660,350,600,350,540,350C480,350,420,350,360,350C300,350,240,350,180,350C120,350,60,350,30,350L0,350Z"></path>
                            </svg>
                        </div>

                        <!-- notification -->
                        <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 10;">
                            <div id="liveToast2" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                                <div class="toast-header text-white" id="headerColor2">

                                    <strong class="me-auto">Message</strong>
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

        <script src="../js/other/receipt.js"></script>
    </body>

    </html>
<?php
} else {
    header("Location:index.php");
}
?>