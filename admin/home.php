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
        <title><?php echo $shop_data["name"]; ?> | Admin - Home</title>

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

                    <!-- admin control -->
                    <div class="accordion mt-3 mb-5" id="accordionExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Search Admins
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                <div class="accordion-body">

                                    <!-- form -->
                                    <form class="row g-3 needs-validation" novalidate>
                                        <div class="col-md-3">
                                            <label for="validationCustom04" class="form-label">By</label>
                                            <select class="form-select" id="searchType" onchange="search_type();" required>
                                                <option value="1">Email</option>
                                                <option value="2">Name</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4" id="username">
                                            <label class="form-label">Username</label>
                                            <div class="input-group has-validation">
                                                <span class="input-group-text" id="">@</span>
                                                <input type="text" class="form-control" id="email" required />
                                            </div>
                                        </div>
                                        <div class="col-md-3 d-none" id="fname">
                                            <label class="form-label">First Name</label>
                                            <input type="text" class="form-control" id="firstName" required />
                                        </div>
                                        <div class="col-md-3 d-none" id="lname">
                                            <label class="form-label">Last Name</label>
                                            <input type="text" class="form-control" id="lastName" required />
                                        </div>
                                        <div class="col-2 p-2">
                                            <span class="btn btn-primary mt-4" onclick="searchAdmin();">Search</span>
                                        </div>
                                    </form>
                                    <!-- form -->

                                    <div id="adminDisplayDiv">

                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Add Admins
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                <div class="accordion-body">

                                    <!-- form -->
                                    <form class="row g-3 needs-validation" novalidate>
                                        <div class="col-md-4">
                                            <label class="form-label">First name</label>
                                            <input type="text" class="form-control" id="first_name" required />
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Last name</label>
                                            <input type="text" class="form-control" id="last_name" required />
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Username</label>
                                            <div class="input-group has-validation">
                                                <span class="input-group-text">@</span>
                                                <input type="text" class="form-control" id="email_address" required />
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Mobile (Don't use '+94' At Front, Use '0')</label>
                                            <input type="tel" class="form-control" id="mobile_no" required />
                                        </div>
                                        <div class="col-12">
                                            <span class="btn btn-primary" onclick="addAdmin();">Add Admin</span>
                                        </div>
                                    </form>
                                    <!-- form -->

                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- user -->

                    <!-- search user -->
                    <div class="accordion mt-5 mb-5" id="accordionExample3">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne1">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne1" aria-expanded="true" aria-controls="collapseOne">
                                    Search Users
                                </button>
                            </h2>
                            <div id="collapseOne1" class="accordion-collapse collapse show" aria-labelledby="headingOne1" data-bs-parent="#accordionExample3">
                                <div class="accordion-body">

                                    <!-- form -->
                                    <form class="row g-3 needs-validation" novalidate>
                                        <div class="col-md-3">
                                            <label for="validationCustom04" class="form-label">By</label>
                                            <select class="form-select" id="searchType2" onchange="search_type2();" required>
                                                <option value="1">Email</option>
                                                <option value="2">Name</option>
                                                <!-- <option value="0">All</option> -->
                                            </select>
                                        </div>
                                        <div class="col-md-4" id="username2">
                                            <label class="form-label">Username</label>
                                            <div class="input-group has-validation">
                                                <span class="input-group-text" id="">@</span>
                                                <input type="text" class="form-control" id="user_email" required />
                                            </div>
                                        </div>
                                        <div class="col-md-3 d-none" id="fname2">
                                            <label class="form-label">First Name</label>
                                            <input type="text" class="form-control" id="user_fname" required />
                                        </div>
                                        <div class="col-md-3 d-none" id="lname2">
                                            <label class="form-label">Last Name</label>
                                            <input type="text" class="form-control" id="user_lname" required />
                                        </div>
                                        <div class="col-2 p-2">
                                            <span class="btn btn-primary mt-4" onclick="searchUsers();">Search</span>
                                        </div>
                                    </form>
                                    <!-- form -->

                                    <div id="userDisplayDiv">

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- search invoice -->
                    <div class="accordion mt-5 mb-5" id="accordionExample4">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne4">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne4" aria-expanded="true" aria-controls="collapseOne4">
                                    Search Invoice
                                </button>
                            </h2>
                            <div id="collapseOne4" class="accordion-collapse collapse show" aria-labelledby="headingOne4" data-bs-parent="#accordionExample4">
                                <div class="accordion-body">

                                    <!-- form -->
                                    <form class="row g-3 needs-validation" novalidate>
                                        <div class="col-md-3">
                                            <label class="form-label">Invoice Id</label>
                                            <input type="text" class="form-control" id="invoice_id" oninput="searchInvoice();" required />
                                        </div>
                                        <div class="col-2 p-2">
                                            <span class="btn btn-primary mt-4" onclick="searchInvoice();">Search</span>
                                        </div>
                                    </form>
                                    <!-- form -->

                                    <div id="invoiceDisplayDiv">

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- notification -->
                <div class="toast-container position-fixed bottom-0 end-0 p-3">
                    <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="toast-header bg-secondary text-white">

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

                <!-- user status change -->
                <div class="modal" tabindex="-1" data-bs-backdrop="static" id="statusChange2">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Reason For Deactivate User</h5>
                            </div>
                            <div class="modal-body">
                                <textarea rows="6" cols="70" style="padding: 15;" placeholder="Enter Your Reason Here ..." id="reason2"></textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" onclick="changeStatus2();">Change Status</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- <script src="../js/bootstrap/bootstrap.bundle.min.js"></script> -->
        <script src="../js/other/home.js"></script>
        <script src="../js/other/users.js"></script>

    </body>

    </html>

<?php
} else {
    header("Location:index.php");
}
?>