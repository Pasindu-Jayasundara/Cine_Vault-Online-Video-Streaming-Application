function search_type() {
    var searchType = document.getElementById("searchType").value;

    if (searchType == 1) {
        document.getElementById("username").classList.remove("d-none");
        document.getElementById("fname").classList.add("d-none");
        document.getElementById("lname").classList.add("d-none");
    } else if (searchType == 2) {
        document.getElementById("username").classList.add("d-none");
        document.getElementById("fname").classList.remove("d-none");
        document.getElementById("lname").classList.remove("d-none");
    }
}

function button() {
    document.getElementById("details").classList.toggle("collapse");
}

function searchAdmin() {

    var searchType = document.getElementById("searchType").value;

    var form = new FormData();
    form.append("searchType", searchType);

    if (searchType == 1) {
        var email = document.getElementById("email").value;
        form.append("email", email);

    } else if (searchType == 2) {
        var firstName = document.getElementById("firstName").value;
        var lastName = document.getElementById("lastName").value;

        form.append("firstName", firstName);
        form.append("lastName", lastName);
    }

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            document.getElementById("adminDisplayDiv").innerHTML = request.responseText;

            document.getElementById("email").value = null;
            document.getElementById("firstName").value = null;
            document.getElementById("lastName").value = null;
        }
    }

    request.open("Post", "adminSearch.php", true);
    request.send(form);

}


function toast(msg) {

    var toastLiveExample = document.getElementById('liveToast');
    var toast = new bootstrap.Toast(toastLiveExample);

    var now = new Date();
    var time = now.getHours() + " " + now.getMinutes();

    document.getElementById("time").innerHTML = "At " + time;
    document.getElementById("msg").innerHTML = msg;

    toast.show();

}


function addAdmin() {

    var first_name = document.getElementById("first_name").value;
    var last_name = document.getElementById("last_name").value;
    var email_address = document.getElementById("email_address").value;
    var mobile_no = document.getElementById("mobile_no").value;

    if (first_name.trim() === "") {
        document.getElementById("first_name").classList.add("border-danger");
    } else {
        document.getElementById("first_name").classList.remove("border-danger");
    }

    if (last_name.trim() === '') {
        document.getElementById("last_name").classList.add("border-danger");
    } else {
        document.getElementById("last_name").classList.remove("border-danger");
    }

    if (email_address.trim() === '') {
        document.getElementById("email_address").classList.add("border-danger");
    } else {
        document.getElementById("email_address").classList.remove("border-danger");
    }

    if (mobile_no.trim() === '') {
        document.getElementById("mobile_no").classList.add("border-danger");
    } else {
        document.getElementById("mobile_no").classList.remove("border-danger");
    }

    if (first_name.trim() != '' && last_name.trim() != '' && email_address.trim() != '' && mobile_no.trim() != '') {

        var form = new FormData();
        form.append("first_name", first_name);
        form.append("last_name", last_name);
        form.append("email_address", email_address);
        form.append("mobile_no", mobile_no);

        var request = new XMLHttpRequest();
        request.onreadystatechange = function () {
            if (request.readyState == 4 && request.status == 200) {

                var response = request.responseText;
                var msg;
                if (response == 1) {//add success call email
                    msg = "Admin Added Successfuly.";
                    toast(msg);
                    clear();

                    msg = "Emailing Credentials ...";
                    toast(msg);

                    sendEmail();

                } else if (response == 2) {// admin already eists
                    msg = "Admin Already Exists !";
                    toast(msg);
                    clear();

                } else if (response == 3) {//invalid email address
                    msg = "Invalid Email Address !";
                    toast(msg);
                    document.getElementById("email_address").classList.add("border-danger");

                } else if (response == 4) {//fill the details
                    msg = "Fill The Details First !";
                    toast(msg);

                    document.getElementById("first_name").classList.add("border-danger");
                    document.getElementById("last_name").classList.add("border-danger");
                    document.getElementById("email_address").classList.add("border-danger");
                    document.getElementById("mobile_no").classList.add("border-danger");

                } else {
                    alert(response);
                }

                function clear() {
                    document.getElementById("first_name").value = null;
                    document.getElementById("last_name").value = null;
                    document.getElementById("email_address").value = null;
                    document.getElementById("mobile_no").value = null;
                }

            }
        }

        request.open("Post", "addAdmin.php", true);
        request.send(form);

    }

}

function sendEmail() {

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            var response = request.responseText;
            if (response == 1) {
                msg = "Credentials Emailed Successfully";
                toast(msg);
            } else if (response == 2) {
                msg = "Credentials Email Process Faild";
                toast(msg);
            } else {
                alert(response);
            }

        }
    }

    request.open("Post", "sendEmail.php", true);
    request.send();

}


var admin1_id;
var status_id;
var bm ;

function changeAdminStatus(admin_id, adminStatus) {

    status_id = adminStatus;
    admin1_id = admin_id;

    if (status_id == 1) {
        var m = document.getElementById("statusChange");
        bm = new bootstrap.Modal(m);

        bm.show();
    } else {
        changeStatus();
    }
}

function changeStatus() {

    var admin_id = admin1_id;
    var status2_id = status_id;

    var form = new FormData();
    form.append("admin_id", admin_id);
    form.append("status_id", status2_id);

    if (status_id == 1) {
        var reason = document.getElementById("reason").value;

        if (reason.trim() === '') {
            alert("You Must Insert The Reason For The De-activation");
        } else {
            form.append("reason", reason);
            sendResquest();
        }

    } else if (status_id == 2) {
        sendResquest();
    }

    function sendResquest() {

        var request = new XMLHttpRequest();
        request.onreadystatechange = function () {
            if (request.readyState == 4 && request.status == 200) {
                var response = request.responseText;

                if (response == 1) {
                    document.getElementById("reason").value = null;
                    
                    var msg = "De-Activation Successful";
                    toast(msg);

                } else if (response == 2) {
                    var msg = "Please Insert The Reason For The De-activation";
                    toast(msg);

                } else if (response == 3) {
                    
                    var msg = "Re-Activation Successful";
                    toast(msg);

                } else {
                    alert(response);
                }

                bm.hide(); 

            }
        }

        request.open("Post", "changeStatus.php", true);
        request.send(form);

    }

}