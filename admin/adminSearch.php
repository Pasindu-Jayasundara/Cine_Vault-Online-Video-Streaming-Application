<?php
session_start();
require "../connection/connection.php";

if (!empty($_SESSION["admin"])) {

    if (!empty($_POST["searchType"])) {

        $num = 0;

        $search_type = $_POST["searchType"];

        if ($search_type == 1) { //email
            if (!empty($_POST["email"])) {
                $email = $_POST["email"];

                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

                    $rs = Database::search("SELECT * FROM `admin` INNER JOIN `admin_email` ON `admin`.`admin_id`=`admin_email`.`admin_admin_id` 
                    INNER JOIN `admin_mobile` ON `admin`.`admin_id`=`admin_mobile`.`admin_admin_id`
                    INNER JOIN `admin_address` ON `admin`.`admin_id`=`admin_address`.`admin_admin_id`
                    WHERE `admin_email`.`email`='" . $email . "'");

                    if ($rs->num_rows == 1) {
                        $num = 1;
                    } else {
                        // echo ("Couldn't Find The Admin");
?>
                        <p style="color:red; text-align:center; margin-top:10px; margin: bottom 10px; ">Couldn't Find The Admin</p>
                    <?php
                    }
                } else {
                    // echo ("Invalid Email Address");
                    ?>
                    <p style="color:red; text-align:center; margin-top:10px; margin: bottom 10px; ">Invalid Email Address</p>
                <?php
                }
            } else {
                // echo ("Please Insert Admin Email Address !");
                ?>
                <p style="color:red; text-align:center; margin-top:10px; margin: bottom 10px; ">Please Insert Admin Email Address !</p>
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

                $rs = Database::search("SELECT * FROM `admin` INNER JOIN `admin_email` ON `admin`.`admin_id`=`admin_email`.`admin_admin_id` 
               INNER JOIN `admin_mobile` ON `admin`.`admin_id`=`admin_mobile`.`admin_admin_id`
                    INNER JOIN `admin_address` ON `admin`.`admin_id`=`admin_address`.`admin_admin_id`
                    WHERE `admin`.`first_name` LIKE '%" . $first_name . "%' AND `admin`.`last_name` LIKE '%" . $last_name . "%'");

                if ($rs->num_rows > 0) {
                    $num = 1;
                } else {
                    // echo ("Couldn't Find The Admin");
                ?>
                    <p style="color:red; text-align:center; margin-top:10px; margin: bottom 10px; ">Couldn't Find The Admin</p>
                <?php
                }
            } else {
                // echo ("Please Insert Admin Name !");
                ?>
                <p style="color:red; text-align:center; margin-top:10px; margin: bottom 10px; ">Please Insert Admin Name !</p>
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
                        <th>Mobile</th>
                        <th>Address</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    for ($x = 0; $x < $rs->num_rows; $x++) {
                        $data = $rs->fetch_assoc();

                        $adminStatus = 2;
                        if ($data["admin_status_id"] == 1) { //active admin
                            $adminStatus = 1;
                        }

                        $emailStatus = 2;
                        if ($data["admin_email_status_id"] == 1) { //active email
                            $emailStatus = 1;
                        }

                        $mobileStatus = 2;
                        if ($data["admin_mobile_status_id"] == 1) { //active mobile
                            $mobileStatus = 1;
                        }

                        $addressStatus = 2;
                        if ($data["admin_address_status_id"] == 1) { //active address
                            $addressStatus = 1;
                        }

                    ?>

                        <tr>
                            <td class="collapsing">
                                <div class="ui fitted slider checkbox">
                                    <input type="checkbox" <?php
                                                            if ($adminStatus == 1) {
                                                                echo ("checked");
                                                            }
                                                            ?> onclick="changeAdminStatus(<?php echo ($data['admin_id']);  ?>,<?php echo $adminStatus; ?>);"> <label></label>
                                </div>
                            </td>
                            <td><?php echo ($data["first_name"] . " " . $data["last_name"]); ?></td>
                            <td><?php echo ($data["reg_date"]); ?></td>
                            <td>
                                <?php
                                if (!empty($data["email"]) && $data["admin_email_status_id"] == 1) {
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
                                if (!empty($data["mobile"]) && $data["admin_mobile_status_id"] == 1) {
                                    echo $data["mobile"];
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
                                if (!empty($data["line_1"]) && !empty($data["line_2"]) && $data["admin_address_status_id"] == 1) {
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