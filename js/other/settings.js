

function toast(msg, color) {

    var toastLiveExample = document.getElementById('liveToast');
    var toast = new bootstrap.Toast(toastLiveExample);

    var now = new Date();
    var time = now.getHours() + " " + now.getMinutes();

    document.getElementById("time").innerHTML = "At " + time;
    document.getElementById("msg").innerHTML = msg;
    document.getElementById("headerColor").classList.add(color);

    toast.show();

}

function updateStoreDetails() {

    var name = document.getElementById("s_name").value;
    var email = document.getElementById("s_email").value;
    var mobile = document.getElementById("s_mobile").value;
    var line_1 = document.getElementById("s_line_1").value;
    var line_2 = document.getElementById("s_line_2").value;
    var logo = document.getElementById("logonew");

    if (name.trim() == "" && email.trim() == "" && line_1.trim() == "" && line_2.trim() == "" && mobile.trim() == "") {
        var msg = "Fill THe Details";
        var color = "bg-warning";

        toast(msg, color);
    } else {

        var form = new FormData();
        form.append("name", name);
        form.append("email", email);
        form.append("mobile", mobile);
        form.append("line_1", line_1);
        form.append("line_2", line_2);

        if (logo.files[0] == null) {
            form.append("img", '1');
        } else {

            form.append("img", '2');
            form.append("logo", logo.files[0]);
        }

        var request = new XMLHttpRequest();
        request.onreadystatechange = function () {
            if (request.readyState == 4 && request.status == 200) {
                var response = request.responseText;

                if (response == 1) {
                    var msg = "Update Process Success";
                    var color = "bg-success";

                    toast(msg, color);
                } else if (response == 2) {

                    var msg = "Logo Uploading Faild";
                    var color = "bg-danger";

                    toast(msg, color);

                } else if (response == 3) {
                    var msg = "Invalid Logo File Format";
                    var color = "bg-warning";

                    toast(msg, color);
                } else if (response == 4) {
                    var msg = "In-valid Mobile Number";
                    var color = "bg-warning";

                    toast(msg, color);
                } else if (response == 5) {
                    var msg = "Mobile Number Limit is 10";
                    var color = "bg-warning";

                    toast(msg, color);
                } else if (response == 6) {
                    var msg = "In-valid Email Address";
                    var color = "bg-warning";

                    toast(msg, color);
                } else if (response == 7) {
                    var msg = "Fill The Details";
                    var color = "bg-dark";
                    toast(msg, color);
                } else {
                    alert(response);
                }

            }
        }
        request.open("POST", "updateStore.php", true);
        request.send(form);
    }
}

document.getElementById("re").addEventListener("click", () => {
    document.getElementById("logonew").click();
});

function loadLogo() {
    var file = document.getElementById("logonew").files[0];
    var url = URL.createObjectURL(file);

    document.getElementById("nowlogo").src = url;
}


function loadprofileimg() {
    var file = document.getElementById("pimg").files[0];
    var url = URL.createObjectURL(file);

    document.getElementById("pnewimg").style.backgroundImage = "url('" + url + "')";
}


function updateProfile() {

    var f_name = document.getElementById("fproname").value;
    var l_name = document.getElementById("lproname").value;
    var email = document.getElementById("prneemail").value;
    var mobile = document.getElementById("pronemo").value;
    var line_1 = document.getElementById("proli1").value;
    var line_2 = document.getElementById("proli2").value;
    var city = document.getElementById("city").value;
    var profile = document.getElementById("pimg");

    if (f_name.trim() == "" && l_name.trim() == "" && email.trim() == "" && line_1.trim() == "" && line_2.trim() == "" && mobile.trim() == "") {
        var msg = "Fill THe Details";
        var color = "bg-warning";

        toast(msg, color);
    } else {

        var form = new FormData();
        form.append("f_name", f_name);
        form.append("l_name", l_name);
        form.append("email", email);
        form.append("mobile", mobile);
        form.append("line_1", line_1);
        form.append("line_2", line_2);
        form.append("city", city);

        if (profile.files[0] == null) {
            form.append("img", '1');
        } else {

            form.append("img", '2');
            form.append("profile", profile.files[0]);
        }

        var request = new XMLHttpRequest();
        request.onreadystatechange = function () {
            if (request.readyState == 4 && request.status == 200) {
                var response = request.responseText;

                if (response == 1) {
                    var msg = "Update Process Success";
                    var color = "bg-success";

                    toast(msg, color);
                } else if (response == 2) {

                    var msg = "Logo Uploading Faild";
                    var color = "bg-danger";

                    toast(msg, color);

                } else if (response == 3) {
                    var msg = "Invalid Image File Format";
                    var color = "bg-warning";

                    toast(msg, color);
                } else if (response == 4) {
                    var msg = "In-valid Mobile Number";
                    var color = "bg-warning";

                    toast(msg, color);
                } else if (response == 5) {
                    var msg = "Mobile Number Limit is 10";
                    var color = "bg-warning";

                    toast(msg, color);
                } else if (response == 6) {
                    var msg = "In-valid Email Address";
                    var color = "bg-warning";

                    toast(msg, color);
                } else if (response == 7) {
                    var msg = "Fill The Details";
                    var color = "bg-dark";
                    toast(msg, color);
                } else {
                    alert(response);
                }

            }
        }
        request.open("POST", "updateProfile.php", true);
        request.send(form);
    }

}

function updatePassword() {
    var oldP = document.getElementById("oldPassword").value;
    var newP = document.getElementById("newPassword").value;
    var reNewP = document.getElementById("reNewPassword").value;

    if (oldP.trim() == '' || newP.trim() == '' || reNewP.trim() == '') {
        var msg = "Fill The Neccesary Fields";
        var color = "bg-danger";

        toast(msg, color);
    } else {
        if (newP === reNewP) {

            var form = new FormData();
            form.append("oldP", oldP);
            form.append("newP", newP);
            form.append("reNewP", reNewP);

            var request = new XMLHttpRequest();
            request.onreadystatechange = function () {
                if (request.readyState == 4 && request.status == 200) {
                    var response = request.responseText;

                    if (response == 1) {
                        var msg = "Password Succesfuly Updated";
                        var color = "bg-success";

                        toast(msg, color);
                    } else if (response == 2) {

                        var msg = "In-correct Old Password";
                        var color = "bg-danger";

                        toast(msg, color);

                    } else if (response == 3) {
                        var msg = "Couldn't Find The Admin";
                        var color = "bg-danger";

                        toast(msg, color);
                    } else if (response == 4) {
                        var msg = "New Passwords Don't Match";
                        var color = "bg-danger";

                        toast(msg, color);
                    } else if (response == 5) {
                        var msg = "Fill The Details";
                        var color = "bg-warning";

                        toast(msg, color);
                    } else if (response == 6) {
                        var msg = "Password Size Must Be Less Than 45";
                        var color = "bg-warning";

                        toast(msg, color);
                    } else {
                        alert(response);
                    }

                }
            }
            request.open("POST", "updatePassword.php", true);
            request.send(form);

        } else {
            var msg = "New Password Values Don't Match";
            var color = "bg-danger";

            toast(msg, color);
        }
    }
}


function verifyMe() {
    var msg = "Verfication Code Sending Start ...";
    var color = "bg-success";

    toast(msg, color);

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            var response = request.responseText;

            if (response == 1) {
                var msg = "Verfication Code Sending Success";
                var color = "bg-success";

                toast(msg, color);

                setTimeout(() => {
                    alert("We Have Send A Tempary Password To Your Email Address. Please Use It For Update Your Password");
                }, 150);

            } else if (response == 2) {
                var msg = "Verfication Code Sending Faild";
                var color = "bg-danger";

                toast(msg, color);
            } else if (response == 3) {
                var msg = "Couldn't Find The Email Address";
                var color = "bg-warning";

                toast(msg, color);
            } else {
                alert(response);
            }
        }
    }
    request.open("POST", "adminVerify.php", true);
    request.send();
}

var clicked_type;
var clicked_id;
// var clicked_name;
var change_modal;

function edit(type, id, name) {

    change_modal = new bootstrap.Modal(document.getElementById("changeModal"));
    change_modal.show();

    var type_name;
    if (type == 'c') {
        type_name = "Categories";
    } else if (type == 'g') {
        type_name = "Genre";
    } else if (type == 'q') {
        type_name = "Quality";
    } else if (type == 'y') {
        type_name = "Years";
    } else if (type == 'l') {
        type_name = "Language";
    } else if (type == 'con') {
        type_name = "Countries";
    }
    document.getElementById("modalTitle").innerHTML = "Change " + type_name;


    document.getElementById("fromName").value = name;

    clicked_type = type;
    clicked_id = id;
    // clicked_name = name;

}

function saveChanges() {
    var to = document.getElementById("toName").value;
    if (to.trim() == "") {
        var msg = "Insert 'To' Value For Continue";
        var color = "bg-warning";

        toast(msg, color);
    } else {
        var msg = "Updating Process Started ...";
        var color = "bg-success";

        toast(msg, color);

        var form = new FormData();
        form.append("to", to);
        form.append("clicked_type", clicked_type);
        form.append("clicked_id", clicked_id);

        var request = new XMLHttpRequest();
        request.onreadystatechange = function () {
            if (request.readyState == 4 && request.status == 200) {
                var response = request.responseText;

                change_modal.hide();

                if (response == 1) {
                    var msg = "Update Success";
                    var color = "bg-success";

                    toast(msg, color);
                } else if (response == 2) {
                    var msg = "Insert 'To' Value";
                    var color = "bg-warning";

                    toast(msg, color);
                } else if (response == 3) {
                    var msg = "Something Went Wrong";
                    var color = "bg-danger";

                    toast(msg, color);
                } else {
                    alert(response);
                }

            }
        }
        request.open("POST", "updateDatabase.php", true);
        request.send(form);
    }
}


var new_clicked_type;
var addmin_modal;

function addNew(type) {
    addmin_modal =new bootstrap.Modal(document.getElementById("addModal"));
    addmin_modal.show();

    var type_name;
    if (type == 'c') {
        type_name = "Category";
    } else if (type == 'g') {
        type_name = "Genre";
    } else if (type == 'q') {
        type_name = "Quality";
    } else if (type == 'y') {
        type_name = "Year";
    } else if (type == 'l') {
        type_name = "Language";
    } else if (type == 'con') {
        type_name = "Country";
    }

    document.getElementById("addModalTitle").innerHTML = "Add New " + type_name;
    document.getElementById("newNameP").innerHTML = "New " + type_name;

    new_clicked_type = type;

}

function add() {
    var new_name = document.getElementById("newNameInput").value;

    if (new_name.trim() == "") {
        var msg = "Insert New Value For Continue";
        var color = "bg-warning";

        toast(msg, color);
    } else {
        var msg = "Adding Process Started ...";
        var color = "bg-success";

        toast(msg, color);

        var form = new FormData();
        form.append("new_clicked_type", new_clicked_type);
        form.append("new_name", new_name);

        var request = new XMLHttpRequest();
        request.onreadystatechange = function () {
            if (request.readyState == 4 && request.status == 200) {
                var response = request.responseText;

                addmin_modal.hide();

                if (response == 1) {
                    var msg = "Adding Success";
                    var color = "bg-success";

                    toast(msg, color);
                } else if (response == 2) {
                    var msg = "Insert New Value";
                    var color = "bg-warning";

                    toast(msg, color);
                } else if (response == 3) {
                    var msg = "Something Went Wrong";
                    var color = "bg-danger";

                    toast(msg, color);
                } else {
                    alert(response);
                }

            }
        }
        request.open("POST", "addToDatabase.php", true);
        request.send(form);
    }
}

