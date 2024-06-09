
var msg_Type = 1;//new

var msg;
    var color;

function newOld(type) {
    msg_Type = type;

    if (msg_Type == 1) {//new
        document.getElementById("newMsgBtn").classList.remove("btn-primary");
        document.getElementById("newMsgBtn").classList.add("btn-outline-primary");

        document.getElementById("allMsgBth").classList.remove("btn-outline-dark");
        document.getElementById("allMsgBth").classList.add("btn-dark");
    } else if (msg_Type == 2) {//all
        document.getElementById("newMsgBtn").classList.remove("btn-outline-primary");
        document.getElementById("newMsgBtn").classList.add("btn-primary");

        document.getElementById("allMsgBth").classList.remove("btn-dark");
        document.getElementById("allMsgBth").classList.add("btn-outline-dark");
    }

    msgRequest();
}

window.addEventListener("load", () => {

    msgRequest();

});

function msgRequest() {

    var form = new FormData();
    form.append("msg_Type", msg_Type);

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            var response = request.responseText;

            if (response == 1) {
                msg = "No New Messages";
                color = "bg-dark";

                toast(msg, color);
            } else if (response == 2) {
                msg = "something went wrong";
                color = "bg-danger";

                toast(msg, color);
            } else {
                document.getElementById("msgList").innerHTML = response;
            }
        }
    }
    request.open("POST", "loadMessages.php", true);
    request.send(form);
}

function readMsg(msg_id, msg_status_id) {

    var form = new FormData();
    form.append("msg_id", msg_id);
    form.append("msg_status_id", msg_status_id);

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            var response = request.responseText;

            if (response == 1) {
                msg = "Something Went Wrong";
                color = "bg-danger";

                toast(msg, color);
            } else if (response == 2) {
                msg = "Couldn't Find The Message";
                color = "bg-danger";

                toast(msg, color);
            } else if (response == 3) {
                msg = "Something Went Wrong";
                color = "bg-danger";

                toast(msg, color);
            } else {
                document.getElementById("msgDisplay").innerHTML = response;
            }
        }
    }
    request.open("POST", "readMessages.php", true);
    request.send(form);

}

function sendEmail(email) {
    var replyMsg = document.getElementById("replyText").value;

    if (replyMsg.trim() == "") {
        document.getElementById("darkbg" + email).classList.add("bg-danger");

        msg = "Please Insert Reply Message";
        color = "bg-warning";

        toast(msg, color);
    } else {
        document.getElementById("darkbg"+email).classList.add("bg-dark");

        msg = "Reply Sending Start ..";
        color = "bg-success";

        toast(msg, color);

        var form = new FormData();
        form.append("email", email);
        form.append("replyMsg", replyMsg);

        var request = new XMLHttpRequest();
        request.onreadystatechange = function () {
            if (request.readyState == 4 && request.status == 200) {
                var response = request.responseText;

                if (response == 1) {
                    msg = "Reply Email Sending Success";
                    color = "bg-success";

                    toast(msg, color);
                } else if (response == 2) {
                    msg = "Reply Email Sending Faild";
                    color = "bg-danger";

                    toast(msg, color);
                } else if (response == 3) {
                    msg = "Please Insert Reply Msg";
                    color = "bg-warning";

                    toast(msg, color);
                } else if (response == 4) {
                    msg = "Something Went Wrong";
                    color = "bg-warning";

                    toast(msg, color);
                } else {
                    alert(response);
                }
            }
        }
        request.open("POST", "replyAdminEmail.php", true);
        request.send(form);

    }

}

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