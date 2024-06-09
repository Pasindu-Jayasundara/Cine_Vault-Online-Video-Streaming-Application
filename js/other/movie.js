window.addEventListener("load", () => {
    var imgs = document.getElementById("imgs");
    var first = imgs.firstElementChild;

    first.classList.add("active");
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

    request.open("POST", "movieContentLoad.php", true);
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

    request.open("POST", "highRatingMovieContentLoad.php", true);
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

    request.open("POST", "mostPopulerMovieContentLoad.php", true);
    request.send();
}

window.addEventListener("load", () => {
    var imgs = document.getElementById("imgs");
    var first = imgs.firstElementChild;

    first.classList.add("active");
    document.getElementById("leftCarousel").firstElementChild.classList.add("active");
    document.getElementById("rightCarousel").firstElementChild.classList.add("active");

});

function movieDescription(movie_code) {

    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip' + movie_code + '"]');
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));

}

function singleContentLoad(x, code) {

    var movie;
    var tv;

    if (x == "m") {
        movie = 't';
        tv = 'f';
    }

    window.location.href = "singleContentData.php?movie=" + movie + "&tv=" + tv + "&code=" + code;

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