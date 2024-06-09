function login() {
    var email = document.getElementById("email").value;
    var password = document.getElementById("password").value;

    var form = new FormData();
    form.append("email", email);
    form.append("password", password);

    var request = new XMLHttpRequest();
    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            var response = request.responseText;

            if (response == "1") {
                window.location.href = "dashboard.php";
            } else {
                alert(response);
            }
        }
    };

    request.open("POST", "login.php", true);
    request.send(form);
}

// // forgot password

var fp_bModel;

function forgotPasswordModel() {
    var fp_model = document.getElementById("forgotPasswordEmailModel");
    fp_bModel = new bootstrap.Modal(fp_model);
    fp_bModel.show();
}

var b_f_p_e_v_model;

function verifyForgotPasswordEmail() {
    var forgot_password_email = document.getElementById("forgot_password_email").value;

    fp_bModel.hide();

    var f_p_e_v_model = document.getElementById("forgotPasswordEmailVerificationModel");
    b_f_p_e_v_model = new bootstrap.Modal(f_p_e_v_model);
    b_f_p_e_v_model.show();


    var form = new FormData();
    form.append("forgot_password_email", forgot_password_email);

    var request = new XMLHttpRequest();
    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {

            var response = request.responseText;

            if (response == "1") {
                alert("Invalid Details");
            } else if (response == "2") {
                alert("Something Went Wrong");
                window.location.reload();
            } else if (response == "3") {
                alert("Please Fill The Details");
            } else if (response == "5") {
                alert("Check your Email for Verification Code");
            }

        }
    };

    request.open("POST", "verifyForgotPasswordEmail.php", true);
    request.send(form);

}

var b_newPasswordModel;

function forgotPasswordEmailVerfication() {
    var forgotPasswordEmailVerificationCode = document.getElementById("forgotPasswordEmailVerificationCode").value;

    b_f_p_e_v_model.hide();

    var newPasswordModel = document.getElementById("newPasswordModel");
    b_newPasswordModel = new bootstrap.Modal(newPasswordModel);


    var form = new FormData();
    form.append("forgotPasswordEmailVerificationCode", forgotPasswordEmailVerificationCode);

    var request = new XMLHttpRequest();
    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {

            var response = request.responseText;

            if (response == "3") {
                alert("Please Fill The Details");
            } else if (response == "success") {
                b_newPasswordModel.show();
            } else {
                alert(response);
            }

        }
    };

    request.open("POST", "verifyForgotPasswordEmailCode.php", true);
    request.send(form);

}

function updateForgotPassword() {

    var forgotPasswordNewPassword = document.getElementById("forgotPasswordNewPassword").value;

    b_newPasswordModel.hide();

    var form = new FormData();
    form.append("forgotPasswordNewPassword", forgotPasswordNewPassword);

    var request = new XMLHttpRequest();
    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {

            if (request.responseText == "1") {
                alert("Password Reset Success");
                window.location.reload();
            } else {
                alert(request.responseText);
            }
        }
    };

    request.open("POST", "updateForgotPassword.php", true);
    request.send(form);
}