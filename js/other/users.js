function search_type2() {
    var searchType = document.getElementById("searchType2").value;

    if (searchType == 1) {
        document.getElementById("username2").classList.remove("d-none");
        document.getElementById("fname2").classList.add("d-none");
        document.getElementById("lname2").classList.add("d-none");
    } else if (searchType == 2) {
        document.getElementById("username2").classList.add("d-none");
        document.getElementById("fname2").classList.remove("d-none");
        document.getElementById("lname2").classList.remove("d-none");
    } else if (searchType == 0) {
        document.getElementById("username2").classList.add("d-none");
        document.getElementById("fname2").classList.add("d-none");
        document.getElementById("lname2").classList.add("d-none");
    }
}

function button() {
    document.getElementById("details").classList.toggle("collapse");
}


function searchUsers() {

    var searchType = document.getElementById("searchType2").value;

    var form = new FormData();
    form.append("searchType", searchType);

    if (searchType == 1) {
        var email = document.getElementById("user_email").value;
        form.append("email", email);

    } else if (searchType == 2) {
        var firstName = document.getElementById("user_fname").value;
        var lastName = document.getElementById("user_lname").value;

        form.append("firstName", firstName);
        form.append("lastName", lastName);
    }

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            // alert(request.responseText);
            document.getElementById("userDisplayDiv").innerHTML = request.responseText;

            if (searchType != 0) {
                document.getElementById("user_email").value = null;
                document.getElementById("user_fname").value = null;
                document.getElementById("user_lname").value = null;
            }
        }
    }

    request.open("Post", "userSearch.php", true);
    request.send(form);

}

function toast2(msg) {

    var toastLiveExample = document.getElementById('liveToast');
    var toast = new bootstrap.Toast(toastLiveExample);

    var now = new Date();
    var time = now.getHours() + " " + now.getMinutes();

    document.getElementById("time").innerHTML = "At " + time;
    document.getElementById("msg").innerHTML = msg;

    toast.show();

}


var user1_id;
var status_id;
var bm2;

function changeUserStatus(user_id, userStatus) {

    status_id = userStatus;
    user1_id = user_id;

    if (status_id == 1) {
        var m = document.getElementById("statusChange2");
        bm2 = new bootstrap.Modal(m);

        bm2.show();
    } else {
        changeStatus2();
    }
}

function changeStatus2() {

    var user_id = user1_id;
    var status2_id = status_id;

    var form = new FormData();
    form.append("user_id", user_id);
    form.append("status_id", status2_id);

    if (status_id == 1) {
        var reason = document.getElementById("reason2").value;

        if (reason.trim() === '') {
            alert("You Must Insert The Reason For The De-activation");
        } else {
            form.append("reason", reason);
            sendUserResquest();
        }

    } else if (status_id == 2) {
        sendUserResquest();
    }

    function sendUserResquest() {

        var request = new XMLHttpRequest();
        request.onreadystatechange = function () {
            if (request.readyState == 4 && request.status == 200) {
                var response = request.responseText;

                if (response == 1) {
                    document.getElementById("reason2").value = null;

                    var msg = "De-Activation Successful";
                    toast2(msg);

                } else if (response == 2) {
                    var msg = "Please Insert The Reason For The De-activation";
                    toast2(msg);

                } else if (response == 3) {

                    var msg = "Re-Activation Successful";
                    toast2(msg);

                } else {
                    alert(response);
                }

                bm2.hide();

            }
        }

        request.open("Post", "changeUserStatus.php", true);
        request.send(form);

    }

}

function searchInvoice() {

    var invoice_id = document.getElementById("invoice_id").value;

    if (invoice_id.trim() == '') {
        document.getElementById("invoice_id").classList.add("border-danger");
        document.getElementById("invoiceDisplayDiv").innerHTML="<p style='color:red; text-align:center; margin-top:10px; margin: bottom 10px; '>Insert The Invoice Id</p>";
    } else {
        document.getElementById("invoice_id").classList.remove("border-danger");
        document.getElementById("invoiceDisplayDiv").innerHTML="";

        var form = new FormData();
        form.append("invoice_id", invoice_id);

        var request = new XMLHttpRequest();
        request.onreadystatechange = function () {
            if (request.readyState == 4 && request.status == 200) {

                document.getElementById("invoice_id").innerHTML = "";
                document.getElementById("invoiceDisplayDiv").innerHTML = request.responseText;

            }
        }

        request.open("Post", "searchInvoice.php", true);
        request.send(form);

    }

}
