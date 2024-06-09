window.addEventListener("load", all());

function all() {

    var request = new XMLHttpRequest();
    request.onreadystatechange = function() {
        if (request.readyState == 4 & request.status == 200) {

            var response = request.responseText;
            document.getElementById("cardDiv").innerHTML = response;
        }
    };

    request.open("POST", "favouriteContentLoad.php", true);
    request.send();
}

function movieDescription(movie_code) {

    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip' + movie_code + '"]');
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));

}

function tv_seriesDescription(tv_series_code) {

    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip' + tv_series_code + '"]');
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));

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

function bookmarkAddToCart(code, type) {

    var form = new FormData();
    form.append("code", code);
    form.append("type", type);

    var request = new XMLHttpRequest();
    request.onreadystatechange = function() {
        if (request.readyState == 4 & request.status == 200) {

            var responseJsonText = request.responseText;
            var response = JSON.parse(responseJsonText);

            var rstatus = response.status;
            if (rstatus == "1") { // remove

                document.getElementById("favouriteplusicon" + code).classList.replace("bi-cart-check-fill", "bi-cart-plus-fill");
                document.getElementById("favouriteplusicon" + code).classList.replace("greencolor", "text-warning");

            } else if (rstatus == "2") { //added

                document.getElementById("favouriteplusicon" + code).classList.replace("bi-cart-plus-fill", "bi-cart-check-fill");
                document.getElementById("favouriteplusicon" + code).classList.replace("text-warning", "greencolor");

            }

            toast(response);
        }
    };

    request.open("POST", "bookmarkAddToCart.php", true);
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

    var toastLiveExample = document.getElementById('liveToast2');
    var toast = new bootstrap.Toast(toastLiveExample);

    document.getElementById("time2").innerHTML = "At " + response.time;
    document.getElementById("msg2").innerHTML = response.message;

    toast.show();

}

function removeFromFavourite(code,type){

    var form = new FormData();
    form.append("code", code);
    form.append("type", type);

    var request = new XMLHttpRequest();
    request.onreadystatechange = function() {
        if (request.readyState == 4 & request.status == 200) {

            var response = request.responseText;

            if (response == "1") { // removed

                window.location.reload();

            } else {
                alert(response);
            }

        }
    };

    request.open("POST", "removedFromFavourite.php", true);
    request.send(form);

}