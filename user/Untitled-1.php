<?php

            $query = "(SELECT * FROM `movie` WHERE `movie`.`status_id`='1' ORDER BY RAND() LIMIT 5) UNION (SELECT * FROM `tv_series` WHERE `tv_series`.`status_id`='1' ORDER BY RAND() LIMIT 5) ORDER BY RAND() LIMIT 10";
            $rs = Database::search($query);
            $num = $rs->num_rows;

            ?>
            <div class="col-12 p-0">
                <div class="row blackBG">

                    <!-- carousel myCarousel -->
                    <div id="myCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner" style="width: 100%; height: 100vh;" id="imgs">
                            <?php
                            for ($x = 0; $x < $num; $x++) {
                                $data = $rs->fetch_assoc();

                                $table_find_query = "SELECT * FROM `movie` WHERE `movie`.`code`='" . $data["code"] . "' AND `movie`.`status_id`='1'";
                                $table_find_rs = Database::search($table_find_query);
                                $table_find_num = $table_find_rs->num_rows;

                                if ($table_find_num > 0) { //then it is a movie
                                    $movie_rs = Database::search("SELECT * FROM `movie_cover` WHERE `movie_cover`.`movie_code`='" . $data["code"] . "' AND `movie_cover`.`status_id`='1'");
                                    $movie_data = $movie_rs->fetch_assoc();
                            ?>

                                    <div class="carousel-item" style="width: 100%; height: 100vh;">
                                        <img src="<?php echo $movie_data["link"]; ?>" style="width: 100%; height: 100vh; background-size: contain;">
                                    </div>

                                <?php
                                } else { //check tv_series

                                    $tv_series_rs = Database::search("SELECT * FROM `tv_series_cover` WHERE `tv_series_cover`.`tv_series_code`='" . $data["code"] . "' AND `tv_series_cover`.`status_id`='1'");
                                    $tv_series_data = $tv_series_rs->fetch_assoc();

                                ?>

                                    <div class="carousel-item" style="width: 100%; height: 100vh;">
                                        <img src="<?php echo $tv_series_data["link"]; ?>" style="width: 100%; height: 100vh; background-size: contain;">
                                    </div>

                            <?php
                                }
                            }
                            ?>
                        </div>
                    </div>

                </div>
            </div>