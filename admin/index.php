<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin LogIn</title>

    <link rel="stylesheet" href="../css/bootstrap/bootstrap.css">
    <link rel="stylesheet" href="../css/other/adminLogin.css" />

    <link rel="icon" href="../logo/logo.png" />
</head>

<body>

    <div class="container-fluid bgImage min-vh-100">

        <div class="row d-flex justify-content-center align-items-center">
            <div class="col-6">
                <div class="row formDiv p-5" style="margin-top: 15%;">
                    <div class="d-flex offset-3">
                        <img src="../logo/logo.png" style="width: 15%;" />
                        <h3 class="text-white pt-4">CineVault</h3>
                    </div>

                    <form class="row g-3 needs-validation col-8 offset-2" novalidate>

                        <div class="col-md-12">
                            <label class="form-label">Username</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text">@</span>
                                <input type="text" class="form-control" id="email" required />
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Password</label>
                            <div class="input-group has-validation">
                                <input type="password" class="form-control" id="password" required />
                            </div>
                        </div>
                        <div class="col-12 d-flex justify-content-center my-3">
                            <span class="btn btn-primary col-4 d-block" onclick="login();">Log In</button>
                        </div>

                        <hr />
                        <label class="form-label text-white-50 text-center fp" onclick="forgotPasswordModel();">Forgot Password</label>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <!-- forgot passsword email Modal -->
    <div class="modal fade" id="forgotPasswordEmailModel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content rounded-4 shadow">
                <div class="modal-header p-5 pb-4 border-bottom-0">
                    <h1 class="fw-bold mb-0 fs-3 text-black">Verify Email Address</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-5 pt-0">
                    <form class="">
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control rounded-3" id="forgot_password_email" />
                            <label class="text-black">Your Email Address</label>
                        </div>
                        <span class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" onclick="verifyForgotPasswordEmail();">Verify</span>
                        <hr class="my-4">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- forgot passsword email verification Modal -->
    <div class="modal fade" id="forgotPasswordEmailVerificationModel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content rounded-4 shadow">
                <div class="modal-header p-5 pb-4 border-bottom-0">
                    <h1 class="fw-bold mb-0 fs-2 text-black">Verify Email Address</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-5 pt-0">
                    <form class="">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control rounded-3" id="forgotPasswordEmailVerificationCode" />
                            <label class="text-dark">Email Verification Code</label>
                        </div>
                        <span class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" onclick="forgotPasswordEmailVerfication();">Verify</span>
                        <hr class="my-4">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- new password Modal -->
    <div class="modal fade" id="newPasswordModel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content rounded-4 shadow">
                <div class="modal-header p-5 pb-4 border-bottom-0">
                    <h1 class="fw-bold mb-0 fs-2 text-black">Reset Password</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-5 pt-0">
                    <form class="">
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control rounded-3" id="forgotPasswordNewPassword" />
                            <label class="text-dark">Enter Your New Password</label>
                        </div>
                        <span class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" onclick="updateForgotPassword();">Update Password</span>
                        <hr class="my-4">
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script src="../js/bootstrap/bootstrap.bundle.min.js"></script>
    <script src="../js/other/adminLogin.js"></script>
</body>

</html>