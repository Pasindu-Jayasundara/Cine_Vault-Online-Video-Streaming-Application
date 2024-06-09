function logout() {
    var request = new XMLHttpRequest();
    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            window.location.reload();
        }
    };

    request.open("POST", "logout.php", true);
    request.send();
}

// side bar

window.addEventListener("load", navBar);

function navBar() {
    var path = window.location.pathname;
    var page = path.split("/").pop();

    if (page == "home.php") {
        document.getElementById("homel").classList.add("active");
    } else if (page == "dashboard.php") {
        document.getElementById("dashboard").classList.add("active");
    } else if (page == "content.php") {
        document.getElementById("content").classList.add("active");
    } else if (page == "message.php") {
        document.getElementById("users").classList.add("active");
    }else if (page == "settings.php") {
        document.getElementById("setting").classList.add("active");
    }
}