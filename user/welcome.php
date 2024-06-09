<?php
require "../connection/connection.php";
session_start();

$shop_rs = Database::search("SELECT * FROM `shop`");
$shop_data = $shop_rs->fetch_assoc();
?>
<!doctype html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Welcome To <?php echo $shop_data["name"]; ?></title>

    <link rel="stylesheet" href="../css/bootstrap/bootstrap.min.css" />
    <link rel="stylesheet" href="../css/other/cover.css" />
    <link rel="icon" href="<?php echo $shop_data["logo_link"]; ?>" />
    
</head>

<body>

    <video muted loop autoplay width="100%" height="100%" style="z-index: 1; position: absolute; object-fit: cover;">
        <source src="../design_videos/6.mp4" />
    </video>

    <div class="container-fluid m-0 p-0 overflow-hidden " style="z-index: 2;">
        <div class="row p-0 m-0">

            <div class="col-12 he d-flex justify-content-center text-center p-3">
                <div class="row ">
                    <img src="<?php echo $shop_data["logo_link"]; ?>" style="width:80px; position:absolute; margin-left:-4%; margin-top:-0.8%" />
                    <h3 class="float-md-start mb-0"><?php echo $shop_data["name"]; ?></h3>
                </div>
            </div>
            <!-- was here -->

            <div class="col-12 con">
                <div class="row">
                    <h1>WELCOME TO <?php echo $shop_data["name"]; ?></h1>
                    <p class="lead"><?php echo $shop_data["name"]; ?> is your one-stop destination for all things cinema. We offer a wide selection of classic and hard-to-find films, from timeless favorites to hidden gems. Our collection is carefully curated to ensure that every movie lover will find something to love. Whether you're a film buff or just looking for something new to watch, you'll find it at <?php echo $shop_data["name"]; ?>. Shop now and discover the magic of cinema.
                    <p class="lead">
                        <a href="index.php" class="btn btn-lg btn-success fw-bold border-white">Get Started </a>
                    </p>
                    </p>
                </div>
            </div>

        </div>
    </div>

    
    <script src="../js/bootstrap/bootstrap.bundle.min.js"></script>
    <script src="../js/other/welcome.js"></script>
</body>

</html>