function delectFromPurchasedHistory(code,id){

    var form =new FormData();
    form.append("code",code);
    form.append("id",id);

    var request=new XMLHttpRequest();
    request.onreadystatechange=function(){
        if(request.readyState==4&&request.status==200){

            window.location.reload();

        }
    }
    request.open("POST","removeFromPurchasedHistory.php",true);
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
