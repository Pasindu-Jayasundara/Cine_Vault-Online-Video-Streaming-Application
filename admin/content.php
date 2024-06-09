<?php
session_start();
require "../connection/connection.php";

if (!empty($_SESSION["admin"])) {

    $shop_rs = Database::search("SELECT * FROM `shop`");
    $shop_data = $shop_rs->fetch_assoc();

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $shop_data["name"]; ?> | Admin - Content</title>

        <link rel="stylesheet" href="../css/bootstrap/bootstrap.css" />
        <link rel="stylesheet" href="../css/bootstrap/bootstrap.min.css" />
        <link rel="stylesheet" href="../css/other/sidebars.css">
        <link rel="stylesheet" href="../css/sementic/semantic.css">

        <link rel="icon" href="<?php echo $shop_data["logo_link"]; ?>" />

    </head>

    <body>

        <div class="container-fluid d-flex ps-0">

            <?php include "sidebar.php"; ?>

            <div class="col-10 vh-100" style="overflow-y: scroll; overflow-x: hidden;">
                <div class="row">

                    <!-- search content -->
                    <div class="accordion mt-3 " id="accordionExample1">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne1">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne1" aria-expanded="true" aria-controls="collapseOne">
                                    Search Content
                                </button>
                            </h2>
                            <div class="accordion-collapse collapse show" id="collapseOne1" aria-labelledby="headingOne1" data-bs-parent="#accordionExample1">
                                <div class="accordion-body">

                                    <!-- form -->
                                    <form class="row g-3 needs-validation" novalidate>
                                        <div class="col-md-3">
                                            <label for="validationCustom04" class="form-label">Type</label>
                                            <select class="form-select" id="searchType" required>
                                                <option value="1">Movie</option>
                                                <option value="2">Tv-Series</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3" id="">
                                            <label class="form-label">Name</label>
                                            <input type="text" class="form-control" id="content_name" required />
                                        </div>
                                        <div class="col-2 p-2">
                                            <span class="btn btn-primary mt-4" onclick="searchContent();">Search</span>
                                        </div>
                                    </form>
                                    <!-- form -->

                                    <div id="contentDisplayDiv"></div>

                                </div>

                                <hr />
                                <!-- search episode -->
                                <div class="accordion-body">
                                    <p class="fw-bold">Search Episodes</p>

                                    <!-- form -->
                                    <form class="row g-3 needs-validation ms-4" novalidate>
                                        <div class="col-md-3">
                                            <label class="form-label">Tv-Series Name</label>
                                            <select class="form-select" id="episodeSearchTvSeries" required>
                                                <option value="0">Select Tv-Series ...</option>
                                                <?php
                                                $tv_rs = Database::search("SELECT * FROM `tv_series` WHERE `tv_series`.`status_id`='1'");
                                                if ($tv_rs->num_rows > 0) {
                                                    for ($x = 0; $x < $tv_rs->num_rows; $x++) {
                                                        $tv_data = $tv_rs->fetch_assoc();
                                                ?>
                                                        <option value="<?php echo $tv_data["id"]; ?>"><?php echo $tv_data["name"]; ?></option>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="col-2 p-2">
                                            <span class="btn btn-primary mt-4" onclick="searchEpisode();">Search</span>
                                        </div>
                                    </form>
                                    <!-- form -->

                                    <div id="episodeContentDisplayDiv"></div>

                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- add upcomming -->
                    <div class="accordion mt-5" id="accordionExample2">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne2">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne2" aria-expanded="true" aria-controls="collapseOne">
                                    Upcomming Content
                                </button>
                            </h2>
                            <div id="collapseOne2" class="accordion-collapse collapse " aria-labelledby="headingOne2" data-bs-parent="#accordionExample2">
                                <div class="accordion-body">
                                    <p class="fw-bold">Search Upcomming Content</p>
                                    <!-- form -->
                                    <form class="row g-3 needs-validation ms-4" novalidate>
                                        <div class="col-md-3">
                                            <label class="form-label">Content Name</label>
                                            <input type="text" class="form-control" id="search_content_name" required />
                                        </div>
                                        <div class="col-2 p-2">
                                            <span class="btn btn-primary mt-4" onclick="searchUpcommingContent();">Search</span>
                                        </div>
                                    </form>
                                    <!-- form -->

                                    <div id="searchedUpcomminContent"></div>

                                </div>
                                <hr />

                                <div class="accordion-body">
                                    <p class="fw-bold">Add New Upcomming Content</p>

                                    <!-- form -->
                                    <form class="row g-3 needs-validation ms-4" novalidate>
                                        <div class="col-md-3" id="fname2">
                                            <label class="form-label">Content Name</label>
                                            <input type="text" class="form-control" id="new_content_name" required />
                                        </div>
                                        <div class="col-md-3" id="lname2">
                                            <label class="form-label">Release Date</label>
                                            <input type="date" class="form-control" id="new_content_release_date" required />
                                        </div>
                                        <div class="col-2 p-2">
                                            <label for="epi" class="btn btn-success mt-4" id="epi2">Select Cover Photo</span>
                                                <input type="file" id="epi" class="d-none" accept="image/*" />
                                        </div>
                                        <div class="col-2 p-2">
                                            <span class="btn btn-danger mt-4" onclick="addUpcommingContent();">Upload</span>
                                        </div>
                                    </form>
                                    <!-- form -->

                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- add episode -->
                    <div class="accordion mt-5" id="accordionExample3">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne3">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne3" aria-expanded="true" aria-controls="collapseOne3">
                                    Upload Episodes
                                </button>
                            </h2>
                            <div id="collapseOne3" class="accordion-collapse collapse" aria-labelledby="headingOne3" data-bs-parent="#accordionExample3">
                                <div class="accordion-body">

                                    <!-- form -->
                                    <form class="row g-3 needs-validation" novalidate>
                                        <div class="col-md-3">
                                            <label for="validationCustom04" class="form-label">Tv-Series</label>
                                            <select class="form-select" id="select_tv" required>
                                                <?php
                                                $tv_rs = Database::search("SELECT * FROM `tv_series` WHERE `tv_series`.`status_id`='1'");
                                                if ($tv_rs->num_rows > 0) {
                                                    for ($x = 0; $x < $tv_rs->num_rows; $x++) {
                                                        $tv_data = $tv_rs->fetch_assoc();
                                                ?>
                                                        <option value="<?php echo $tv_data["id"]; ?>"><?php echo $tv_data["name"]; ?></option>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-3" id="fname2">
                                            <label class="form-label">Episode Name</label>
                                            <input type="text" class="form-control" id="episode_name" required />
                                        </div>
                                        <div class="col-md-3" id="lname2">
                                            <label class="form-label">Duration</label>
                                            <div class="d-flex">
                                                <input type="number" min="0" max="24" placeholder="Hours" class="form-control" id="hours" required />
                                                <input type="number" min="0" max="59" placeholder="Minutes" class="form-control" id="minutes" required />
                                            </div>
                                        </div>
                                        <div class="col-2 p-2">
                                            <label for="episodeFile" id="epilabel" class="btn btn-success mt-4">Select Episode</span>
                                                <input type="file" id="episodeFile" class="d-none" accept="video/*" />
                                        </div>
                                        <div class="col-md-3" id="ep_rating">
                                            <label class="form-label">Episode Rating</label>
                                            <input type="text" class="form-control" id="episode_rating" required />
                                        </div>
                                        <div class="col-2 p-2">
                                            <span class="btn btn-danger mt-4" onclick="uploadEpisode();">Upload</span>
                                        </div>
                                    </form>
                                    <!-- form -->

                                </div>
                            </div>
                        </div>
                    </div>

                    <!--add content -->
                    <div class="accordion mt-5" id="accordionExample4">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne4">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne4" aria-expanded="true" aria-controls="collapseOne4">
                                    Add New Content
                                </button>
                            </h2>
                            <div id="collapseOne4" class="accordion-collapse collapse show" aria-labelledby="headingOne4" data-bs-parent="#accordionExample4">
                                <div class="accordion-body">

                                    <!-- form -->
                                    <form class="row g-3 needs-validation" novalidate>
                                        <div class="col-md-3">
                                            <label for="validationCustom04" class="form-label">Type</label>
                                            <select class="form-select" id="type" onchange="changeNewType(value);" required>
                                                <option value="0">Select Content Type ...</option>
                                                <?php
                                                $type_rs = Database::search("SELECT * FROM `type`");
                                                if ($type_rs->num_rows > 0) {
                                                    for ($x = 0; $x < $type_rs->num_rows; $x++) {
                                                        $type_data = $type_rs->fetch_assoc();
                                                ?>
                                                        <option value="<?php echo $type_data["id"]; ?>"><?php echo $type_data["type"]; ?></option>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="validationCustom04" class="form-label">Genre</label>
                                            <select class="form-select" id="genre" required>
                                                <option value="0">Select Content Genre ...</option>
                                                <?php
                                                $genre_rs = Database::search("SELECT * FROM `genre` WHERE `status_id`='1'");
                                                if ($genre_rs->num_rows > 0) {
                                                    for ($y = 0; $y < $genre_rs->num_rows; $y++) {
                                                        $genre_data = $genre_rs->fetch_assoc();
                                                ?>
                                                        <option value="<?php echo $genre_data["genre_id"]; ?>"><?php echo $genre_data["genre"]; ?></option>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="validationCustom04" class="form-label">Quality</label>
                                            <select class="form-select" id="quality" required>
                                                <option value="0">Select Content Quality ...</option>
                                                <?php
                                                $quality_rs = Database::search("SELECT * FROM `quality` WHERE `status_id`='1'");
                                                if ($quality_rs->num_rows > 0) {
                                                    for ($z = 0; $z < $quality_rs->num_rows; $z++) {
                                                        $quality_data = $quality_rs->fetch_assoc();
                                                ?>
                                                        <option value="<?php echo $quality_data["quality_id"]; ?>"><?php echo $quality_data["quality"]; ?></option>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="validationCustom04" class="form-label">Language</label>
                                            <select class="form-select" id="language" required>
                                                <option value="0">Select Content Language ...</option>
                                                <?php
                                                $language_rs = Database::search("SELECT * FROM `language` WHERE `status_id`='1'");
                                                if ($language_rs->num_rows > 0) {
                                                    for ($a = 0; $a < $language_rs->num_rows; $a++) {
                                                        $language_data = $language_rs->fetch_assoc();
                                                ?>
                                                        <option value="<?php echo $language_data["language_id"]; ?>"><?php echo $language_data["language"]; ?></option>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="validationCustom04" class="form-label">Year</label>
                                            <select class="form-select" id="year" required>
                                                <option value="0">Select Content Year ...</option>
                                                <?php
                                                $year_rs = Database::search("SELECT * FROM `year` WHERE `status_id`='1'");
                                                if ($year_rs->num_rows > 0) {
                                                    for ($q = 0; $q < $year_rs->num_rows; $q++) {
                                                        $year_data = $year_rs->fetch_assoc();
                                                ?>
                                                        <option value="<?php echo $year_data["year_id"]; ?>"><?php echo $year_data["year"]; ?></option>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="validationCustom04" class="form-label">Country</label>
                                            <select class="form-select" id="country" required>
                                                <option value="0">Select Content Country ...</option>
                                                <?php
                                                $country_rs = Database::search("SELECT * FROM `country` WHERE `status_id`='1'");
                                                if ($country_rs->num_rows > 0) {
                                                    for ($r = 0; $r < $country_rs->num_rows; $r++) {
                                                        $country_data = $country_rs->fetch_assoc();
                                                ?>
                                                        <option value="<?php echo $country_data["country_id"]; ?>"><?php echo $country_data["country"]; ?></option>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Name</label>
                                            <input type="text" class="form-control" id="adding_name" required />
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Director</label>
                                            <input type="text" class="form-control" id="adding_director" required />
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Price</label>
                                            <div class="input-group mb-3 col-md-3">
                                                <span class="input-group-text">Rs.</span>
                                                <input type="number" placeholder="Insert The Price" class="form-control" id="adding_price" />
                                                <span class="input-group-text">.00</span>
                                            </div>
                                            <label class="form-label">Cover Image</label>

                                            <div id="bgCover" class="border border-1 border-secondary d-flex justify-content-center align-items-center" style="height: 72%;">
                                                <label for="adding_img" id="addimg_img_label" class="btn btn-success">Select Cover Photo</label>
                                                <input type="file" id="adding_img" class="d-none" onchange="cover();" accept="image/*" />
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="d-flex flex-row gap-3 mt-0 mb-3">
                                                <div class="col-md-9">
                                                    <label class="form-label">Released Date</label>
                                                    <input type="date" class="form-control" id="releasedDate" required />
                                                </div>
                                                <div class="col-md-9">
                                                    <label class="form-label">Length</label>
                                                    <div class=" d-flex flex-row">
                                                        <input type="number" id="newContentHours" placeholder="Hours" min="0" max="24" class="form-control" required />
                                                        <input type="number" id="newContentMinutes" placeholder="Minutes" min="0" max="59" class="form-control" required />
                                                    </div>
                                                </div>
                                                <div class="col-md-9" id="ep_rating">
                                                    <label class="form-label">Ratings</label>
                                                    <input type="text" class="form-control" id="c_rating" required />
                                                </div>
                                            </div>
                                            <label class="form-label">Description</label>
                                            <textarea id="adding_description" cols="132" rows="11" class="p-4"></textarea>
                                        </div>
                                        <label for="adding_movie" class="btn btn-primary d-none" id="upload_movie_lable">Upload Movie</label>
                                        <div class="border border-1 border-secondary d-flex justify-content-center align-items-center" style="height: 72%;">
                                            <input type="file" id="adding_movie" class="d-none" accept="video/*" />
                                        </div>
                                        <div class="col-12">
                                            <span class="btn btn-danger" onclick="addNewContent();">Add Content</span>
                                        </div>
                                    </form>
                                    <!-- form -->

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- notification -->
                <div class="toast-container position-fixed bottom-0 end-0 p-3">
                    <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="toast-header bg-secondary text-white" id="headerColor">

                            <strong class="me-auto">Message</strong>
                            <small id="time"></small>
                            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                        <div class="toast-body" id="msg">

                        </div>
                    </div>
                </div>

                <!-- admin status change -->
                <div class="modal" tabindex="-1" data-bs-backdrop="static" id="statusChange">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Reason For Deactivate Admin</h5>
                            </div>
                            <div class="modal-body">
                                <textarea rows="6" cols="70" style="padding: 15;" placeholder="Enter Your Reason Here ..." id="reason"></textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" onclick="changeStatus();">Change Status</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- episode status change -->
                <div class="modal" tabindex="-1" data-bs-backdrop="static" id="statusChange2">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Reason For Deactivate Episode</h5>
                            </div>
                            <div class="modal-body">
                                <textarea rows="6" cols="70" style="padding: 15;" placeholder="Enter Your Reason Here ..." id="episode_reason"></textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" onclick="episodeChangeStatus();">Change Status</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- <script src="../js/bootstrap/bootstrap.bundle.min.js"></script> -->
        <script src="../js/other/content.js"></script>
    </body>

    </html>

<?php
} else {
    header("Location:index.php");
}
?>