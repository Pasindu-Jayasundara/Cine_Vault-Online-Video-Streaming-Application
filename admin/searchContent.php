<?php

session_start();
require "../connection/connection.php";

if (!empty($_SESSION["admin"])) {

    if (!empty($_POST["content_name"]) && !empty($_POST["searchType"])) {

        $content_name = $_POST["content_name"];
        $searchType = $_POST["searchType"];

        if ($searchType == 1) { //movie

            $rs = Database::search("SELECT * FROM `movie` INNER JOIN `quality` ON `movie`.`quality_quality_id`=`quality`.`quality_id` 
            INNER JOIN `year` ON `year`.`year_id`=`movie`.`year_year_id`
            INNER JOIN `language` ON `movie`.`language_language_id`=`language`.`language_id` 
            INNER JOIN `country` ON `movie`.`country_country_id`=`country`.`country_id` 
            INNER JOIN `content_uploaded_by` ON `movie`.`code`=`content_uploaded_by`.`code`
            INNER JOIN `admin` ON `admin`.`admin_id`=`content_uploaded_by`.`by`
            WHERE `content_uploaded_by`.`content_type`='1' AND `movie`.`name` LIKE '%" . $content_name . "%'");
            if ($rs->num_rows > 0) {

?>
                <table class="ui compact celled definition table">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Movie Name</th>
                            <th>Price</th>
                            <th>Quality</th>
                            <th>Year</th>
                            <th>Language</th>
                            <th>Country</th>
                            <th>Rating</th>
                            <th>Director</th>
                            <th>Uploaded By</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        for ($x = 0; $x < $rs->num_rows; $x++) {
                            $data = $rs->fetch_assoc();

                            $s_rs = Database::search("SELECT `status_id` FROM `movie` WHERE `movie`.`id`='".$data["id"]."'");
                            $s_data = $s_rs->fetch_assoc();

                            $movieStatus = 2;
                            if ($s_data["status_id"] == 1) { //active movie
                                $movieStatus = 1;
                            }

                        ?>

                            <tr>
                                <td class="collapsing">
                                    <div class="ui fitted slider checkbox">
                                        <input type="checkbox" <?php
                                                                if ($movieStatus == 1) {
                                                                    echo ("checked");
                                                                }
                                                                ?> onclick="changeContentStatus(<?php echo $searchType; ?>,<?php echo ($data['id']);  ?>,<?php echo $movieStatus; ?>);"> <label></label>
                                    </div>
                                </td>
                                <td><?php echo $data["name"]; ?></td>
                                <td><?php echo $data["price"]; ?></td>
                                <td><?php echo $data["quality"]; ?></td>
                                <td><?php echo $data["year"]; ?></td>
                                <td><?php echo $data["language"]; ?></td>
                                <td><?php echo $data["country"]; ?></td>
                                <td><?php echo $data["rating"]; ?></td>
                                <td><?php echo $data["director"]; ?></td>
                                <td><?php echo $data["first_name"] . " " . $data["last_name"]; ?></td>
                            </tr>

                        <?php
                        }

                        ?>
                    </tbody>
                </table>
            <?php

            } else {
                // echo ("Couldn't Find The Relavant Content");
            ?>
                <p style="color:red; text-align:center; margin-top:10px; margin: bottom 10px; ">Couldn't Find The Relavant Content</p>
            <?php
            }
        } else if ($searchType == 2) { //tv

            $rs = Database::search("SELECT * FROM `tv_series` INNER JOIN `quality` ON `tv_series`.`quality_quality_id`=`quality`.`quality_id` 
            INNER JOIN `year` ON `year`.`year_id`=`tv_series`.`year_year_id`
            INNER JOIN `language` ON `tv_series`.`language_language_id`=`language`.`language_id` 
            INNER JOIN `country` ON `tv_series`.`country_country_id`=`country`.`country_id` 
            INNER JOIN `content_uploaded_by` ON `tv_series`.`code`=`content_uploaded_by`.`code`
            INNER JOIN `admin` ON `admin`.`admin_id`=`content_uploaded_by`.`by`
            WHERE `content_uploaded_by`.`content_type`='2' AND `tv_series`.`name` LIKE '%" . $content_name . "%'");
            if ($rs->num_rows > 0) {

            ?>
                <table class="ui compact celled definition table">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Tv-Series Name</th>
                            <th>Price</th>
                            <th>Quality</th>
                            <th>Year</th>
                            <th>Language</th>
                            <th>Country</th>
                            <th>Rating</th>
                            <th>Director</th>
                            <th>Uploaded By</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        for ($x = 0; $x < $rs->num_rows; $x++) {
                            $data = $rs->fetch_assoc();

                            $s_rs = Database::search("SELECT `status_id` FROM `tv_series` WHERE `tv_series`.`id`='".$data["id"]."'");
                            $s_data = $s_rs->fetch_assoc();

                            $tvStatus = 2;
                            if ($s_data["status_id"] == 1) { //active movie
                                $tvStatus = 1;
                            }

                        ?>

                            <tr>
                                <td class="collapsing">
                                    <div class="ui fitted slider checkbox">
                                        <input type="checkbox" <?php
                                                                if ($tvStatus == 1) {
                                                                    echo ("checked");
                                                                }
                                                                ?> onclick="changeContentStatus(<?php echo $searchType; ?>,<?php echo ($data['id']);  ?>,<?php echo $tvStatus; ?>);"> <label></label>
                                    </div>
                                </td>
                                <td><?php echo $data["name"]; ?></td>
                                <td><?php echo $data["price"]; ?></td>
                                <td><?php echo $data["quality"]; ?></td>
                                <td><?php echo $data["year"]; ?></td>
                                <td><?php echo $data["language"]; ?></td>
                                <td><?php echo $data["country"]; ?></td>
                                <td><?php echo $data["rating"]; ?></td>
                                <td><?php echo $data["director"]; ?></td>
                                <td><?php echo $data["by"]; ?></td>
                            </tr>

                        <?php
                        }

                        ?>
                    </tbody>
                </table>
            <?php

            } else {
                // echo ("Couldn't Find The Relavant Content");
            ?>
                <p style="color:red; text-align:center; margin-top:10px; margin: bottom 10px; ">Couldn't Find The Relavant Content</p>
        <?php
            }
        }
    } else {
        // echo ("Fill The Content");
        ?>
        <p style="color:red; text-align:center; margin-top:10px; margin: bottom 10px; ">Fill The Content</p>
<?php
    }
} else {
    header("Location:index.php");
}

?>