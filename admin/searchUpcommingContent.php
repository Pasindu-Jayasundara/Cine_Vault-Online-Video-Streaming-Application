<?php

session_start();
require "../connection/connection.php";

if (!empty($_SESSION["admin"])) {

    if (!empty($_POST["name"])) {
        $name = $_POST["name"];

        $rs = Database::search("SELECT * FROM `upcomming_content` WHERE `upcomming_content`.`status_id`='1' AND `upcomming_content`.`content_name` LIKE '%" . $name . "%'");

        if ($rs->num_rows > 0) {

            // for ($x = 0; $x < $rs->num_rows; $x++) {
            // $data = $rs->fetch_assoc();

?>

            <table class="ui compact celled definition table">
                <thead>
                    <tr>
                        <th></th>
                        <th>Name</th>
                        <th>Release Date</th>
                        <th>Cover Photo</th>
                        <th>Added By</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    for ($x = 0; $x < $rs->num_rows; $x++) {
                        $data = $rs->fetch_assoc();

                        $upcommingStatus = 2;
                        if ($data["status_id"] == 1) { //active content
                            $upcommingStatus = 1;
                        }

                    ?>

                        <tr>
                            <td class="collapsing">
                                <div class="ui fitted slider checkbox">
                                    <input type="checkbox" checked onclick="deactiveUpcommingContent(<?php echo ($data['upcomming_content_id']);  ?>,<?php echo $upcommingStatus; ?>);"> <label></label>
                                </div>
                            </td>
                            <td><?php echo ($data["content_name"]); ?></td>
                            <td><?php echo ($data["release_date"]); ?></td>
                            <td>
                                <img src="<?php echo $data["url"]; ?>" style="width:250px; background-size: cover; background-repeat: no-repeat;" />
                            </td>
                            <?php
                            $admin_rs = Database::search("SELECT * FROM `admin` WHERE `admin`.`admin_id`='" . $data["by"] . "'");
                            $admin_data = $admin_rs->fetch_assoc();
                            ?>
                            <td><?php echo $admin_data["first_name"] . " " . $admin_data["last_name"]; ?></td>
                        </tr>

                    <?php
                    }

                    ?>
                </tbody>
            </table>

        <?php

            // }
        } else {
            // echo("Couldn't Find A Match");
        ?>
            <p style="color:red; text-align:center; margin-top:10px; margin: bottom 10px; ">Couldn't Find A Match !</p>
<?php
        }
    } else {
        // echo ("Insert The Upcomming Content Name");
        echo ("1");
    }
} else {
    header("Location:index.php");
}

?>