<?php
session_start();
require "../connection/connection.php";

if (!empty($_SESSION["admin"])) {

    $shop_rs = Database::search("SELECT * FROM `shop`");
    $shop_data = $shop_rs->fetch_assoc();

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $shop_data["name"]; ?> | Admin - Message</title>

        <link rel="stylesheet" href="../css/bootstrap/bootstrap.css" />
        <link rel="stylesheet" href="../css/bootstrap/bootstrap.min.css" />
        <link rel="stylesheet" href="../css/other/sidebars.css">
        <link rel="stylesheet" href="../css/sementic/semantic.css">
        <link rel="stylesheet" href="../css/other/message.css" />

        <link rel="icon" href="<?php echo $shop_data["logo_link"]; ?>" />

    </head>

    <body>

        <div class="container-fluid d-flex ps-0">

            <?php include "sidebar.php"; ?>

            <div class="col-10 vh-100" style="overflow-y: scroll; overflow-x: hidden;">
                <div class="row">
                    <!-- search user -->
                    <div class="accordion mt-5 mb-5" id="accordionExample">
                        <div class="accordion-item">
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                <div class="accordion-body d-flex ">

                                    <!-- msg display -->
                                    <div id="msgDisplay" class="accordion-body w-75 border-box border border-5 b1 d-flex flex-column justify-content-between">
                                    </div>

                                    <!-- all -->
                                    <div class="accordion-body w-25 b2">
                                        <div style="height: 90%;">

                                            <div class="ui relaxed divided list" id="msgList">
                                            </div>

                                        </div>
                                        <hr />
                                        <div class="d-flex gap-3 justify-content-center" style="margin-bottom: 50px;">
                                            <span class="btn btn-outline-primary col-5" id="newMsgBtn" onclick="newOld('1');">NEW</span>
                                            <span class="btn btn-dark col-5" id="allMsgBth" onclick="newOld('2');">ALL</span>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>


                </div>

                <!-- notification -->
                <div class="toast-container position-fixed bottom-0 end-0 p-3">
                    <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="toast-header bg-secondary text-white" id="headerColor">

                            <strong class="me-auto">Message</strong>
                            <small id="time"></small>
                            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                        <div class="toast-body" id="msg">

                        </div>
                    </div>
                </div>

            </div>

        </div>

        <!-- <script src="../js/bootstrap/bootstrap.bundle.min.js"></script> -->
        <script src="../js/other/message.js"></script>
    </body>

    </html>

<?php
} else {
    header("Location:index.php");
}
?>