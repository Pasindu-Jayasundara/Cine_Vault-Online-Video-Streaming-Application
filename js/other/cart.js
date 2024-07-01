window.addEventListener("load", all());

function all() {

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4 & request.status == 200) {

            var response = request.responseText;
            document.getElementById("cardDiv").innerHTML = response;
        }
    };

    request.open("POST", "cartContentLoad.php", true);
    request.send();
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

var total_price = 0;
var arr = [];

function bookmarkAddToCheckList(code, type) {

    var form = new FormData();
    form.append("code", code);
    form.append("type", type);

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4 & request.status == 200) {

            var responseJsonText = request.responseText;
            var jsonObj = JSON.parse(responseJsonText);

            if (arr.includes(jsonObj.code)) {

                var tr = document.getElementById("id" + jsonObj.code);
                tr.remove();

                total_price = total_price - parseInt(jsonObj.price);
                document.getElementById("totaltr").innerHTML = total_price;


                arr.splice(arr.indexOf(jsonObj.code), 1);

                document.getElementById("cartplusicon" + jsonObj.code).classList.replace("bi-bookmark-check-fill", "bi-bookmark-plus-fill");
                document.getElementById("cartplusicon" + jsonObj.code).classList.replace("greencolor", "text-warning");


            } else {
                var tr = document.createElement("tr");
                var td1 = document.createElement("td");
                var td2 = document.createElement("td");

                tr.setAttribute("id", "id" + jsonObj.code);
                td1.setAttribute("id", "name" + jsonObj.code);
                td2.setAttribute("id", "price" + jsonObj.code);

                document.getElementById("tbody").appendChild(tr);
                tr.appendChild(td1);
                tr.appendChild(td2);

                document.getElementById("name" + jsonObj.code).innerHTML = jsonObj.name;
                document.getElementById("price" + jsonObj.code).innerHTML = jsonObj.price;

                total_price = total_price + parseInt(jsonObj.price);

                document.getElementById("totaltr").innerHTML = total_price;

                document.getElementById("cartplusicon" + jsonObj.code).classList.replace("bi-bookmark-plus-fill", "bi-bookmark-check-fill");
                document.getElementById("cartplusicon" + jsonObj.code).classList.replace("text-warning", "greencolor");

                arr.push(jsonObj.code);
            }

        }
    };

    request.open("POST", "bookmarkAddToCheckList.php", true);
    request.send(form);
}

function toast(msg, color) {

    var toastLiveExample = document.getElementById('liveToast2');
    var toast = new bootstrap.Toast(toastLiveExample);

    var now = new Date();
    var time = now.getHours() + " : " + now.getMinutes();

    document.getElementById("time2").innerHTML = "At " + time;
    document.getElementById("msg2").innerHTML = msg;
    document.getElementById("headerColor2").classList.add(color);

    toast.show();
}

function checkHistory() {

    var form = new FormData();

    var jsonCodeArr = JSON.stringify(arr);
    form.append("code_arr", jsonCodeArr);

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4 & request.status == 200) {

            var json_response = request.responseText;
            var response = JSON.parse(json_response);

            if(response.length == 0){
                pay();
            }else{
                for(var x=0;x<response.length; x++){

                    var li = document.createElement("li");
                    li.setAttribute("id",x);
                    li.innerHTML=response[x];
                    document.getElementById("ullist").appendChild(li);

                }

                new bootstrap.Modal(document.getElementById("warning")).show();
            }

        }
    }
    request.open("POST", "checkPurchasedHistory.php", true);
    request.send(form);
}

function resetLi(){
    document.getElementById("ullist").innerHTML='';
}

function pay() {
    if (total_price == 0) {

        var msg = "You Havent Select Anything To Purchase";
        var color = "bg-warning";

        toast(msg, color);
    } else {

        var form = new FormData();
        form.append("total", total_price);

        var jsonCodeArr = JSON.stringify(arr);
        form.append("code_arr", jsonCodeArr);

        var request = new XMLHttpRequest();
        request.onreadystatechange = function () {
            if (request.readyState == 4 & request.status == 200) {

                var response = request.responseText;
                if (response == 2) {

                    var msg = "Couldn't Find The Purchase Details";
                    var color = "bg-warning";
                    toast(msg, color);

                } else {
                    var jsObj = JSON.parse(response);


                    // Payment completed. It can be a successful failure.
                    payhere.onCompleted = function onCompleted(orderId) {
                        console.log("Payment completed. OrderID:" + orderId);

                        // var jsonObj = JSON.stringify(obj);
                        addToDatabase(jsObj);
                        // Note: validate the payment and show success or failure page to the customer
                    };

                    // Payment window closed
                    payhere.onDismissed = function onDismissed() {
                        // Note: Prompt user to pay again or show an error page
                        console.log("Payment dismissed");
                        addToDatabase(jsObj);
                    };

                    // Error occurred
                    payhere.onError = function onError(error) {
                        // Note: show an error page
                        console.log("Error:" + error);
                    };

                    // Put the payment variables here
                    var payment = {
                        "sandbox": true,
                        "merchant_id": jsObj.merchant_id, // Replace your Merchant ID
                        "return_url": "http://localhost/assignments/e/user/cart.php", // Important
                        "cancel_url": "http://localhost/assignments/e/user/cart.php", // Important
                        "notify_url": "http://sample.com/notify",
                        "order_id": jsObj.order_id,
                        "items": jsObj.items,
                        "amount": jsObj.price,
                        "currency": jsObj.currency,
                        "hash": jsObj.hash, // *Replace with generated hash retrieved from backend
                        "first_name": jsObj.first_name,
                        "last_name": jsObj.last_name,
                        "email": jsObj.email,
                        "phone": "",
                        "address": "",
                        "city": "",
                        "country": "",
                        "delivery_address": "",
                        "delivery_city": "",
                        "delivery_country": "",
                        "custom_1": "",
                        "custom_2": ""
                    };

                    // Show the payhere.js popup, when "PayHere Pay" is clicked
                    payhere.startPayment(payment);

                }
            }
        };

        request.open("POST", "cartHash.php", true);
        request.send(form);

    }
}

function addToDatabase(jsObj) {

    var form = new FormData();

    var Json_jsObj = JSON.stringify(jsObj);
    form.append("jsObj", Json_jsObj);

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4 & request.status == 200) {

            var response = request.responseText;
            window.location.href = "receipt.php?id=" + parseInt(response);
        }
    };

    request.open("POST", "addToPurchased.php", true);
    request.send(form);

}

function removeFromCart(code, type) {

    var form = new FormData();
    form.append("code", code);
    form.append("type", type);

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4 & request.status == 200) {

            var response = request.responseText;

            if (response == "1") { // removed

                window.location.reload();

            } else {
                alert(response);
            }

        }
    };

    request.open("POST", "removedFromCart.php", true);
    request.send(form);

}