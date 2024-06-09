function tv_episode(epi_id, type, code,b) {

    var form = new FormData();
    form.append("type", type);
    form.append("code", code);
    form.append("epi_id", epi_id);

    if(b != "" || b != null){
        form.append("b", b);
    }

    var request = new XMLHttpRequest();
    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            var response = request.responseText;
            if (response == "1") {

                alert("File is not readable.");
                window.location.reload();

            } else if (response == "2") {
                alert("Something Went Wrong");
            } else if (response == "3") {
                alert("Please LogIn First");
            } else if (response == "4") {
                alert("Your Watch Limit For This Month Has Been Reached");
            } else {

                document.getElementById("epiDiv").classList.remove("d-none");
                document.getElementById("epi").src = response;

                var sp = response.split(".");
                var filetype = sp.pop();

                document.getElementById("epi").type = filetype;

                // alert(response);
                // alert(filetype);
            }
        }
    };

    request.open("POST", "loadContentEpisode.php", true);
    request.send(form);

}

function selectEpi() {
    document.getElementById("epiSelect").classList.remove("d-none");
    document.getElementById("epiSelectDownload").classList.add("d-none");
}

function movie(type, code,b) {

    var form = new FormData();
    form.append("type", type);
    form.append("code", code);

    if(b != "" || b != null){
        form.append("b",b);
    }

    var request = new XMLHttpRequest();
    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            var response = request.responseText;
            if (response == "1") {

                alert("File is not readable.");
                window.location.reload();

            } else if (response == "2") {
                alert("Something Went Wrong");
            } else if (response == "3") {
                alert("Please LogIn First");
            } else if (response == "4") {
                alert("Your Watch Limit For This Month Has Been Reached");
            } else {

                document.getElementById("movieDiv").classList.remove("d-none");
                document.getElementById("movieSource").src = response;

                var sp = response.split(".");
                var filetype = sp.pop();

                document.getElementById("movieSource").type = filetype;

                // alert(response);
                // alert(filetype);
            }
        }
    };

    request.open("POST", "loadContentMovie.php", true);
    request.send(form);

}

// function pay() {


//     // Payment completed. It can be a successful failure.
//     payhere.onCompleted = function onCompleted(orderId) {
//         console.log("Payment completed. OrderID:" + orderId);
//         // Note: validate the payment and show success or failure page to the customer
//     };

//     // Payment window closed
//     payhere.onDismissed = function onDismissed() {
//         // Note: Prompt user to pay again or show an error page
//         console.log("Payment dismissed");
//     };

//     // Error occurred
//     payhere.onError = function onError(error) {
//         // Note: show an error page
//         console.log("Error:" + error);
//     };

//     // Put the payment variables here
//     var payment = {
//         "sandbox": true,
//         "merchant_id": "1222051", // Replace your Merchant ID
//         "return_url": undefined, // Important
//         "cancel_url": undefined, // Important
//         "notify_url": "http://sample.com/notify",
//         "order_id": "ItemNo12345",
//         "items": "Door bell wireles",
//         "amount": "1000.00",
//         "currency": "LKR",
//         "first_name": "Saman",
//         "last_name": "Perera",
//         "email": "samanp@gmail.com",
//         "phone": "0771234567",
//         "address": "No.1, Galle Road",
//         "city": "Colombo",
//         "country": "Sri Lanka",
//         "delivery_address": "No. 46, Galle road, Kalutara South",
//         "delivery_city": "Kalutara",
//         "delivery_country": "Sri Lanka",
//         "custom_1": "",
//         "custom_2": ""
//     };

//     // Show the payhere.js popup, when "PayHere Pay" is clicked
//     // document.getElementById('payhere-payment').onclick = function(e) {
//     payhere.startPayment(payment);


// }

function addC(type, code, comment_id) {
    if (document.getElementById("sendCommentBtn").innerHTML == "Save Edit") {
        updateComment(type, code, comment_id);
    } else {
        addComment(type, code);
    }
}

function addComment(type, code) {

    var text = document.getElementById("new_comment").value;

    var form = new FormData();
    form.append("txt", text);
    form.append("type", type);
    form.append("code", code);

    var request = new XMLHttpRequest();
    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            var response = request.responseText;
            if (response == "1") {

                alert("Success");
                window.location.reload();

            } else if (response == "2") {
                alert("Login First");
            } else {
                alert(response);
            }
        }
    };

    request.open("POST", "addNewComment.php", true);
    request.send(form);
}

function loadComment(comment_id) {
    document.getElementById("new_comment").value = document.getElementById("commentText" + comment_id).innerHTML;

    document.getElementById("sendCommentBtn").innerHTML = "Save Edit";

}

function updateComment(type, code, comment_id) { //1 movie

    var text = document.getElementById("new_comment").value;

    var form = new FormData();
    form.append("txt", text);
    form.append("type", type);
    form.append("code", code);
    form.append("comment_id", comment_id);

    var request = new XMLHttpRequest();
    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            var response = request.responseText;
            if (response == "1") {

                alert("Update Success");
                window.location.reload();

            } else if (response == "2") {
                alert("Login First");
            } else {
                alert(response);
            }
        }
    };

    request.open("POST", "updateComment.php", true);
    request.send(form);

}

function singleContentLoad(x, code) {

    var movie;
    var tv;

    if (x == "m") {
        movie = 't';
        tv = 'f';
    } else if (x == "t") {
        movie = 'f';
        tv = 't';
    }

    window.location.href = "singleContentData.php?movie=" + movie + "&tv=" + tv + "&code=" + code;

}

function like(type, code) {

    var form = new FormData();
    form.append("type", type);
    form.append("code", code);

    var request = new XMLHttpRequest();
    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            var response = request.responseText;

            if (response == "2") {
                alert("Login First");
            } else {
                toast(response);
                // alert(response);
                setTimeout(() => {
                    window.location.reload();
                }, 700);
            }
        }
    };

    request.open("POST", "like.php", true);
    request.send(form);

}

function unlike(type, code) {

    var form = new FormData();
    form.append("type", type);
    form.append("code", code);

    var request = new XMLHttpRequest();
    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            var response = request.responseText;

            if (response == "2") {
                alert("Login First");
            } else {
                toast(response);
                // alert(response);
                setTimeout(() => {
                    window.location.reload();
                }, 700);
            }
        }
    };

    request.open("POST", "unlike.php", true);
    request.send(form);

}

function addToCart(type, code) {

    var form = new FormData();
    form.append("type", type);
    form.append("code", code);

    var request = new XMLHttpRequest();
    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            var response = request.responseText;

            if (response == "2") {
                alert("Login First");
            } else if (response == "1") {
                alert("Something Went Wrong");
            } else {

                $jsonText = response;
                $obj = JSON.parse($jsonText);

                toast($obj);
            }
        }
    };

    request.open("POST", "addToCart.php", true);
    request.send(form);

}



function downloadMovie(type, code) {

    var form = new FormData();
    form.append("type", type);
    form.append("code", code);

    var request = new XMLHttpRequest();
    request.responseType = 'blob';

    request.onload = function() {
        if (request.status === 200) {
            // Create a new anchor element and download the file
            var a = document.createElement('a');
            var url = window.URL.createObjectURL(request.response);
            a.href = url;
            a.download = 'filename.mp4';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            window.URL.revokeObjectURL(url);
        }
    };

    request.open("POST", "downloadMovie.php", true);
    request.send(form);

}



function downloadEpisodeSelect() {

    alert("Select A Episode");
    document.getElementById("epiSelectDownload").classList.remove("d-none");
    document.getElementById("epiSelect").classList.add("d-none");

}

function downloadEpisode(type, code) {
    var epi_id = document.getElementById("epiSelectDownload").value;

    var form = new FormData();
    form.append("type", type);
    form.append("code", code);
    form.append("epi_id", epi_id);

    var request = new XMLHttpRequest();
    request.responseType = 'blob';

    request.onload = function() {
        if (request.status === 200) {
            // Create a new anchor element and download the file
            var a = document.createElement('a');
            var url = window.URL.createObjectURL(request.response);
            a.href = url;
            a.download = 'filename.mp4';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            window.URL.revokeObjectURL(url);
        }
    };

    request.open("POST", "downloadEpisode.php", true);
    request.send(form);

}


function favourite(type, code) {

    var form = new FormData();
    form.append("type", type);
    form.append("code", code);

    var request = new XMLHttpRequest();
    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            var response = request.responseText;

            if (response == "2") {
                alert("Login First");
            } else if (response == "1") {
                alert("Something Went Wrong");
            } else {

                $jsonText = response;
                $obj = JSON.parse($jsonText);

                toast($obj);
            }
        }
    };

    request.open("POST", "addToFavourite.php", true);
    request.send(form);

}

function toast(response) {

    var toastLiveExample = document.getElementById('liveToast2');
    var toast = new bootstrap.Toast(toastLiveExample);

    var now = new Date();
    var time = now.getHours() + " " + now.getMinutes();

    document.getElementById("time2").innerHTML = "At " + time;
    document.getElementById("msg2").innerHTML = response;

    toast.show();

    setTimeout(a, 2000);
}

function a() {
    window.location.reload();
}