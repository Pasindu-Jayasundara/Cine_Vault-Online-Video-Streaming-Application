<?php
require "../connection/connection.php";

session_start();
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
        <title><?php echo $shop_data["name"]; ?> | Admin - Settings</title>

        <link rel="stylesheet" href="../css/bootstrap/bootstrap.css" />
        <link rel="stylesheet" href="../css/bootstrap/bootstrap.min.css" />
        <link rel="stylesheet" href="../css/other/sidebars.css" />
        <link rel="stylesheet" href="../css/sementic/semantic.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css" />

        <link rel="icon" href="<?php echo $shop_data["logo_link"]; ?>" />

    </head>

    <body>

        <div class="container-fluid d-flex ps-0">

            <?php include "sidebar.php"; ?>

            <div class="col-10 vh-100" style="overflow-y: scroll; overflow-x: hidden;">
                <div class="row">

                    <!-- update store details -->
                    <div class="accordion mt-3" style="z-index: 5;" id="accordionExample2">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne2">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne2" aria-expanded="true" aria-controls="collapseOne">
                                    Update Store Details
                                </button>
                            </h2>
                            <div id="collapseOne2" class="accordion-collapse collapse" aria-labelledby="headingOne2" data-bs-parent="#accordionExample2">
                                <div class="accordion-body">
                                    <?php
                                    $store_rs = Database::search("SELECT * FROM `shop`");
                                    if ($store_rs->num_rows == 1) {

                                        $store_data = $store_rs->fetch_assoc();

                                    ?>

                                        <!-- form -->
                                        <form class="row g-3 needs-validation" novalidate>
                                            <div class="col-md-4">
                                                <label class="form-label">Store Name</label>
                                                <input type="text" class="form-control" value="<?php echo $store_data["name"]; ?>" id="s_name" required />
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Email Address</label>
                                                <div class="input-group has-validation">
                                                    <span class="input-group-text">@</span>
                                                    <input type="text" class="form-control" value="<?php echo $store_data["email"]; ?>" id="s_email" required />
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Mobile</label>
                                                <input type="tel" class="form-control" value="<?php echo $store_data["mobile"]; ?>" id="s_mobile" required />
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Address Line 1</label>
                                                <input type="text" class="form-control" value="<?php echo $store_data["line_1"]; ?>" id="s_line_1" required />
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Address Line 2</label>
                                                <input type="text" class="form-control" value="<?php echo $store_data["line_2"]; ?>" id="s_line_2" required />
                                            </div>
                                            <label class="form-label">Logo</label>
                                            <div class="col-12">
                                                <div class="row d-flex justify-content-center">
                                                    <div class="col-5 d-flex justify-content-center">
                                                        <div class="row">
                                                            <div class="ui small image">
                                                                <image id="nowlogo" src="<?php echo $store_data["logo_link"]; ?>" style="width:150px; aspect-ratio: 1/1;" />
                                                            </div>
                                                            <i class="bi bi-arrow-repeat fs-2 fw-bold" id="re"></i>
                                                            <input type="file" id="logonew" onchange="loadLogo();" hidden />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <span class="btn btn-primary" onclick="updateStoreDetails();">Change</span>
                                            </div>
                                        </form>
                                        <!-- form -->

                                    <?php

                                    } else {
                                        // echo ("Something Went Wrong");
                                    ?>
                                        <p class="text-danger text-center col-12">Something Went Wrong</p>
                                    <?php
                                    }
                                    ?>

                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- update profile details -->
                    <div class="accordion mt-3" style="z-index: 5;" id="accordionExample5">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne5">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne5" aria-expanded="true" aria-controls="collapseOne5">
                                    Profile & Security Details
                                </button>
                            </h2>
                            <div id="collapseOne5" class="accordion-collapse collapse" aria-labelledby="headingOne5" data-bs-parent="#accordionExample5">
                                <p class="ms-3 fw-bold mt-3">Profile Details</p>
                                <div class="accordion-body d-flex justify-content-center align-items-center">
                                    <?php
                                    $admin_img_rs = Database::search("SELECT * FROM `admin_profile_image` WHERE `admin_profile_image`.`status_id`='1' 
                                    AND `admin_profile_image`.`admin_admin_id`='" . $_SESSION["admin"]["admin_id"] . "'");

                                    if ($admin_img_rs->num_rows == 1) {
                                        $admin_img_data = $admin_img_rs->fetch_assoc();
                                        $admin_img_url = $admin_img_data["link"];
                                    } else {
                                        $admin_img_url = "../admin_profile_image/admin.png";
                                    }

                                    $admin_email_rs = Database::search("SELECT * FROM `admin_email` WHERE `admin_email`.`admin_email_status_id`='1' 
                                    AND `admin_email`.`admin_admin_id`='" . $_SESSION["admin"]["admin_id"] . "'");

                                    $admin_email_data = $admin_email_rs->fetch_assoc();



                                    $admin_mobile_rs = Database::search("SELECT * FROM `admin_mobile` WHERE `admin_mobile`.`admin_mobile_status_id`='1' 
                                    AND `admin_mobile`.`admin_admin_id`='" . $_SESSION["admin"]["admin_id"] . "'");

                                    $admin_mobile_data = $admin_mobile_rs->fetch_assoc();



                                    $admin_address_rs = Database::search("SELECT * FROM `admin_address` WHERE `admin_address`.`admin_address_status_id`='1' 
                                    AND `admin_address`.`admin_admin_id`='" . $_SESSION["admin"]["admin_id"] . "'");

                                    $admin_address_data = $admin_address_rs->fetch_assoc();

                                    ?>
                                    <div class="d-flex  align-items-center">
                                        <div id="pnewimg" class="border border-2 border-primary d-flex align-items-end justify-content-center" style="border-radius: 175px; width: 350px; aspect-ratio: 1/1; background-image: url('<?php echo $admin_img_url; ?>'); background-repeat: no-repeat; background-size: cover; background-position: center;">
                                            <label for="pimg" class="btn btn-primary text-white" style="margin-bottom: 30px;">Upload Profile Image</label>
                                            <input type="file" id="pimg" onchange="loadprofileimg();" hidden />
                                        </div>
                                        <div class="w-100 ms-5">
                                            <div class="gap-3">
                                                <div class="d-flex gap-4">
                                                    <div style="width:80%">
                                                        <label class="form-label">First Name</label>
                                                        <input type="text" class="form-control" id="fproname" value="<?php echo $_SESSION["admin"]["first_name"]; ?>" />
                                                    </div>
                                                    <div style="width:80%">
                                                        <label class="form-label">Last Name</label>
                                                        <input type="text" class="form-control" id="lproname" value="<?php echo $_SESSION["admin"]["last_name"]; ?>" />
                                                    </div>
                                                </div>
                                                <div class="d-flex gap-4 mt-3">
                                                    <div style="width:80%">
                                                        <label class="form-label">Email</label>
                                                        <input type="email" class="form-control" id="prneemail" value="<?php echo $admin_email_data["email"]; ?>" />
                                                    </div>
                                                    <div style="width:80%">
                                                        <label class="form-label">Mobile</label>
                                                        <input type="tel" class="form-control" id="pronemo" value="<?php echo $admin_mobile_data["mobile"]; ?>" />
                                                    </div>
                                                </div>
                                                <div class="d-flex gap-4 mt-3">
                                                    <div style="width:80%">
                                                        <label class="form-label">Address Line 1</label>
                                                        <input type="text" class="form-control" id="proli1" value="<?php echo $admin_address_data["line_1"]; ?>" />
                                                    </div>
                                                    <div style="width:80%">
                                                        <label class="form-label">Address Line 2</label>
                                                        <input type="text" class="form-control" id="proli2" value="<?php echo $admin_address_data["line_2"]; ?>" />
                                                    </div>
                                                    <div style="width:80%">
                                                        <label class="form-label">City</label>
                                                        <select class="form-select" id="city" required>
                                                            <?php
                                                            $city_rs = Database::search("SELECT * FROM `city`");

                                                            $address_rs = Database::search("SELECT * FROM `admin_address` WHERE `admin_address`.`admin_admin_id`='" . $_SESSION["admin"]["admin_id"] . "' 
                                                            AND `admin_address`.`admin_address_status_id`='1'");

                                                            if ($address_rs->num_rows == 1) {
                                                                $address_data = $address_rs->fetch_assoc();

                                                                if ($city_rs->num_rows > 0) {
                                                                    for ($x = 0; $x < $city_rs->num_rows; $x++) {
                                                                        $city_data = $city_rs->fetch_assoc();

                                                            ?>
                                                                        <option value="<?php echo $city_data["id"]; ?>" <?php
                                                                                                                        if ($address_data["city_id"] == $city_data["id"]) {
                                                                                                                        ?> selected <?php
                                                                                                                                }
                                                                                                                                    ?>><?php echo $city_data["city"]; ?></option>
                                                                <?php
                                                                    }
                                                                }
                                                            } else {
                                                                ?>
                                                                <option>Something Went Wrong</option>
                                                            <?php
                                                            }

                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-4 d-flex justify-content-end">
                                                <span class="btn btn-warning" onclick="updateProfile();">Save Changes</span>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div id="collapseOne5" class="accordion-collapse collapse" aria-labelledby="headingOne5" data-bs-parent="#accordionExample5">
                                <hr />
                                <p class="ms-3 fw-bold mt-3">Security Details</p>
                                <div class="accordion-body ">
                                    <div class="ms-4 d-flex flex-column">
                                        <p class="">Change Password</p>
                                        <div class="d-flex flex-row gap-3 col-10">
                                            <input type="password" placeholder="Old Password" class="form-control" id="oldPassword" />
                                            <input type="password" placeholder="New Password" class="form-control" id="newPassword" />
                                            <input type="password" placeholder="Re-Type New Password" class="form-control" id="reNewPassword" />
                                            <span class="btn btn-success d-grid" onclick="updatePassword();">Update</span>
                                        </div>
                                        <p class="mt-5">Forgot Password</p>
                                        <div class="col-2">
                                            <span class="btn btn-warning d-grid" onclick="verifyMe();">Verify Me</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Update Database -->
                    <div class="accordion mt-3 " style="z-index: 5;" id="accordionExample1">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne1">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne1" aria-expanded="true" aria-controls="collapseOne">
                                    Update Database
                                </button>
                            </h2>
                            <div class="accordion-collapse collapse" id="collapseOne1" aria-labelledby="headingOne1" data-bs-parent="#accordionExample1">

                                <div class="accordion-body d-flex flex-row">
                                    <div class="accordion-body justify-content-center p-0 flex-row w-100">

                                        <div class="row row-cols-1 row-cols-md-auto g-4 flex-column justify-content-start float-start ">
                                            <div class="col">
                                                <div class="card border-0">
                                                    <div class="card-body" style="min-width:15vw">
                                                        <p class="fw-bold">Categories</p>
                                                        <div class="ms-4">
                                                            <?php
                                                            $type_rs = Database::search("SELECT * FROM `type`");
                                                            if ($type_rs->num_rows > 0) {
                                                                for ($type = 0; $type < $type_rs->num_rows; $type++) {
                                                                    $type_data = $type_rs->fetch_assoc();
                                                            ?>
                                                                    <div class="d-flex flex-row justify-content-between">
                                                                        <div class="d-flex flex-row">
                                                                            <div class="me-3">-</div>
                                                                            <div><?php echo $type_data["type"]; ?></div>
                                                                        </div>
                                                                        <i class="bi bi-pencil" id="<?php echo $type_data["id"]; ?>" onclick="edit('c',id,'<?php echo $type_data['type']; ?>');"></i>
                                                                    </div>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                            <div class="pe-3 d-flex justify-content-center btn btn-primary mt-3" onclick="addNew('c');">
                                                                Add New <i class="bi bi-plus-circle ms-3"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col">
                                                <div class="card border-0">
                                                    <div class="card-body" style="min-width:15vw">
                                                        <p class="fw-bold">Genre</p>
                                                        <div class="ms-4">
                                                            <?php
                                                            $genre_rs = Database::search("SELECT * FROM `genre`");
                                                            if ($genre_rs->num_rows > 0) {
                                                                for ($genre = 0; $genre < $genre_rs->num_rows; $genre++) {
                                                                    $genre_data = $genre_rs->fetch_assoc();
                                                            ?>
                                                                    <div class="d-flex flex-row justify-content-between">
                                                                        <div class="d-flex flex-row">
                                                                            <div class="me-3">-</div>
                                                                            <div><?php echo $genre_data["genre"]; ?></div>
                                                                        </div>
                                                                        <i class="bi bi-pencil" id="<?php echo $genre_data["genre_id"]; ?>" onclick="edit('g',id,'<?php echo $genre_data['genre']; ?>');"></i>
                                                                    </div>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                            <div class="pe-3 d-flex justify-content-center btn btn-primary mt-3" onclick="addNew('g');">
                                                                Add New <i class="bi bi-plus-circle ms-3"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row row-cols-1 row-cols-md-auto justify-content-start float-start border-box" style="max-width: 85%;">

                                            <div class="col">
                                                <div class="card border-0">
                                                    <div class="card-body" style="min-width:15vw">
                                                        <p class="fw-bold">Quality Types</p>
                                                        <div class="ms-4">
                                                            <?php
                                                            $quality_rs = Database::search("SELECT * FROM `quality`");
                                                            if ($quality_rs->num_rows > 0) {
                                                                for ($quality = 0; $quality < $quality_rs->num_rows; $quality++) {
                                                                    $quality_data = $quality_rs->fetch_assoc();
                                                            ?>
                                                                    <div class="d-flex flex-row justify-content-between">
                                                                        <div class="d-flex flex-row">
                                                                            <div class="me-3">-</div>
                                                                            <div><?php echo $quality_data["quality"]; ?></div>
                                                                        </div>
                                                                        <i class="bi bi-pencil" id="<?php echo $quality_data["quality_id"]; ?>" onclick="edit('q',id,'<?php echo $quality_data['quality']; ?>');"></i>
                                                                    </div>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                            <div class="pe-3 d-flex justify-content-center btn btn-primary mt-3" onclick="addNew('q');">
                                                                Add New <i class="bi bi-plus-circle ms-3"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col">
                                                <div class="card border-0">
                                                    <div class="card-body" style="min-width:15vw">
                                                        <p class="fw-bold">Years</p>
                                                        <div class="ms-4">
                                                            <?php
                                                            $year_rs = Database::search("SELECT * FROM `year`");
                                                            if ($year_rs->num_rows > 0) {
                                                                for ($year = 0; $year < $year_rs->num_rows; $year++) {
                                                                    $year_data = $year_rs->fetch_assoc();
                                                            ?>
                                                                    <div class="d-flex flex-row justify-content-between">
                                                                        <div class="d-flex flex-row">
                                                                            <div class="me-3">-</div>
                                                                            <div><?php echo $year_data["year"]; ?></div>
                                                                        </div>
                                                                        <i class="bi bi-pencil" id="<?php echo $year_data["year_id"]; ?>" onclick="edit('y',id,'<?php echo $year_data['year']; ?>');"></i>
                                                                    </div>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                            <div class="pe-3 d-flex justify-content-center btn btn-primary mt-3" onclick="addNew('y');">
                                                                Add New <i class="bi bi-plus-circle ms-3"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="card border-0">
                                                    <div class="card-body" style="min-width:15vw">
                                                        <p class="fw-bold">Languages</p>
                                                        <div class="ms-4">
                                                            <?php
                                                            $language_rs = Database::search("SELECT * FROM `language`");
                                                            if ($language_rs->num_rows > 0) {
                                                                for ($language = 0; $language < $language_rs->num_rows; $language++) {
                                                                    $language_data = $language_rs->fetch_assoc();
                                                            ?>
                                                                    <div class="d-flex flex-row justify-content-between">
                                                                        <div class="d-flex flex-row">
                                                                            <div class="me-3">-</div>
                                                                            <div><?php echo $language_data["language"]; ?></div>
                                                                        </div>
                                                                        <i class="bi bi-pencil" id="<?php echo $language_data["language_id"]; ?>" onclick="edit('c',id,'<?php echo $language_data['language']; ?>');"></i>
                                                                    </div>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                            <div class="pe-3 d-flex justify-content-center btn btn-primary mt-3" onclick="addNew('l');">
                                                                Add New <i class="bi bi-plus-circle ms-3"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="card border-0">
                                                    <div class="card-body" style="min-width:15vw">
                                                        <p class="fw-bold">Countries</p>
                                                        <div class="ms-4">
                                                            <?php
                                                            $country_rs = Database::search("SELECT * FROM `country`");
                                                            if ($country_rs->num_rows > 0) {
                                                                for ($country = 0; $country < $country_rs->num_rows; $country++) {
                                                                    $country_data = $country_rs->fetch_assoc();
                                                            ?>
                                                                    <div class="d-flex flex-row justify-content-between">
                                                                        <div class="d-flex flex-row">
                                                                            <div class="me-3">-</div>
                                                                            <div><?php echo $country_data["country"]; ?></div>
                                                                        </div>
                                                                        <i class="bi bi-pencil" id="<?php echo $country_data["country_id"]; ?>" onclick="edit('con',id,'<?php echo $country_data['country']; ?>');"></i>
                                                                    </div>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                            <div class="pe-3 d-flex justify-content-center btn btn-primary mt-3" onclick="addNew('con');">
                                                                Add New <i class="bi bi-plus-circle ms-3"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <img src="../design_images/settings.png" style="position: absolute; z-index: 1; width: 50vw; margin-left: 35%; margin-top:10%;">


                    <!-- update modal -->
                    <div class="modal" tabindex="-1" id="changeModal">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header bg-dark text-white">
                                    <h5 class="modal-title" id="modalTitle"></h5>
                                </div>
                                <div class="modal-body d-flex flex-row justify-content-between align-items-end">
                                    <div>
                                        <p>From :</p>
                                        <input type="text" disabled class="form-control" id="fromName" />
                                    </div>
                                    <i class="bi bi-arrow-right text-danger" style="font-size: xx-large;"></i>
                                    <div>
                                        <p>To :</p>
                                        <input type="text" class="form-control" id="toName" />
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" onclick="saveChanges();">Save changes</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- add modal -->
                    <div class="modal" tabindex="-1" id="addModal">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header bg-dark text-white">
                                    <h5 class="modal-title" id="addModalTitle"></h5>
                                </div>
                                <div class="modal-body d-flex flex-row justify-content-between align-items-end">
                                    <div>
                                        <p id="newNameP"></p>
                                        <input type="text" class="form-control" id="newNameInput" />
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" onclick="add();">Add</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>


            </div>

        </div>

        <!-- notification -->
        <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 7;">
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
        <!-- <script src="../js/bootstrap/bootstrap.bundle.min.js"></script> -->
        <script src="../js/other/settings.js"></script>
    </body>

    </html>

<?php
} else {
    header("Location:index.php");
}
?>