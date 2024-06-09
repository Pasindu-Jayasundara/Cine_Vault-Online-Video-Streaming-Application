<?php

require "../connection/connection.php";
session_start();

if (!empty($_SESSION["admin"])) {

    if (!empty($_POST["msg_Type"])) {

        $msg_type = $_POST["msg_Type"];

        if ($msg_type == 1) { //new msg
            $q = "SELECT * FROM `admin_message` WHERE `admin_message`.`message_status_message_status_id`='2' ORDER BY `admin_message`.`date_time` DESC";
        } else if ($msg_type == 2) { //all msg
            $q = "SELECT * FROM `admin_message` ORDER BY `admin_message`.`date_time` DESC";
        }

        $rs = Database::search($q);

        if ($rs->num_rows > 0) {

            for ($x = 0; $x < $rs->num_rows; $x++) {
                $data = $rs->fetch_assoc();

                $img_rs = Database::search("SELECT * FROM `profile_image` WHERE `profile_image`.`status_id`='1' AND `profile_image`.`user_id`='" . $data["user_id"] . "'");
                if ($img_rs->num_rows == 1) {
                    $img_data = $img_rs->fetch_assoc();
                    $src = $img_data["link"];
                } else {
                    $src = "../profile_image/user.png";
                }

                $email_rs = Database::search("SELECT * FROM `user_email` WHERE `user_email`.`user_id`='" . $data["user_id"] . "' AND `user_email`.`status_id`='1'");
                if ($email_rs->num_rows == 1) {
                    $email_data = $email_rs->fetch_assoc();
                    $email = $email_data["email"];

?>

                    <div class="item d-flex align-items-center pb-2 ps-2 pt-2 c" style="cursor:pointer;" onclick="readMsg('<?php echo $data['admin_message_id']; ?>','<?php echo $data['message_status_message_status_id']; ?>')">
                        <img src="<?php echo $src; ?>" style="width:30px; aspect-ratio: 1/1; border-radius: 15px;" />
                        <div class="content ms-2 d">
                            <div class="header text-primary d"><?php echo $email; ?></div>
                            <div class="description " style="font-size: smaller;"><?php $data["date_time"]; ?></div>
                        </div>
                    </div>

<?php

                }
            }
        } else {
            // echo ("no messages");
            echo ("1");
        }
    } else {
        // echo ("something went wrong");
        echo ("2");
    }
} else {
    header("Location:index.php");
}

?>