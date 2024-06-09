function searchContent() {
    var content_name = document.getElementById("content_name").value;
    var searchType = document.getElementById("searchType").value;

    var form = new FormData();
    form.append("searchType", searchType);

    if (content_name.trim() === "") {
        document.getElementById("content_name").classList.add("border-danger");
        var msg = "Please Insert Content Name";
        var color = "bg-danger";
        toast(msg, color);
    } else {
        document.getElementById("content_name").classList.remove("border-danger");
        form.append("content_name", content_name);

        var request = new XMLHttpRequest();
        request.onreadystatechange = function () {
            if (request.readyState == 4 && request.status == 200) {

                document.getElementById("contentDisplayDiv").innerHTML = request.responseText;

            }
        }
        request.open("POST", "searchContent.php", true);
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

var content_type_id;
var content_id1;
var content_status_id;
var bm;

function changeContentStatus(content_type, content_id, content_status) {

    content_type_id = content_type;
    content_id1 = content_id;
    content_status_id = content_status;

    if (content_status_id == 1) {
        var m = document.getElementById("statusChange");
        bm = new bootstrap.Modal(m);

        bm.show();
    } else {
        changeStatus();
    }
}

function changeStatus() {
    var form = new FormData();
    form.append("content_type_id", content_type_id);
    form.append("content_id", content_id1);
    form.append("content_status_id", content_status_id);

    if (content_status_id == 1) {
        var reason = document.getElementById("reason").value;

        if (reason.trim() === '') {
            alert("You Must Insert The Reason For The De-activation");
        } else {
            form.append("reason", reason);
            sendResquest();
        }

    } else if (content_status_id == 2) {
        sendResquest();
    }

    function sendResquest() {

        var request = new XMLHttpRequest();
        request.onreadystatechange = function () {
            if (request.readyState == 4 && request.status == 200) {
                var response = request.responseText;

                if (response == 1) {
                    document.getElementById("reason").value = null;
                    // window.location.reload();
                    // window.location.href="http://localhost/assignments/e/admin/home.php";

                    var msg = "De-Activation Successful";
                    var color = "bg-success";
                    toast(msg, color);

                } else if (response == 2) {
                    var msg = "Please Insert The Reason For The De-activation";
                    var color = "bg-warning";
                    toast(msg, color);

                } else if (response == 3) {
                    // window.location.reload();
                    // window.location.href="http://localhost/assignments/e/admin/home.php";

                    var msg = "Re-Activation Successful";
                    var color = "bg-success";
                    toast(msg, color);

                } else {
                    alert(response);
                }

                bm.hide();

            }
        }

        request.open("Post", "changeContentStatus.php", true);
        request.send(form);

    }

}

function addUpcommingContent() {

    var new_content_name = document.getElementById("new_content_name").value;
    var new_content_release_date = document.getElementById("new_content_release_date").value;
    var new_content_image = document.getElementById("epi");

    if (new_content_name.trim() === "") {
        document.getElementById("new_content_name").classList.add("border-danger");
        var msg = "Please Insert Upcomming Content Name";
        var color = "bg-danger";
        toast(msg, color);
    } else if (new_content_release_date === "") {
        document.getElementById("new_content_name").classList.remove("border-danger");

        document.getElementById("new_content_release_date").classList.add("border-danger");
        var msg = "Please Insert Release Date";
        var color = "bg-danger";
        toast(msg, color);
    } else if (new_content_image.files.length === 0) {
        document.getElementById("new_content_release_date").classList.remove("border-danger");

        document.getElementById("epi2").classList.add("btn-danger");
        var msg = "Please Select Cover Photo";
        var color = "bg-danger";
        toast(msg, color);
    } else {

        var form = new FormData();
        form.append("name", new_content_name);
        form.append("date", new_content_release_date);
        form.append("file", new_content_image.files[0]);

        var request = new XMLHttpRequest();
        request.onreadystatechange = function () {
            if (request.readyState == 4 && request.status == 200) {
                var response = request.responseText;
                var msg;
                var color;
                if (response == 1) {
                    msg = "Content Adding Successful";
                    color = "bg-success";
                    toast(msg, color);
                } else if (response == 2) {
                    msg = "File Uploading Faild";
                    color = "bg-danger";
                    toast(msg, color);
                } else if (response == 3) {
                    msg = "Invalid File Type";
                    color = "bg-danger";
                    toast(msg, color);
                } else if (response == 4) {
                    msg = "Content Already Exists";
                    color = "bg-warning";
                    toast(msg, color);
                } else if (response == 5) {
                    msg = "Insert Relavant Details";
                    color = "bg-success";
                    toast(msg, color);
                } else {
                    alert(response);
                }
            }
        }

        request.open("POST", "upcommingContent.php", true);
        request.send(form);

    }

}

function searchUpcommingContent() {
    var search_content_name = document.getElementById("search_content_name").value;

    if (search_content_name.trim() === "") {
        document.getElementById("search_content_name").classList.add("border-danger");
    } else {
        document.getElementById("search_content_name").classList.remove("border-danger");

        var form = new FormData();
        form.append("name", search_content_name);

        var request = new XMLHttpRequest();
        request.onreadystatechange = function () {
            if (request.readyState == 4 && request.status == 200) {
                var response = request.responseText;

                if (response == 1) {
                    document.getElementById("search_content_name").classList.add("border-danger");

                    var msg = "Insert The Upcomming Content Name";
                    var color = "bg-danger";
                    toast(msg, color);

                } else {
                    document.getElementById("searchedUpcomminContent").innerHTML = response;
                    document.getElementById("search_content_name").value = null;

                }
            }
        }

        request.open("POST", "searchUpcommingContent.php", true);
        request.send(form);
    }
}

function deactiveUpcommingContent(id, status) {
    var form = new FormData();
    form.append("id", id);
    form.append("status", status);

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            var response = request.responseText;

            var msg;
            var color;

            if (response == 1) {
                msg = "De-activation Successful";
                color = "bg-success";
                toast(msg, color);

            } else if (response == 2) {
                msg = "Something Went Wrong";
                color = "bg-warning";
                toast(msg, color);
            } else {
                alert(response);
            }
        }
    }

    request.open("POST", "deactivateUpcommingContent.php", true);
    request.send(form);
}

function uploadEpisode() {
    var select_tv = document.getElementById("select_tv").value;
    var episode_name = document.getElementById("episode_name").value;
    var hours = document.getElementById("hours").value;
    var minutes = document.getElementById("minutes").value;
    var episode = document.getElementById("episodeFile");
    var rating = document.getElementById("episode_rating").value;

    if (episode_name.trim() === "") {
        document.getElementById("episode_name").classList.add("border-danger");

        var msg = "Please Insert Episode Name";
        var color = "bg-danger";
        toast(msg, color);
    } else if (hours > 24 || hours < 0) {
        document.getElementById("episode_name").classList.remove("border-danger");

        document.getElementById("hours").classList.add("border-danger");

        var msg = "Hour Must Be Between 0 - 24";
        var color = "bg-danger";
        toast(msg, color);
    } else if (minutes > 59 || minutes < 0) {
        document.getElementById("hours").classList.remove("border-danger");

        document.getElementById("minutes").classList.add("border-danger");

        var msg = "Minutes Must Be Between 0 - 59";
        var color = "bg-danger";
        toast(msg, color);
    } else if ((hours == 0 && minutes == 0) || (hours == null && minutes == null)) {
        document.getElementById("hours").classList.add("border-danger");
        document.getElementById("minutes").classList.add("border-danger");

        var msg = "Both Hours & Minutes Cannot Be '0'";
        var color = "bg-warning";
        toast(msg, color);
    } else if (episode.files.length == 0) {
        document.getElementById("hours").classList.remove("border-danger");

        document.getElementById("epilabel").classList.add("bg-danger");

        var msg = "Please Select Episode File";
        var color = "bg-danger";
        toast(msg, color);
    }else if (rating.trim() === "") {
        document.getElementById("episode_rating").classList.add("border-danger");

        var msg = "Please Insert Episode Rating";
        var color = "bg-danger";
        toast(msg, color);
    }  else {

        var form = new FormData();
        form.append("select_tv", select_tv);
        form.append("name", episode_name);
        form.append("hours", hours);
        form.append("minutes", minutes);
        form.append("rating", rating);
        form.append("episode", episode.files[0]);

        var request = new XMLHttpRequest();
        request.onreadystatechange = function () {
            if (request.readyState == 4 && request.status == 200) {
                var response = request.responseText;

                if (response == 1) {
                    var msg = "Successfully Completed";
                    var color = "bg-success";

                    toast(msg, color);
                } else if (response == 2) {
                    var msg = "File Uploading Faild";
                    var color = "bg-danger";
                    toast(msg, color);
                } else if (response == 3) {
                    var msg = "Invalid File Format";
                    var color = "bg-warning";
                    toast(msg, color);
                } else if (response == 4) {
                    var msg = "Episode Already Exists";
                    var color = "bg-warning";
                    toast(msg, color);
                } else if (response == 5) {
                    document.getElementById("epilabel").classList.add("bg-danger");

                    var msg = "Select Episode File";
                    var color = "bg-danger";
                    toast(msg, color);
                } else if (response == 6) {
                    document.getElementById("minutes").classList.add("border-danger");

                    var msg = "Invalid Minutes";
                    var color = "bg-danger";
                    toast(msg, color);
                } else if (response == 7) {
                    document.getElementById("hours").classList.add("border-danger");

                    var msg = "Invalid Hours";
                    var color = "bg-danger";
                    toast(msg, color);
                } else if (response == 8) {
                    document.getElementById("episode_name").classList.add("border-danger");

                    var msg = "Insert Episode Name";
                    var color = "bg-danger";
                    toast(msg, color);
                } else if (response == 9) {
                    document.getElementById("select_tv").classList.add("border-danger");

                    var msg = "Select Tv Series";
                    var color = "bg-danger";
                    toast(msg, color);
                } else if (response == 10) {
                    document.getElementById("episode_rating").classList.add("border-danger");

                    var msg = "Insert Episode Rating";
                    var color = "bg-danger";
                    toast(msg, color);
                } else {
                    alert(response);
                }
            }
        }

        request.open("POST", "uploadEpisode.php", true);
        request.send(form);

    }
}

function searchEpisode() {
    var tvSeriesId = document.getElementById("episodeSearchTvSeries").value;

    if (tvSeriesId == 0) {
        document.getElementById("episodeSearchTvSeries").classList.add("border-danger");
        var msg = "Please Select Tv-Series";
        var color = "bg-danger";
        toast(msg, color);
    } else {

        var form = new FormData();
        form.append("tvSeriesId", tvSeriesId);

        document.getElementById("episodeSearchTvSeries").classList.remove("border-danger");

        var request = new XMLHttpRequest();
        request.onreadystatechange = function () {
            if (request.readyState == 4 && request.status == 200) {

                document.getElementById("episodeContentDisplayDiv").innerHTML = request.responseText;

            }
        }
        request.open("POST", "searchEpisode.php", true);
        request.send(form);
    }
}

var StvSeriesId;
var SepisodeId;
var SepisodeStatus;
var ep_bm;

function changeEpisodeStatus(tvSeriesId, episodeId, episodeStatus) {

    StvSeriesId = tvSeriesId;
    SepisodeId = episodeId;
    SepisodeStatus = episodeStatus;

    if (SepisodeStatus == 1) {
        var m = document.getElementById("statusChange2");
        ep_bm = new bootstrap.Modal(m);

        ep_bm.show();
    } else {
        episodeChangeStatus();
    }
}

function episodeChangeStatus() {
    var form = new FormData();
    form.append("tvSeriesId", StvSeriesId);
    form.append("episodeId", SepisodeId);
    form.append("episodeStatus", SepisodeStatus);

    if (SepisodeStatus == 1) {
        var reason = document.getElementById("episode_reason").value;

        if (reason.trim() === '') {
            alert("You Must Insert The Reason For The De-activation");
        } else {
            form.append("reason", reason);
            sendEpResquest();
        }

    } else if (SepisodeStatus == 2) {
        sendEpResquest();
    }

    function sendEpResquest() {

        var request = new XMLHttpRequest();
        request.onreadystatechange = function () {
            if (request.readyState == 4 && request.status == 200) {
                var response = request.responseText;

                if (response == 1) {
                    document.getElementById("reason").value = null;

                    var msg = "De-Activation Successful";
                    var color = "bg-success";
                    toast(msg, color);

                } else if (response == 2) {
                    var msg = "Please Insert The Reason For The De-activation";
                    var color = "bg-warning";
                    toast(msg, color);

                } else if (response == 3) {

                    var msg = "Re-Activation Successful";
                    var color = "bg-success";
                    toast(msg, color);

                } else if (response == 4) {

                    var msg = "Please Activate Relavant Tv-Series First";
                    var color = "bg-warning";
                    toast(msg, color);

                } else if (response == 5) {

                    var msg = "Couldn't Find The Tv-Series";
                    var color = "bg-danger";
                    toast(msg, color);

                } else {
                    alert(response);
                }

                ep_bm.hide();

            }
        }

        request.open("Post", "changeEpisodeStatus.php", true);
        request.send(form);

    }

}


function changeNewType(value) {

    if (value == 1) {//movie
        document.getElementById("upload_movie_lable").classList.remove("d-none");
    } else if (value == 2) {//tv
        document.getElementById("upload_movie_lable").classList.add("d-none");
    } else if (value == 0) {
        document.getElementById("upload_movie_lable").classList.add("d-none");
    }
}

function addNewContent() {
    var type = document.getElementById("type").value;
    var genre = document.getElementById("genre").value;
    var quality = document.getElementById("quality").value;
    var language = document.getElementById("language").value;
    var year = document.getElementById("year").value;
    var country = document.getElementById("country").value;
    var adding_name = document.getElementById("adding_name").value;
    var adding_director = document.getElementById("adding_director").value;
    var adding_price = document.getElementById("adding_price").value;
    var adding_description = document.getElementById("adding_description").value;
    var newContentHours = document.getElementById("newContentHours").value;
    var newContentMinutes = document.getElementById("newContentMinutes").value;
    var releasedDate = document.getElementById("releasedDate").value;
    var rating = document.getElementById("c_rating").value;
    var adding_img = document.getElementById("adding_img");

    if (type == 1) {//movie
        var adding_movie = document.getElementById("adding_movie");
        if (adding_movie.files[0] == null) {

            document.getElementById("upload_movie_lable").classList.add("bg-danger");

            var color = "bg-danger";
            var msg = "Please Select Movie";

            toast(msg, color);

        }
    }


    if (type == 0) {
        document.getElementById("type").classList.add("border-danger");

        var color = "bg-danger";
        var msg = "Please Select Type";

        toast(msg, color);
    } else if (genre == 0) {
        document.getElementById("type").classList.remove("border-danger");

        document.getElementById("genre").classList.add("border-danger");

        var color = "bg-danger";
        var msg = "Please Select Genre";

        toast(msg, color);
    } else if (quality == 0) {
        document.getElementById("genre").classList.remove("border-danger");

        document.getElementById("quality").classList.add("border-danger");

        var color = "bg-danger";
        var msg = "Please Select Quality";

        toast(msg, color);
    } else if (language == 0) {
        document.getElementById("quality").classList.remove("border-danger");

        document.getElementById("language").classList.add("border-danger");

        var color = "bg-danger";
        var msg = "Please Select Language";

        toast(msg, color);
    } else if (year == 0) {
        document.getElementById("language").classList.remove("border-danger");

        document.getElementById("year").classList.add("border-danger");

        var color = "bg-danger";
        var msg = "Please Select Year";

        toast(msg, color);
    } else if (country == 0) {
        document.getElementById("year").classList.remove("border-danger");

        document.getElementById("country").classList.add("border-danger");

        var color = "bg-danger";
        var msg = "Please Select Country";

        toast(msg, color);
    } else if (adding_name.trim() == '') {
        document.getElementById("country").classList.remove("border-danger");

        document.getElementById("adding_name").classList.add("border-danger");

        var color = "bg-danger";
        var msg = "Please Insert Content Name";

        toast(msg, color);
    } else if (adding_director.trim() == "") {
        document.getElementById("adding_name").classList.remove("border-danger");

        document.getElementById("adding_director").classList.add("border-danger");

        var color = "bg-danger";
        var msg = "Please Insert Director Name";

        toast(msg, color);
    } else if (adding_price.trim() == '' || adding_price <= 0) {
        document.getElementById("adding_director").classList.remove("border-danger");

        document.getElementById("adding_price").classList.add("border-danger");

        var color = "bg-danger";
        var msg = "Invalid Price";

        toast(msg, color);
    } else if (releasedDate == '') {
        document.getElementById("adding_price").classList.remove("bg-danger");

        document.getElementById("releasedDate").classList.add("border-danger");

        var color = "bg-danger";
        var msg = "Please Select The Released Date";

        toast(msg, color);
    } else if (newContentHours > 24 && newContentMinutes > 59 || newContentHours == '' && newContentMinutes == "" || newContentHours <= 0 && newContentMinutes <= 0) {
        document.getElementById("releasedDate").classList.remove("bg-danger");

        document.getElementById("newContentHours").classList.add("border-danger");
        document.getElementById("newContentMinutes").classList.add("border-danger");

        var color = "bg-danger";
        var msg = "Invalid Values For Length";

        toast(msg, color);
    } else if (adding_img.files[0] == null) {
        document.getElementById("newContentHours").classList.remove("border-danger");
        document.getElementById("newContentMinutes").classList.remove("border-danger");

        document.getElementById("addimg_img_label").classList.add("bg-danger");

        var color = "bg-danger";
        var msg = "Please Select Cover Img";

        toast(msg, color);
    } else if (adding_description.trim() == '') {
        document.getElementById("addimg_img_label").classList.remove("bg-danger");

        document.getElementById("adding_description").classList.add("border-danger");

        var color = "bg-danger";
        var msg = "Please Insert Description";

        toast(msg, color);
    }else if (rating.trim() == '') {
        document.getElementById("adding_description").classList.remove("bg-danger");

        document.getElementById("c_rating").classList.add("border-danger");

        var color = "bg-danger";
        var msg = "Please Insert Ratings";

        toast(msg, color);
    } else {

        var color = "bg-dark";
        var msg = "Content Uploading Start ...";
        toast(msg, color);

        var form = new FormData();
        form.append("type", type);
        form.append("genre", genre);
        form.append("quality", quality);
        form.append("language", language);
        form.append("year", year);
        form.append("country", country);
        form.append("name", adding_name);
        form.append("director", adding_director);
        form.append("price", adding_price);
        form.append("img", adding_img.files[0]);
        form.append("description", adding_description);
        form.append("releasedDate", releasedDate);
        form.append("rating", rating);

        if (newContentHours == '') {
            newContentHours = 0;
        }

        if (newContentMinutes == "") {
            newContentMinutes = 0;
        }

        form.append("newContentHours", newContentHours);
        form.append("newContentMinutes", newContentMinutes);

        if (type == 1) {
            form.append("movie", adding_movie.files[0]);
        }

        var request = new XMLHttpRequest();
        request.onreadystatechange = function () {
            if (request.readyState == 4 && request.status == 200) {
                var response = request.responseText;

                if (response == 1) {

                    var msg = "New Content Adding Successful";
                    var color = "bg-success";
                    toast(msg, color);

                    document.getElementById("type").selectedIndex = 0;
                    document.getElementById("genre").selectedIndex = 0;
                    document.getElementById("quality").selectedIndex = 0;
                    document.getElementById("language").selectedIndex = 0;
                    document.getElementById("year").selectedIndex = 0;
                    document.getElementById("country").selectedIndex = 0;
                    document.getElementById("adding_name").value = "";
                    document.getElementById("adding_director").value = "";
                    document.getElementById("adding_price").value="";
                    document.getElementById("adding_description").value = "";
                    document.getElementById("adding_img").value = "";
                    document.getElementById("releasedDate").value = "";
                    document.getElementById("newContentHours").value = "";
                    document.getElementById("newContentMinutes").value = "";
                    document.getElementById("c_rating").value = "";

                } else if (response == 2) {
                    var msg = "Movie Cover Uploading Faild";
                    var color = "bg-danger";
                    toast(msg, color);

                } else if (response == 3) {

                    var msg = "Movie Uploading Faild";
                    var color = "bg-danger";
                    toast(msg, color);

                } else if (response == 4) {

                    var msg = "Invalid Movie File Format";
                    var color = "bg-warning";
                    toast(msg, color);

                } else if (response == 5) {

                    var msg = "Tv-Series Cover Image Uploading Faild";
                    var color = "bg-danger";
                    toast(msg, color);

                } else if (response == 6) {

                    var msg = "Invalid Image Format";
                    var color = "bg-warning";
                    toast(msg, color);

                } else if (response == 7) {

                    var msg = "Please Provide All Necessary Details";
                    var color = "bg-dark";
                    toast(msg, color);

                } else {
                    alert(response);
                }

            }
        }

        request.open("Post", "addNewContent.php", true);
        request.send(form);


    }

}

function cover() {
    var img_tag = document.getElementById("adding_img");
    var url = URL.createObjectURL(img_tag.files[0]);
    document.getElementById("bgCover").style.backgroundImage = "url(" + url + ")";
    document.getElementById("bgCover").style.backgroundRepeat = "no-repeat";
    document.getElementById("bgCover").style.backgroundSize = "cover";
    document.getElementById("bgCover").style.backgroundPosition = "center";


    document.getElementById("addimg_img_label").classList.add("bg-black");
    document.getElementById("addimg_img_label").innerHTML = "Change Cover Photo";

}


