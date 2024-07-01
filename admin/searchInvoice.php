<?php
session_start();
require "../connection/connection.php";

if (!empty($_SESSION["admin"])) {

    $num = 0;

    if (!empty($_POST["invoice_id"])) {
        $invoice_id = $_POST["invoice_id"];

        $rs = Database::search("SELECT *
        FROM `user`
        INNER JOIN `user_email` ON `user`.`id`=`user_email`.`user_id`
        INNER JOIN `purchase_history` ON `user`.`id`=`purchase_history`.`user_id`
        WHERE `purchase_history`.`purchase_history_id`='" . $invoice_id . "' AND `user_email`.`status_id`='1'");

        if ($rs->num_rows == 1) {
            $num = 1;
        } else {
?>
            <p style="color:red; text-align:center; margin-top:10px; margin: bottom 10px; ">Couldn't Find The Invoice</p>
        <?php
        }
    } else {
        ?>
        <p style="color:red; text-align:center; margin-top:10px; margin: bottom 10px; ">Please Insert Invoice Id !</p>
    <?php
    }


    if ($num == 1) { //data availiable

    ?>

        <table class="ui compact celled definition table">
            <thead>
                <tr>
                    <th></th>
                    <th>Email</th>
                    <th>Date Time</th>
                    <th>Content</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php

                for ($x = 0; $x < $rs->num_rows; $x++) {
                    $data = $rs->fetch_assoc();

                ?>

                    <tr>
                        <td><?php echo ($x + 1); ?></td>
                        <td><?php echo ($data["email"]); ?></td>
                        <td><?php echo ($data["date_time"]); ?></td>
                        <td>
                            <ul>
                                <?php

                                $code_rs = Database::search("SELECT * FROM `purchased_item_code` 
                                INNER JOIN `purchase_history` ON `purchase_history`.`purchase_history_id`=`purchased_item_code`.`purchase_history_purchase_history_id`
                                WHERE `purchase_history`.`purchase_history_id`='" . $invoice_id . "'");

                                for ($y = 0; $y < $code_rs->num_rows; $y++) {
                                    $code = $code_rs->fetch_assoc();

                                    $movie_rs = Database::search("SELECT * FROM `movie` WHERE `movie`.`code`='" . $code["purchased_item_code"] . "'");
                                    if ($movie_rs->num_rows == 1) { //its a movie

                                        $content_data = $movie_rs->fetch_assoc();
                                    } else { //check tv

                                        $tv_rs = Database::search("SELECT * FROM `tv_series` WHERE `tv_series`.`code`='" . $code["purchased_item_code"] . "'");

                                        if ($tv_rs->num_rows == 1) { //its tv
                                            $content_data = $tv_rs->fetch_assoc();
                                        }
                                    }

                                ?>
                                    <li><?php echo ($content_data["name"]); ?></li>

                                <?php

                                }
                                ?>
                            </ul>
                        </td>
                        <td><?php echo ($data["price"]); ?></td>
                    </tr>
                <?php
                }

                ?>
            </tbody>
        </table>

<?php

    }
} else {
    header("Location:index.php");
}
?>