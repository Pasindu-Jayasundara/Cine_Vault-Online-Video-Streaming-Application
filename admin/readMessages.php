<?php

require "../connection/connection.php";
session_start();

if (!empty($_SESSION["admin"])) {

    if (!empty($_POST["msg_id"]) && !empty($_POST["msg_status_id"])) {

        $msg_id = $_POST["msg_id"];
        $msg_status_id = $_POST["msg_status_id"];

        $rs = Database::search("SELECT * FROM `admin_message` WHERE `admin_message`.`admin_message_id`='" . $msg_id . "' 
        AND `admin_message`.`message_status_message_status_id`='" . $msg_status_id . "'");

        if ($rs->num_rows == 1) {
            $data = $rs->fetch_assoc();

            $date_time = strtotime($data["date_time"]);
            $date = date("Y-m-d");
            $time = date("H:i");

            $email_rs = Database::search("SELECT * FROM `user_email` WHERE `user_email`.`user_id`='" . $data["user_id"] . "' AND `user_email`.`status_id`='1'");
            if ($email_rs->num_rows == 1) {
                $email_data = $email_rs->fetch_assoc();

                if($msg_status_id == 2){
                    Database::iud("UPDATE `admin_message` SET `admin_message`.`message_status_message_status_id`='1' 
                    WHERE `admin_message`.`message_status_message_status_id`='".$msg_status_id."' AND `admin_message`.`admin_message_id`='".$msg_id."'");
                }

?>

                <div>
                    <p><span class="fw-bold">From :</span> <?php echo $email_data["email"]; ?></p>
                    <p class="fw-bold" style="margin-top: -8px; ">On : <span class="fw-normal" style="font-size: 13px;"><?php echo $date; ?></span> At : <span class="fw-normal" style="font-size: 13px;"><?php echo $time; ?></span></p>
                </div>
                <div>
                    <p class="fw-bold mb-3">Message :</p>
                    <p class="ms-5"><?php echo $data["message"]; ?></p>
                </div>
                <div class="d-flex">
                    <div class="bg-dark p-2 col-10 rounded" id="darkbg<?php echo $email_data['email']; ?>">
                        <textarea rows="1" class="bg-secondary text-white border-none form-control" id="replyText"></textarea>
                    </div>
                    <div class="d-flex bg-dark rounded btn justify-content-center align-items-center ms-2 col-2" onclick="sendEmail('<?php echo $email_data['email']; ?>');">
                        <p class="text-white"><i class="bi bi-send me-2"></i> Send Email</p>
                    </div>
                </div>

<?php

            } else {
                // echo ("Something Went Wrong");
                echo ("1");
            }
        } else {
            // echo ("Couldn't Find The Message");
            echo ("2");
        }
    } else {
        // echo ("Something Went Wrong");
        echo ("3");
    }
} else {
    header("Location:index.php");
}

?>