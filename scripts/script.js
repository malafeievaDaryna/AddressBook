function CreateRequest()
{
    var Request = false;

    if (window.XMLHttpRequest)
    {
        //Gecko-совместимые браузеры, Safari, Konqueror
        Request = new XMLHttpRequest();
    }
    else if (window.ActiveXObject)
    {
        //Internet explorer
        try
        {
             Request = new ActiveXObject("Microsoft.XMLHTTP");
        }    
        catch (CatchException)
        {
            //empty
        }
    }
 
    if (!Request)
    {
        alert("Невозможно создать XMLHttpRequest");
    }
    
    return Request;
} 


function ready() {
    let xhttp = CreateRequest();
    if (!xhttp)
    {
        return;
    }

    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("content").innerHTML = this.responseText;
            console.log(this.responseText);
        }
    };
    xhttp.open('POST', '../db_proxy.php', true);
    xhttp.send();
}

document.addEventListener("DOMContentLoaded", ready);
console.log("jjj");