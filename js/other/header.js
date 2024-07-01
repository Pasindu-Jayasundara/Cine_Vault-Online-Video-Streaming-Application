

function loginModel() {
    var model = document.getElementById("staticBackdrop");
    var bModel = new bootstrap.Modal(model);
    bModel.show();
}

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

                window.location.reload();

            } else {
                alert(response);
            }
        }
    };

    request.open("POST", "loginProcess.php", true);
    request.send(form);
}

function logout() {
    var request = new XMLHttpRequest();
    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            window.location.reload();
        }
    };

    request.open("POST", "logout.php", true);
    request.send();
}

// email

var bModel;

function updateEmailModel() {
    var model = document.getElementById("verifyEmailModel");
    bModel = new bootstrap.Modal(model);
    bModel.show();
}

var bm2;

function verifyEmail() {
    var old_email = document.getElementById("old_email").value;
    var new_email = document.getElementById("new_email").value;

    bModel.hide();

    var m2 = document.getElementById("updateEmailModel2");
    bm2 = new bootstrap.Modal(m2);
    bm2.show();


    var form = new FormData();
    form.append("old_email", old_email);
    form.append("new_email", new_email);

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
            }

        }
    };

    request.open("POST", "verifyEmail.php", true);
    request.send(form);

}

function updateEmail() {

    var v_code = document.getElementById("v_code").value;

    bm2.hide();

    var form = new FormData();
    form.append("v_code", v_code);

    var request = new XMLHttpRequest();
    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {

            if (request.responseText == "1") {
                alert("Email Update Success");
                window.location.reload();
            } else {
                alert(request.responseText);
            }
        }
    };

    request.open("POST", "updateEmail.php", true);
    request.send(form);
}

// password

var p_bModel;

function updatePasswordModel() {
    var p_model = document.getElementById("verifyPasswordModel");
    p_bModel = new bootstrap.Modal(p_model);
    p_bModel.show();
}

var p_bm;

function verifyPassword() {
    var old_password = document.getElementById("old_password").value;
    var new_password = document.getElementById("new_password").value;

    p_bModel.hide();

    var p_m = document.getElementById("verifyPasswordModel2");
    p_bm = new bootstrap.Modal(p_m);
    p_bm.show();

    var form = new FormData();
    form.append("old_password", old_password);
    form.append("new_password", new_password);

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

    request.open("POST", "verifyPassword.php", true);
    request.send(form);

}

function updatePassword() {

    var v_code = document.getElementById("pv_code").value;

    p_bm.hide();

    var form = new FormData();
    form.append("v_code", v_code);

    var request = new XMLHttpRequest();
    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {

            if (request.responseText == "1") {
                alert("Password Update Success");
                window.location.reload();
            } else {
                alert(request.responseText);
            }
        }
    };

    request.open("POST", "updatePassword.php", true);
    request.send(form);
}

// // forgot password

var fp_bModel;

function forgotPasswordEmailModel() {
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



// search

function searchContent() {

    var searchText = document.getElementById("searchText").value;

    var request = new XMLHttpRequest();
    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {

            if (request.responseText == "1") {
                window.location.reload();
            } else {
                document.getElementById("body").innerHTML = request.responseText;
            }
        }
    };

    request.open("POST", "searchContent.php?txt=" + searchText, true);
    request.send();

}

// nav bar

window.addEventListener("load", navBar);

function navBar() {
    var path = window.location.pathname;
    var page = path.split("/").pop();

    if (page == "movie.php") {
        document.getElementById("moviePage").style.textDecoration = "underline";
        document.getElementById("moviePage").style.textDecorationColor = "red";
    } else if (page == "tv.php") {
        document.getElementById("tvPage").style.textDecoration = "underline";
        document.getElementById("tvPage").style.textDecorationColor = "red";
    } else if (page == "favourite.php") {
        document.getElementById("favouritePage").style.textDecoration = "underline";
        document.getElementById("favouritePage").style.textDecorationColor = "red";
    } else if (page == "price.php") {
        document.getElementById("subPage").style.textDecoration = "underline";
        document.getElementById("subPage").style.textDecorationColor = "red";
    } else if (page == "cart.php") {
        document.getElementById("cartPage").style.textDecoration = "underline";
        document.getElementById("cartPage").style.textDecorationColor = "red";
    }
}

// sign up
var bModel;

function signUpModel() {
    var model = document.getElementById("signupModel");
    bModel = new bootstrap.Modal(model);
    bModel.show();
}

function signUp() {
    var email = document.getElementById("Semail").value;
    var password = document.getElementById("Spassword").value;
    var fname = document.getElementById("Sfname").value;
    var lname = document.getElementById("Slname").value;

    var form = new FormData();
    form.append("email", email);
    form.append("password", password);
    form.append("fname", fname);
    form.append("lname", lname);

    var request = new XMLHttpRequest();
    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            var response = request.responseText;

            if (response == "1") {
                alert("Email Already Exist..");
            } else if (response == "2") {
                alert("Please Fill Your Details");
            } else if (response == "3") {
                alert("Account Create Successful. Verify Your Email..!");
                signUpEmailVerifyModel();
            } else {
                alert(response);
            }
        }
    };

    request.open("POST", "signUpProcess.php", true);
    request.send(form);
}

function signUpEmailVerifyModel() {
    bModel.hide();

    var SMEV = document.getElementById("signupModelEMailVerify");
    var BSMEV = new bootstrap.Modal(SMEV);
    BSMEV.show();

}

function verify() {
    var newUserVCode = document.getElementById("newUserVCode").value;

    var form = new FormData();
    form.append("newUserVCode", newUserVCode);

    var request = new XMLHttpRequest();
    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            var response = request.responseText;
            alert(response);
            window.location.reload();
        }
    };

    request.open("POST", "verifyNewUserEmail.php", true);
    request.send(form);

}

function sort(value, id) {

    var pageLink = window.location.href;
    var page = pageLink.split("/").pop();
    var type;

    if (page == "tv.php") {
        type = "tv";
    } else if (page == "index.php") {
        type = "both";
    } else if (page == "movie.php") {
        type = 'movie';
    } else if (page == "") {
        type = "both";
    }

    var quality = document.getElementById("quality").value;
    var genre = document.getElementById("genre").value;
    var year = document.getElementById("year").value;
    var language = document.getElementById("language").value;
    var country = document.getElementById("country").value;

    var request = new XMLHttpRequest();
    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {

            if (request.responseText == "1") {
                window.location.reload();
            } else {
                document.getElementById("body").innerHTML = request.responseText;
            }
        }
    };

    request.open("GET", "sortContent.php?value=" + value + "&by=" + id + "&type=" + type + "&quality=" + quality + "&genre=" + genre + "&year=" + year + "&language=" + language + "&country=" + country, true);
    request.send();
}


window.addEventListener("load", () => {
    var pageLink = window.location.href;
    var page = pageLink.split("/").pop();
    var page2 = page.split("?");

    if (page2[0] == "singleContentData.php") {
        document.getElementById("sortingDiv").classList.add("d-none");
    } else if (page == "price.php") {
        document.getElementById("sortingDiv").classList.add("d-none");
    } else if (page == "favourite.php") {
        document.getElementById("sortingDiv").classList.add("d-none");
    } else if (page == "cart.php") {
        document.getElementById("sortingDiv").classList.add("d-none");
    }else if (page == "purchasedHistory.php") {
        document.getElementById("sortingDiv").classList.add("d-none");
    }else if (page2[0] == "receipt.php") {
        document.getElementById("sortingDiv").classList.add("d-none");
    } else {
        document.getElementById("sortingDiv").classList.remove("d-none");
    }
});

function contact() {
    var m = document.getElementById("contactModel");
    var mb = new bootstrap.Modal(m);

    mb.show();
}

function msgToAdmin() {

    var textToAdmin = document.getElementById("textToAdmin").value;

    var form = new FormData();
    form.append("textToAdmin", textToAdmin);

    var request = new XMLHttpRequest();
    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            var response = request.responseText;

            if (response == "1") {
                window.location.href = "price.php";
            } else {
                alert(response);
                window.location.reload();
            }
        }
    };

    request.open("POST", "messageToAdmin.php", true);
    request.send(form);

}

function bookmarkAddToFavourite(code, type) {

    var form = new FormData();
    form.append("code", code);
    form.append("type", type);

    var request = new XMLHttpRequest();
    request.onreadystatechange = function() {
        if (request.readyState == 4 & request.status == 200) {

            var jsonResponseText = request.responseText;
            var response = JSON.parse(jsonResponseText);

            var rstatus = response.status;
            if (rstatus == "1") { // remove

                document.getElementById("favouriteplusicon" + code).classList.replace("bi-bookmark-heart", "bi-bookmark-heart-fill");
                document.getElementById("favouriteplusicon" + code).classList.replace("text-danger", "text-warning");

            } else if (rstatus == "2") { //added

                document.getElementById("favouriteplusicon" + code).classList.replace("bi-bookmark-heart-fill", "bi-bookmark-heart");
                document.getElementById("favouriteplusicon" + code).classList.replace("text-warning", "text-danger");

            }

            toast(response);

        }
    };

    request.open("POST", "bookmarkAddToFavourite.php", true);
    request.send(form);

}

function toast(response) {

    var toastLiveExample = document.getElementById('liveToast');
    var toast = new bootstrap.Toast(toastLiveExample);

    document.getElementById("time").innerHTML = "At " + response.time;
    document.getElementById("msg").innerHTML = response.message;

    toast.show();

}

function settings() {
    var setting = document.getElementById("setting");
    var bsetting = new bootstrap.Modal(setting);
    bsetting.show();
}


var file;

function check() {
    document.getElementById("img2").classList.remove("d-none");
    document.getElementById("img").classList.add("d-none");

    file = document.getElementById("file").files[0];
    var fileUrl = URL.createObjectURL(file);

    document.getElementById("img2").innerHTML = "<img src='" + fileUrl + "' class='rounded-circle' style='width: 200px; height: 200px; background-size: cover; background-position: center; background-repeat: no-repeat;'/>";
}

function saveProfile() {

    var form = new FormData();
    form.append("file", file);

    var request = new XMLHttpRequest();
    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            var response = request.responseText;

            alert(response);
            window.location.reload();

        }
    };

    request.open("POST", "profileImage.php", true);
    request.send(form);

}
