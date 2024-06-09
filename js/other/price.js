var plan_id;

function subscription(plan) {

    plan_id = plan;

    var form = new FormData();
    form.append("plan_id", plan);

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4 & request.status == 200) {

            var response = request.responseText;

            if (response == "1") {
                // alert("You Have Already Activated This Subscription");
                var msg = "You Have Already Activated This Subscription";
                var color = "bg-warning";
                toast(msg, color);
            } else if (response == "2") {
                // alert("Something Went Wrong...");
                var msg = "Something Went Wrong...";
                var color = "bg-danger";
                toast(msg, color);
            } else if (response == "3") {
                if (plan_id == 1) {//basic
                    var basicObj ={};
                    basicObj.plan_id='1';
                    basicObj.price="0";

                    addToDatabase(basicObj);
                } else {
                    crateHash(plan);
                }
            } else if (response == "4") {
                // alert("Please LogIn or SignUp First..!");
                var msg = "Please LogIn or SignUp First..!";
                var color = "bg-warning";
                toast(msg, color);
            }
        }
    };

    request.open("POST", "subscription.php", true);
    request.send(form);

}

function crateHash(plan) {
    var form = new FormData();
    form.append("plan_id", plan);

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4 & request.status == 200) {

            var jsonResponse = request.responseText;
            var obj = JSON.parse(jsonResponse);
            buySubscription(obj);
        }
    };

    request.open("POST", "createHash.php", true);
    request.send(form);
}

function buySubscription(obj) {

    // Payment completed. It can be a successful failure.
    payhere.onCompleted = function onCompleted(orderId) {
        console.log("Payment completed. OrderID:" + orderId);

        // var jsonObj = JSON.stringify(obj);
        addToDatabase(obj);
        // Note: validate the payment and show success or failure page to the customer
    };

    // Payment window closed
    payhere.onDismissed = function onDismissed() {
        // Note: Prompt user to pay again or show an error page
        console.log("Payment dismissed");
    };

    // Error occurred
    payhere.onError = function onError(error) {
        // Note: show an error page
        console.log("Error:" + error);
    };

    // Put the payment variables here
    var payment = {
        "sandbox": true,
        "merchant_id": obj.merchant_id, // Replace your Merchant ID
        "return_url": "http://localhost/assignments/e/user/price.php", // Important
        "cancel_url": "http://localhost/assignments/e/user/price.php", // Important
        "notify_url": "http://sample.com/notify",
        "order_id": obj.plan_id,
        "items": obj.subscription_name,
        "amount": obj.price,
        "currency": obj.currency,
        "hash": obj.hash, // *Replace with generated hash retrieved from backend
        "first_name": obj.user_first_name,
        "last_name": obj.user_last_name,
        "email": obj.email,
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
    // document.getElementById('payhere-payment').onclick = function(e) {
    payhere.startPayment(payment);
    // };
}


function addToDatabase(obj) {

    var jsonObj = JSON.stringify(obj);


    var form = new FormData();
    form.append("Obj", jsonObj);

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4 & request.status == 200) {

            var response = request.responseText;
            if (response == 1) {
                var msg = "SubScription Plan Activation Successful";
                var color = "bg-success";
                toast(msg, color);
            } else {
                alert(response);
            }
        }
    };

    request.open("POST", "addToDatabase.php", true);
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

window.addEventListener("scroll",()=>{
    var x =document.getElementById("scrollBtn");
    var y=x.getClientRects();
    const firstRect = y[0];
    if(firstRect.top < 520){
        x.classList.add("opacity-0");
    }

    if(firstRect.top > 520){
        x.classList.remove("opacity-0");
    }
});