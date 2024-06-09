<?php
// require "../connection/connection.php";

$shop_rs = Database::search("SELECT * FROM `shop`");
$shop_data = $shop_rs->fetch_assoc();
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title><?php echo $shop_data["logo_link"]; ?> | Footer</title>

  <link rel="stylesheet" href="../css/bootstrap/bootstrap.min.css" />
  <link rel="stylesheet" href="../css/other/footer.css" />
  <link rel="icon" href="<?php echo $shop_data["logo_link"]; ?>" />
</head>

<body>

  <div class="b-example-divider"></div>

  <div class="container">
    <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
      <div class="col-md-4 d-flex align-items-center">
        <a href="../user/welcome.php" class="mb-3 me-2 mb-md-0 text-muted text-decoration-none lh-1">
          <img src="<?php echo $shop_data["logo_link"]; ?>" style="width:50%; filter:grayscale(5)" />
        </a>
        <div class="d-flex flex-column">
          <span class="mb-3 mb-md-0 text-muted"><?php echo $shop_data["email"]; ?></span>
          <span class="mb-3 mt-2 mb-md-0 text-muted">Copyright &copy; 2023 <?php echo $shop_data["name"]; ?>. All Rights Reserved.</span>
        </div>
      </div>

      <ul class="nav col-md-4 justify-content-end list-unstyled d-flex">
        <li class="ms-3"><a class="text-muted" href="#"><svg class="bi" width="24" height="24">
              <use xlink:href="#twitter" />
            </svg></a></li>
        <li class="ms-3"><a class="text-muted" href="#"><svg class="bi" width="24" height="24">
              <use xlink:href="#instagram" />
            </svg></a></li>
        <li class="ms-3"><a class="text-muted" href="#"><svg class="bi" width="24" height="24">
              <use xlink:href="#facebook" />
            </svg></a></li>
      </ul>
    </footer>
  </div>



</body>

</html>