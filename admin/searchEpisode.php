<?php

session_start();
require "../connection/connection.php";

if (!empty($_SESSION["admin"])) {

    if (!empty($_POST["tvSeriesId"])) {

        $tvSeriesId = $_POST["tvSeriesId"];

        $rs = Database::search("SELECT * FROM `episode` WHERE `episode`.`tv_series_id`='" . $tvSeriesId . "'");

        if ($rs->num_rows > 0) {

?>
            <table class="ui compact celled definition table">
                <thead>
                    <tr>
                        <th></th>
                        <th>Episode Name</th>
                        <th>Episode Number</th>
                        <th>Relased Date</th>
                        <th>Rating</th>
                        <th>Length</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    for ($x = 0; $x < $rs->num_rows; $x++) {
                        $data = $rs->fetch_assoc();

                        $s_rs = Database::search("SELECT `status_id` FROM `episode` WHERE `episode`.`id`='" . $data["id"] . "'");
                        $s_data = $s_rs->fetch_assoc();

                        $episodeStatus = 2;
                        if ($s_data["status_id"] == 1) { //active episode
                            $episodeStatus = 1;
                        }

                        $date_time = strtotime($data["date_time"]);
                        $releaseDate = date("Y-m-d", $date_time);

                    ?>

                        <tr>
                            <td class="collapsing">
                                <div class="ui fitted slider checkbox">
                                    <input type="checkbox" <?php
                                                            if ($episodeStatus == 1) {
                                                                echo ("checked");
                                                            }
                                                            ?> onclick="changeEpisodeStatus(<?php echo $tvSeriesId; ?>,<?php echo ($data['id']);  ?>,<?php echo $episodeStatus; ?>);"> <label></label>
                                </div>
                            </td>
                            <td><?php echo $data["name"]; ?></td>
                            <td><?php echo $data["ep_number"]; ?></td>
                            <td><?php echo $releaseDate; ?></td>
                            <td><?php echo $data["rating"]; ?></td>
                            <td><?php echo $data["length"]; ?></td>
                        </tr>

                    <?php
                    }

                    ?>
                </tbody>
            </table>
        <?php

        } else {
            // echo("Couldn't Find Relavant Episodes");
        ?>
            <p style="color:red; text-align:center; margin-top:10px; margin: bottom 10px; ">Couldn't Find Relavant Episodes</p>
        <?php
        }
    } else {
        // echo ("Select Tv-Series");
        ?>
        <p style="color:red; text-align:center; margin-top:10px; margin: bottom 10px; ">Select Tv-Series</p>
<?php
    }
} else {
    header("Location:index.php");
}

?>