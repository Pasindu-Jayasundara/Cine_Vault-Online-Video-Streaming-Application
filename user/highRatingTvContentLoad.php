<?php
session_start();
require "../connection/connection.php";

$query = "SELECT * FROM `tv_series` ORDER BY `tv_series`.`rating` DESC LIMIT 10";

$rs = Database::search($query);

$num = $rs->num_rows;

for ($x = 0; $x < $num; $x++) {
    $data = $rs->fetch_assoc();

    $tv_series_rs = Database::search("SELECT * FROM `tv_series_cover` WHERE `tv_series_cover`.`tv_series_code`='" . $data["code"] . "'");
    $tv_series_data = $tv_series_rs->fetch_assoc();

?>
    <label data-bs-toggle="tooltip<?php echo $tv_series_data['tv_series_code']; ?>" data-bs-placement="bottom" data-bs-title="<?php echo $data['name']; ?>">

        <div class="col" style="margin-right: 140px; margin-bottom: 50px;">
            <div style="width: 150px; height:100px; z-index: 1;" onmouseover="tv_seriesDescription('<?php echo $tv_series_data['tv_series_code']; ?>');" onclick="singleContentLoad('t','<?php echo $tv_series_data['tv_series_code']; ?>');">
                <img style="width :270px; height:150px; background-repeat:no-repeat; background-size:cover; background-image:url('<?php echo $tv_series_data["link"]; ?>')" />
            </div>
            <?php

            if (!empty($_SESSION["user"])) {

                $favourite_rs = Database::search("SELECT * FROM `favourite` WHERE `favourite`.`user_id`='" . $_SESSION["user"]["id"] . "' AND `favourite`.`status_id`='1' 
                    AND `favourite`.`code`='" . $tv_series_data["tv_series_code"] . "'");

                if ($favourite_rs->num_rows == 1) {
            ?>
                    <div class="position-absolute bg-black" style="z-index: 5; margin-top: -6.8%;">
                        <i class="bi bi-bookmark-heart fs-4 text-danger" id="favouriteplusicon<?php echo $tv_series_data['tv_series_code']; ?>" onclick="bookmarkAddToFavourite('<?php echo $tv_series_data['tv_series_code']; ?>','2');"></i>
                    </div>
                <?php
                } else {
                ?>
                    <div class="position-absolute bg-black" style="z-index: 5; margin-top: -6.8%;">
                        <i class="bi bi-bookmark-heart-fill fs-4 text-warning" id="favouriteplusicon<?php echo $tv_series_data['tv_series_code']; ?>" onclick="bookmarkAddToFavourite('<?php echo $tv_series_data['tv_series_code']; ?>','2');"></i>
                    </div>
                <?php
                }
            } else {
                ?>
                <div class="position-absolute bg-black" style="z-index: 5; margin-top: -6.8%;">
                    <i class="bi bi-bookmark-heart-fill fs-4 text-warning" onclick="alert('Please LogIn First');"></i>
                </div>
            <?php
            }
            ?>
        </div>

    </label>

<?php

}
?>