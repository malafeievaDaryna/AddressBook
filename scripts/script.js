function CreateRequest()
{
    let Request = false;

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
            console.log(this.responseText);

            let table = document.getElementById("contacts");
            const contacts = JSON.parse(this.responseText);

            if (contacts)
            {
                contacts.forEach((obj) => {
                    let row = table.insertRow();
                    Object.entries(obj).forEach(([key, value]) => {
                        //console.log(key + " " + value);

                        let cell = row.insertCell();
                        cell.innerHTML = value;
                    });
                });
            } else
            {
                console.log("error when parsing");
            }

        }
    };
    xhttp.open('POST', '../db_proxy.php', true);
    xhttp.setRequestHeader('Accept', 'application/json');
    xhttp.send();
}

document.addEventListener("DOMContentLoaded", ready);