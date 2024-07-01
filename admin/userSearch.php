<?php
session_start();
require "../connection/connection.php";

if (!empty($_SESSION["admin"])) {

    if (!empty($_POST["searchType"])) {

        $num = 0;

        $search_type = $_POST["searchType"];
        // echo($search_type);

        if ($search_type == 1) { //email
            if (!empty($_POST["email"])) {
                $email = $_POST["email"];

                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

                    $rs = Database::search("SELECT `user`.`id` AS `user_id`,
                    `user`.`status_id` AS `user_status_id`,
                    `user_email`.`id` AS `user_email_id`,
                    `user_email`.`status_id` AS `user_email_status_id`,
                    `user_address`.`id` AS `user_address_id`,
                    `user_address`.`status_id` AS `user_address_status_id`,
                    `user_subscription`.`id` AS `user_subscription_id`,
                    `user_subscription`.`status_id` AS `user_subscription_status_id`,
                    `user_subscription`.`date_time` AS `user_registered_date`,
                    `subscription`.`type` AS `subscription_name`,
                    `user`.`first_name` AS `first_name`,
                    `user`.`last_name` AS `last_name`,
                    `user_email`.`email` AS `email`,
                    `user_address`.`line_1` AS `line_1`,
                    `user_address`.`line_2` AS `line_2`
                    FROM `user` INNER JOIN `user_email` ON `user`.`id`=`user_email`.`user_id` 
                    INNER JOIN `user_subscription` ON `user`.`id`=`user_subscription`.`user_id`
                    INNER JOIN `subscription` ON `subscription`.`id`=`user_subscription`.`subscription_id`
                    INNER JOIN `user_address` ON `user`.`id`=`user_address`.`user_id`
                    WHERE `user_email`.`email`='" . $email . "'");

                    if ($rs->num_rows == 1) {
                        $num = 1;
                    } else {
                        // echo ("Couldn't Find The User");
?>
                        <p style="color:red; text-align:center; margin-top:10px; margin: bottom 10px; ">Couldn't Find The User</p>
                    <?php
                    }
                } else {
                    // echo ("Invalid Email Address");
                    ?>
                    <p style="color:red; text-align:center; margin-top:10px; margin: bottom 10px; ">Invalid Email Address</p>
                <?php
                }
            } else {
                // echo ("Please Insert User Email Address !");
                ?>
                <p style="color:red; text-align:center; margin-top:10px; margin: bottom 10px; ">Please Insert User Email Address !</p>
                <?php
            }
        } else if ($search_type == 2) { //name
            if (!empty($_POST["firstName"]) || !empty($_POST["lastName"])) { // one of them

                $first_name = "";
                $last_name = "";

                if (!empty($_POST["firstName"])) {
                    $first_name = $_POST["firstName"];
                }

                if (!empty($_POST["lastName"])) {
                    $last_name = $_POST["lastName"];
                }

                $rs = Database::search("SELECT `user`.`id` AS `user_id`,
                `user`.`status_id` AS `user_status_id`,
                `user_email`.`id` AS `user_email_id`,
                `user_email`.`status_id` AS `user_email_status_id`,
                `user_address`.`id` AS `user_address_id`,
                `user_address`.`status_id` AS `user_address_status_id`,
                `user_subscription`.`id` AS `user_subscription_id`,
                `user_subscription`.`status_id` AS `user_subscription_status_id`,
                `user_subscription`.`date_time` AS `user_registered_date`,
                `subscription`.`type` AS `subscription_name`,
                `user`.`first_name` AS `first_name`,
                `user`.`last_name` AS `last_name`,
                `user_email`.`email` AS `email`,
                `user_address`.`line_1` AS `line_1`,
                `user_address`.`line_2` AS `line_2`
                FROM `user` INNER JOIN `user_email` ON `user`.`id`=`user_email`.`user_id` 
                INNER JOIN `user_subscription` ON `user`.`id`=`user_subscription`.`user_id`
                INNER JOIN `subscription` ON `subscription`.`id`=`user_subscription`.`subscription_id`
                INNER JOIN `user_address` ON `user`.`id`=`user_address`.`user_id`
                WHERE `user`.`first_name` LIKE '%" . $first_name . "%' AND `user`.`last_name` LIKE '%" . $last_name . "%'");

                if ($rs->num_rows > 0) {
                    $num = 1;
                } else {
                    // echo ("Couldn't Find The User");
                ?>
                    <p style="color:red; text-align:center; margin-top:10px; margin: bottom 10px; ">Couldn't Find The User</p>
                <?php
                }
            } else {
                // echo ("Please Insert User Name !");
                ?>
                <p style="color:red; text-align:center; margin-top:10px; margin: bottom 10px; ">Please Insert User Name !</p>
            <?php
            }
        }


        if ($num > 0) { //data availiable

            ?>

            <table class="ui compact celled definition table">
                <thead>
                    <tr>
                        <th></th>
                        <th>Name</th>
                        <th>Registration Date</th>
                        <th>E-mail address</th>
                        <th>Subscription</th>
                        <th>Address</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    for ($x = 0; $x < $rs->num_rows; $x++) {
                        $data = $rs->fetch_assoc();

                        $userStatus = 2;
                        if ($data["user_status_id"] == 1) { //active user
                            $userStatus = 1;
                        }

                        $emailStatus = 2;
                        if ($data["user_email_status_id"] == 1) { //active email
                            $emailStatus = 1;
                        }

                        $subscriptionStatus = 2;
                        if ($data["user_subscription_status_id"] == 1) { //active subscription
                            $subscriptionStatus = 1;
                        }

                        $addressStatus = 2;
                        if ($data["user_address_status_id"] == 1) { //active address
                            $addressStatus = 1;
                        }

                    ?>

                        <tr>
                            <td class="collapsing">
                                <div class="ui fitted slider checkbox">
                                    <input type="checkbox" <?php
                                                            if ($userStatus == 1) {
                                                                echo ("checked");
                                                            }
                                                            ?> onclick="changeUserStatus(<?php echo ($data['user_id']);  ?>,<?php echo $userStatus; ?>);"> <label></label>
                                </div>
                            </td>
                            <td><?php echo ($data["first_name"] . " " . $data["last_name"]); ?></td>
                            <td><?php echo ($data["user_registered_date"]); ?></td>
                            <td>
                                <?php
                                if (!empty($data["email"]) && $data["user_email_status_id"] == 1) {
                                    echo $data["email"];
                                } else {
                                    // echo ("Not Availiable");
                                ?>
                                    <p style="color:red; text-align:center; margin-top:10px; margin: bottom 10px; ">Not Availiable</p>
                                <?php
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if (!empty($data["subscription_name"]) && $data["user_subscription_status_id"] == 1) {
                                    echo $data["subscription_name"];
                                } else {
                                    // echo ("Not Availiable");
                                ?>
                                    <p style="color:red; text-align:center; margin-top:10px; margin: bottom 10px; ">Not Availiable</p>
                                <?php
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if (!empty($data["line_1"]) && !empty($data["line_2"]) && $data["user_address_status_id"] == 1) {
                                    echo $data["line_1"] . " " . $data["line_2"];
                                } else {
                                    // echo ("Not Availiable");
                                ?>
                                    <p style="color:red; text-align:center; margin-top:10px; margin: bottom 10px; ">Not Availiable</p>
                                <?php
                                }
                                ?>
                            </td>
                        </tr>

                    <?php
                    }

                    ?>
                </tbody>
            </table>

<?php

        }
    }
} else {
    header("Location:index.php");
}
?>