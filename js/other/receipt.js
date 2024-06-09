function printReceipt(){
    var receipt_body = document.getElementById("receipt_body").innerHTML;
    var body = document.getElementById("body").innerHTML;
    document.getElementById("body").innerHTML=receipt_body;

    document.getElementById("table").classList.remove("bg-black");
    document.getElementById("table").classList.add("bg-white");

    document.getElementById("table").classList.remove("text-white");
    document.getElementById("table").classList.add("text-black");

    document.getElementById("a1").classList.remove("bg-black");
    document.getElementById("a1").classList.remove("text-white");     

    document.getElementById("a2").classList.remove("bg-black");
    document.getElementById("a2").classList.remove("text-white");   

    document.getElementById("a3").classList.remove("bg-black");
    document.getElementById("a3").classList.remove("text-white");   

    document.getElementById("a4").classList.remove("bg-black");
    document.getElementById("a4").classList.remove("text-white");   
    
    document.getElementById("a1").classList.add("bg-white");
    document.getElementById("a1").classList.add("text-black"); 

    document.getElementById("a2").classList.add("bg-white");
    document.getElementById("a2").classList.add("text-black");

    document.getElementById("a3").classList.add("bg-white");
    document.getElementById("a3").classList.add("text-black");

    document.getElementById("a4").classList.add("bg-white");
    document.getElementById("a4").classList.add("text-black");

    document.getElementById("op").classList.add("d-none");

    window.print();
    document.getElementById("body").innerHTML=body;

}


function emailReceipt(){

    toast("Email Sending Process Started ...","bg-primary");

    var receipt_body = document.getElementById("receipt_body").innerHTML;

    var form = new FormData();
    form.append("body",receipt_body);

    var request=new XMLHttpRequest();
    request.onreadystatechange=function(){
        if(request.readyState==4&&request.status==200){

            var response = request.responseText;
            toast(response,"bg-primary");

        }
    }
    request.open("POST","emailReceipt.php",true);
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