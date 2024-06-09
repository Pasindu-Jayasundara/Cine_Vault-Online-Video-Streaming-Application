window.addEventListener("load", () => {
    var imgs = document.getElementById("imgs");
    var first = imgs.firstElementChild;

    first.classList.add("active");
    document.getElementById("leftCarousel").firstElementChild.classList.add("active");
    document.getElementById("rightCarousel").firstElementChild.classList.add("active");

});


window.addEventListener("load", all());

function all() {

    var request = new XMLHttpRequest();
    request.onreadystatechange = function() {
        if (request.readyState == 4 & request.status == 200) {

            var response = request.responseText;
            document.getElementById("cardDiv").innerHTML = response;

        }
    };

    request.open("POST", "indexContentLoad.php", true);
    request.send();
}

window.addEventListener("load",()=>{
    highRating();
    mostPopuler();
});

function highRating(){
    var request = new XMLHttpRequest();
    request.onreadystatechange = function() {
        if (request.readyState == 4 & request.status == 200) {

            var response = request.responseText;
            document.getElementById("highRatingCardDiv").innerHTML = response;

        }
    };

    request.open("POST", "highRatingIndexContentLoad.php", true);
    request.send();
}

function mostPopuler(){
    var request = new XMLHttpRequest();
    request.onreadystatechange = function() {
        if (request.readyState == 4 & request.status == 200) {

            var response = request.responseText;
            document.getElementById("mostPopulerCardDiv").innerHTML = response;

        }
    };

    request.open("POST", "mostPopulerIndexContentLoad.php", true);
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

function bookmarkAddToCheckList(code, type) {

    var form = new FormData();
    form.append("code", code);
    form.append("type", type);

    var request = new XMLHttpRequest();
    request.onreadystatechange = function() {
        if (request.readyState == 4 & request.status == 200) {

            var responseJsonText = request.responseText;
            var jsonObj = JSON.parse(responseJsonText);

            var tr = document.createElement("tr");
            var td1 = document.createElement("td");
            var td2 = document.createElement("td");

            td1.setAttribute("id", "name" + jsonObj.code);
            td2.setAttribute("id", "price" + jsonObj.code);

            document.getElementById("tbody").appendChild(tr);
            tr.appendChild(td1);
            tr.appendChild(td2);

            document.getElementById("name" + jsonObj.code).innerHTML = jsonObj.name;
            document.getElementById("price" + jsonObj.code).innerHTML = jsonObj.price;

            total_price = total_price + parseInt(jsonObj.price);

            document.getElementById("totaltr").innerHTML = total_price;
        }
    };

    request.open("POST", "bookmarkAddToCheckList.php", true);
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