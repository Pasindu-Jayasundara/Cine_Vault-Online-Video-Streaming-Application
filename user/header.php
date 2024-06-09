<?php
// session_start();
// require "../connection/connection.php";

$shop_rs = Database::search("SELECT * FROM `shop`");
$shop_data = $shop_rs->fetch_assoc();
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title><?php echo $shop_data["name"]; ?> | Header</title>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css" />
  <link rel="stylesheet" href="../css/bootstrap/bootstrap.min.css" />
  <link rel="stylesheet" href="../css/other/header.css"/>
  <link rel="icon" href="<?php echo $shop_data["logo_link"]; ?>" />
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

</head>

<body>
  <header class="p-3 mb-3 border-bottom sticky-top bg-white">
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
        <a href="welcome.php" class="d-flex align-items-center mb-2 mb-lg-0 text-dark text-decoration-none">
          <img src="<?php echo $shop_data["logo_link"]; ?>" style="width:50%;" />
        </a>

        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
          <li><a href="movie.php" class="nav-link px-2 link-dark" id="moviePage">Movies</a></li>
          <li><a href="tv.php" class="nav-link px-2 link-dark" id="tvPage">Tv-Series</a></li>
          <li><a href="favourite.php" class="nav-link px-2 link-dark" id="favouritePage">Favourites</a></li>
          <li><a href="cart.php" class="nav-link px-2 link-dark" id="cartPage">Cart</a></li>
          <li><a href="price.php" class="nav-link px-2 link-dark" id="subPage">Subscription</a></li>
        </ul>

        <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" role="search">
          <input type="search" class="form-control" placeholder="Search..." aria-label="Search" id="searchText" onkeyup="searchContent();">
        </form>

        <div class="dropdown text-end">
          <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">

            <?php
            if (isset($_SESSION["user"]) && !empty($_SESSION["user"])) {

              $image_rs = Database::search("SELECT * FROM `profile_image` WHERE `profile_image`.`user_id`='" . $_SESSION["user"]["id"] . "' 
              AND `profile_image`.`status_id`='1' AND `profile_image`.`id`!='1'");
              $image_num = $image_rs->num_rows;

              if ($image_num == 1) {
                $image_data = $image_rs->fetch_assoc();
            ?>
                <img src="<?php echo $image_data["link"]; ?>" width="32" height="32" class="rounded-circle" />
              <?php
              } else {
              ?>
                <img src="../profile_image/user.png" width="32" height="32" class="rounded-circle" />
              <?php
              }

              ?>
            <?php
            } else {
            ?>
              <img src="../profile_image/user.png" width="32" height="32" class="rounded-circle" />
            <?php
            }
            ?>

          </a>
          <ul class="dropdown-menu text-small">

            <?php
            if (isset($_SESSION["user"]) && !empty($_SESSION["user"])) {
            ?>
              <li><a class="dropdown-item" style="cursor: pointer;" onclick="updateEmailModel();">Update Email</a></li>
              <li><a class="dropdown-item" style="cursor: pointer;" onclick="updatePasswordModel();">Update Password</a></li>
              <li><a class="dropdown-item" style="cursor: pointer;" onclick="forgotPasswordEmailModel();">Forgot Password</a></li>
              <li><a class="dropdown-item" style="cursor: pointer;" onclick="contact();">Contact</a></li>
              <li><a class="dropdown-item" style="cursor: pointer;" onclick="window.location.href='purchasedHistory.php';">Purchased History</a></li>
              <li><a class="dropdown-item" style="cursor: pointer;" onclick="settings();">Settings</a></li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li><a class="dropdown-item" style="cursor: pointer;" onclick="logout();">Log out</a></li>
            <?php
            } else {
            ?>
              <li><a class="dropdown-item" style="cursor: pointer;" onclick="signUpModel();">Sign Up</a></li>
              <li><a class="dropdown-item" style="cursor: pointer;" onclick="loginModel();">Log In</a></li>
            <?php
            }
            ?>

          </ul>
        </div>

        <?php
        if (isset($_SESSION["user"]) && !empty($_SESSION["user"])) {
        ?>
          <div class="text-end ms-5">
            <label class="text-black"><?php echo $_SESSION["user"]["first_name"] . " " . $_SESSION["user"]["last_name"]; ?></label>
          </div>
        <?php
        } else {
        ?>
          <div class="text-end ms-5">
            <button type="button" class="btn btn-outline-primary me-2" onclick="loginModel();">Login</button>
            <button type="button" class="btn btn-outline-success me-2" onclick="signUpModel();">SignUp</button>
          </div>
        <?php
        }
        ?>


      </div>

    </div>

  </header>

  <div class="container d-flex align-items-end justify-content-center mb-4 text-white" id="sortingDiv">

    <!-- quality -->
    <div class="col-md-1 ms-3">
      <label class="form-label">Quality :</label>
      <select class="form-select" id="quality" onchange="sort(value,id);">
        <option value="0">Choose..</option>
        <?php

        $quality_rs = Database::search("SELECT * FROM `quality` WHERE `quality`.`status_id`='1' ");
        $quality_rows = $quality_rs->num_rows;

        if ($quality_rows > 0) {

          for ($x = 0; $x < $quality_rows; $x++) {
            $quality_data = $quality_rs->fetch_assoc();
        ?>
            <option value="<?php echo $quality_data["quality_id"]; ?>"><?php echo $quality_data["quality"]; ?></option>
          <?php
          }
        } else {
          ?>
          <option>Couldn't load Data</option>
        <?php
        }

        ?>
      </select>
    </div>

    <!-- genre -->
    <div class="col-md-1 ms-3">
      <label for="validationCustom04" class="form-label">Genre :</label>
      <select class="form-select" id="genre" onchange="sort(value,id);">
        <option value="0">Choose..</option>
        <?php

        $genre_rs = Database::search("SELECT * FROM `genre` WHERE `genre`.`status_id`='1' ");
        $genre_rows = $genre_rs->num_rows;

        if ($genre_rows > 0) {

          for ($x = 0; $x < $genre_rows; $x++) {
            $genre_data = $genre_rs->fetch_assoc();
        ?>
            <option value="<?php echo $genre_data["genre_id"]; ?>"><?php echo $genre_data["genre"]; ?></option>
          <?php
          }
        } else {
          ?>
          <option>Couldn't load Data</option>
        <?php
        }

        ?>
      </select>
    </div>

    <div class="col-md-1 ms-3">
      <label for="validationCustom04" class="form-label">Year :</label>
      <select class="form-select" id="year" onchange="sort(value,id);">
        <option value="0">Choose..</option>
        <?php

        $year_rs = Database::search("SELECT * FROM `year` WHERE `year`.`status_id`='1' ");
        $year_rows = $year_rs->num_rows;

        if ($year_rows > 0) {

          for ($x = 0; $x < $year_rows; $x++) {
            $year_data = $year_rs->fetch_assoc();
        ?>
            <option value="<?php echo $year_data["year_id"]; ?>"><?php echo $year_data["year"]; ?></option>
          <?php
          }
        } else {
          ?>
          <option>Couldn't load Data</option>
        <?php
        }

        ?>
      </select>
    </div>

    <div class="col-md-1 ms-3">
      <label for="validationCustom04" class="form-label">Language :</label>
      <select class="form-select" id="language" onchange="sort(value,id);">
        <option value="0">Choose..</option>
        <?php

        $language_rs = Database::search("SELECT * FROM `language` WHERE `language`.`status_id`='1' ");
        $language_rows = $language_rs->num_rows;

        if ($language_rows > 0) {

          for ($x = 0; $x < $language_rows; $x++) {
            $language_data = $language_rs->fetch_assoc();
        ?>
            <option value="<?php echo $language_data["language_id"]; ?>"><?php echo $language_data["language"]; ?></option>
          <?php
          }
        } else {
          ?>
          <option>Couldn't load Data</option>
        <?php
        }

        ?>
      </select>
    </div>

    <div class="col-md-1 ms-3">
      <label for="validationCustom04" class="form-label">Country :</label>
      <select class="form-select" id="country" onchange="sort(value,id);">
        <option value="0">Choose..</option>
        <?php

        $country_rs = Database::search("SELECT * FROM `country`");
        $country_rows = $country_rs->num_rows;

        if ($country_rows > 0) {

          for ($x = 0; $x < $country_rows; $x++) {
            $country_data = $country_rs->fetch_assoc();
        ?>
            <option value="<?php echo $country_data["country_id"]; ?>"><?php echo $country_data["country"]; ?></option>
          <?php
          }
        } else {
          ?>
          <option>Couldn't load Data</option>
        <?php
        }

        ?>
      </select>
    </div>

  </div>

  <!-- log in Modal -->
  <div class="modal fade text-black" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content bg-black rounded-4 shadow">
        <div class="modal-header p-5 pb-4 border-bottom-0 ">
          <h1 class="fw-bold mb-0 fs-2 text-white offset-4 ps-3">Log In</h1>
          <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body p-5 pt-0">
          <form class="">
            <div class="form-floating mb-3">
              <input type="email" class="form-control rounded-3 bg-dark text-white" id="email" placeholder="name@example.com">
              <label class="text-white">Email address</label>
            </div>
            <div class="form-floating mb-3">
              <input type="password" class="form-control rounded-3 bg-dark text-white" id="password" placeholder="Password">
              <label class="text-white">Password</label>
            </div>
            <span class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" onclick="login();">Log In</span>
            <small class="text-muted ms-5">By clicking Log In, you agree to the terms of use.</small>
            <hr class="my-4">
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Sign Up Modal -->
  <div class="modal fade  text-black" id="signupModel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content bg-black rounded-4 shadow">
        <div class="modal-header p-5 pb-4 border-bottom-0">
          <h1 class="fw-bold mb-0 fs-2 text-white offset-4 ps-2">Sign Up</h1>
          <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body p-5 pt-0">
          <form class="row g-3 needs-validation" novalidate>
            <div class="col-md-6 text-white">
              <label class="form-label">First name</label>
              <input type="text" class="form-control bg-dark text-white" id="Sfname" required />
            </div>
            <div class="col-md-6 text-white">
              <label class="form-label">Last name</label>
              <input type="text" class="form-control bg-dark text-white" id="Slname" required />
            </div>
            <div class="col-md-12 text-white ">
              <label class="form-label">Email Address</label>
              <div class="input-group has-validation">
                <span class="input-group-text text-white bg-black">@</span>
                <input type="email" class="form-control bg-dark text-white" id="Semail" required />
              </div>
            </div>
            <div class="col-md-12 text-white">
              <label class="form-label">Password</label>
              <input type="Password" class="form-control bg-dark text-white" id="Spassword" required />
            </div>
            <small class="text-muted ms-5 mt-4">By clicking Sign Up, you agree to the terms of use.</small>
            <hr class="">
            <div class="col-12 d-flex justify-content-center">
              <span class="btn btn-primary col-6" onclick="signUp();">Sign Up</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Sign Up Modal Email verify -->
  <div class="modal fade text-white" id="signupModelEMailVerify" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content bg-black rounded-4 shadow">
        <div class="modal-header p-5 pb-4 border-bottom-0 d-flex justify-content-center">
          <h1 class="fw-bold mb-0 fs-2 text-center">Verify Your Email Address</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body p-5 pt-0">
          <form class="row g-3 needs-validation" novalidate>
            <div class="col-md-12">
              <label class="form-label">Verification Code</label>
              <input type="text" class="form-control" id="newUserVCode" required />
            </div>
            <div class="col-12">
              <span class="btn btn-primary" onclick="verify();">Verify</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- new verify email Modal -->
  <div class="modal fade text-white  " id="verifyEmailModel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog border bg-black" role="document">
      <div class="modal-content bg-black rounded-4 shadow">
        <div class="modal-header p-5 pb-4 border-bottom-0">
          <h1 class="fw-bold mb-0 fs-4 offset-3 ps-4">Verify Email</h1>
          <button type="button" class="btn-close bg-secondary" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body p-5 pt-0">
          <form class="">
            <div class="form-floating mb-3">
              <input type="email" class="form-control rounded-3 bg-dark text-white" id="old_email" placeholder="name@example.com">
              <label>Old Email address</label>
            </div>
            <div class="form-floating mb-3">
              <input type="email" class="form-control rounded-3 bg-dark text-white" id="new_email" placeholder="name@example.com">
              <label>New Email address</label>
            </div>
            <span class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" onclick="verifyEmail();">Verify</span>
            <hr class="my-4">
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- update email Modal -->
  <div class="modal text-white fade" id="updateEmailModel2" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog " role="document">
      <div class="modal-content bg-black rounded-4 shadow">
        <div class="modal-header p-5 pb-4 border-bottom-0">
          <h1 class="fw-bold mb-0 text-white fs-4 offset-3 ps-4">Update Email</h1>
          <button type="button" class="btn-close bg-secondary" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body p-5 pt-0">
          <form class="">
            <div class="form-floating mb-3 text-white">
              <input type="text" class="form-control rounded-3 text-white bg-dark" id="v_code" />
              <label >Verification Code</label>
            </div>
            <span class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" onclick="updateEmail();">Update Email</span>
            <hr class="my-4">
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- verify password Modal -->
  <div class="modal fade text-white" id="verifyPasswordModel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content bg-black rounded-4 shadow">
        <div class="modal-header p-5 pb-4 border-bottom-0">
          <h1 class="fw-bold mb-0 text-white fs-4 offset-3 ps-4">Verify Password</h1>
          <button type="button" class="btn-close bg-secondary" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body p-5 pt-0">
          <form class="">
            <div class="form-floating mb-3">
              <input type="password" class="form-control rounded-3 bg-dark text-white" id="old_password" />
              <label>Old Password</label>
            </div>
            <div class="form-floating mb-3">
              <input type="password" class="form-control rounded-3 bg-dark text-white" id="new_password" />
              <label>New Password</label>
            </div>
            <span class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" onclick="verifyPassword();">Verify</span>
            <hr class="my-4">
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- update password Modal -->
  <div class="modal fade text-white" id="verifyPasswordModel2" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog " role="document">
      <div class="modal-content bg-dark rounded-4 shadow">
        <div class="modal-header p-5 pb-4 border-bottom-0">
          <h1 class="fw-bold mb-0 fs-4 offset-3 ps-4">Update Password</h1>
          <button type="button" class="btn-close bg-secondary" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body p-5 pt-0">
          <form class="">
            <div class="form-floating mb-3">
              <input type="text" class="form-control rounded-3 bg-dark text-white" id="pv_code" />
              <label>Verification Code</label>
            </div>
            <span class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" onclick="updatePassword();">Update Password</span>
            <hr class="my-4">
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- forgot passsword email Modal -->
  <div class="modal fade text-white" id="forgotPasswordEmailModel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content bg-black rounded-4 shadow">
        <div class="modal-header p-5 pb-4 border-bottom-0">
          <h1 class="fw-bold mb-0 fs-4 offset-3 ps-4">Verify Email Address</h1>
          <button type="button" class="btn-close bg-secondary" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body p-5 pt-0">
          <form class="">
            <div class="form-floating mb-3">
              <input type="email" class="form-control rounded-3 bg-dark text-white" id="forgot_password_email" />
              <label>Your Email Address</label>
            </div>
            <span class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" onclick="verifyForgotPasswordEmail();">Verify</span>
            <hr class="my-4">
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- forgot passsword email verification Modal -->
  <div class="modal fade text-white" id="forgotPasswordEmailVerificationModel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content bg-black rounded-4 shadow">
        <div class="modal-header p-5 pb-4 border-bottom-0">
          <h1 class="fw-bold mb-0 fs-4 offset-3 ps-4">Verify Email Address</h1>
          <button type="button" class="btn-close bg-secondary" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body p-5 pt-0">
          <form class="">
            <div class="form-floating mb-3">
              <input type="text" class="form-control rounded-3 bg-dark text-white" id="forgotPasswordEmailVerificationCode" />
              <label>Email Verification Code</label>
            </div>
            <span class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" onclick="forgotPasswordEmailVerfication();">Verify</span>
            <hr class="my-4">
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- new password Modal -->
  <div class="modal fade text-white" id="newPasswordModel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content bg-black rounded-4 shadow">
        <div class="modal-header p-5 pb-4 border-bottom-0">
          <h1 class="fw-bold mb-0 fs-4 offset-3 ps-4">Reset Password</h1>
          <button type="button" class="btn-close bg-secondary" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body p-5 pt-0">
          <form class="">
            <div class="form-floating mb-3">
              <input type="password" class="form-control bg-dark text-white rounded-3" id="forgotPasswordNewPassword" />
              <label>Enter Your New Password</label>
            </div>
            <span class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" onclick="updateForgotPassword();">Update Password</span>
            <hr class="my-4">
          </form>
        </div>
      </div>
    </div>
  </div>


  <!-- send msg model -->
  <div class="modal text-white" tabindex="-1" id="contactModel" data-bs-backdrop="static">
    <div class="modal-dialog">
      <div class="modal-content bg-black">
        <div class="modal-header">
          <h5 class="modal-title text-center fs-4 offset-3 ps-4">SEND A MESSAGE</h5>
          <button type="button" class="btn-close bg-secondary" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <?php
        $email_rs = Database::search("SELECT * FROM `user_email` INNER JOIN `user` ON `user`.`id`=`user_email`.`user_id` 
        WHERE `user`.`id`='" . $_SESSION["user"]["id"] . "' AND `user`.`status_id`='1' AND `user_email`.`status_id`='1'");

        $email_data = $email_rs->fetch_assoc();
        ?>
        <div class="modal-body">
          <div class="my-3">
            <span>From : </span>
            <span><?php echo $email_data["email"]; ?></span>
          </div>
          <div>
            <textarea class="p-3 text-primary bg-dark text-white" id="textToAdmin" cols="57" rows="5"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <span class="btn btn-danger" data-bs-dismiss="modal">Close</span>
          <span class="btn btn-success" onclick="msgToAdmin();">Send Message</span>
        </div>
      </div>
    </div>
  </div>

  <?php
  if (!empty($_SESSION["user"]) && isset($_SESSION["user"])) {
    $p_img_rs = Database::search("SELECT * FROM `profile_image` INNER JOIN `user` ON `user`.`id`=`profile_image`.`user_id` 
  WHERE `user`.`id`='" . $_SESSION["user"]["id"] . "' AND `user`.`status_id`='1' AND `profile_image`.`status_id`='1' AND `profile_image`.`id`!='1'");
  ?>
    <!-- setting model -->
    <div class="modal text-white" tabindex="-1" id="setting" data-bs-backdrop="static">
      <div class="modal-dialog">
        <div class="modal-content bg-black">
          <div class="modal-header d-flex justify-content-center">

            <?php
            if ($p_img_rs->num_rows == 1) {
              $p_img_data = $p_img_rs->fetch_assoc();
            ?>
              <div class="rounded-circle" id="img" style="width: 200px; height: 200px; background-image: url('<?php echo $p_img_data["link"]; ?>');background-size: cover; background-position: center; background-repeat: no-repeat;"></div>
            <?php
            } else {
            ?>
              <div class="rounded-circle" id="img" style="width: 200px; height: 200px; background-image: url('../profile_image/user.png');background-size: cover; background-position: center; background-repeat: no-repeat;"></div>
            <?php
            }
            ?>
            <div class="rounded-circle d-none" id="img2" style="width: 200px; height: 200px; background-size: cover; background-position: center; background-repeat: no-repeat;"></div>
          </div>
          <div class="modal-body d-flex justify-content-between">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
            <span>
              <?php
              if ($p_img_rs->num_rows == 1) {
              ?>
                <label for="file" class="btn btn-primary">Change</label>
                <input type="file" id="file" class="d-none" onchange="check();">
              <?php
              } else {
              ?>
                <label for="file" class="btn btn-primary">Upload</label>
                <input type="file" id="file" class="d-none" onchange="check();">
              <?php
              }
              ?>
              <button type="button" class="btn btn-success" onclick="saveProfile();">Save</button>
            </span>
          </div>
        </div>
      </div>
    </div>
  <?php
  }

  ?>



<!-- notification -->
  <?php
  if (!empty($_SESSION["user"])) {
  ?>
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
      <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header bg-secondary text-white" id="headerColor">
          <?php
          $ms_img_rs = Database::search("SELECT * FROM `profile_image` INNER JOIN `user` ON `user`.`id`=`profile_image`.`user_id` 
                                    WHERE `user`.`id`='" . $_SESSION["user"]["id"] . "' AND `user`.`status_id`='1' AND `profile_image`.`status_id`='1'");

          if ($ms_img_rs->num_rows == 1) {
            $ms_img_data = $ms_img_rs->fetch_assoc();
          ?>
            <img src="<?php echo $ms_img_data["link"]; ?>" class="rounded me-2" style="width:20px;" />
          <?php
          }
          ?>
          <strong class="me-auto">Message</strong>
          <small id="time"></small>
          <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body" id="msg">

        </div>
      </div>
    </div>
  <?php
  }
  ?>

  <script src="../js/bootstrap/bootstrap.bundle.min.js"></script>
  <script src="../js/other/header.js"></script>

  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <script>
  AOS.init();
</script>

</body>

</html>