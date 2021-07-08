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
        console.log("error when creatint XMLHttpRequest");
    }
    
    return Request;
} 

function refresh(obj) {
    if (obj.readyState === 4 && obj.status === 200) {
        console.log(obj.responseText);

        let table = document.getElementById("contacts");
        const contacts = JSON.parse(obj.responseText);
        
        table.innerHTML = "";

        if (contacts)
        {
            contacts.forEach((obj) => {
                let row = table.insertRow();
                Object.entries(obj).forEach(([key, value]) => {
                    //console.log(key + " " + value);

                    let cell = row.insertCell();
                    
                    if (key === 'NAME')
                    {
                        row.onclick = function () {
                            document.getElementById("name").value = value;
                        };
                    }

                    if (key === 'ID')
                    {
                        cell.innerHTML = "<button onClick='deleteContact(this)' id='" + value + "'> delete </button>";
                    } else
                    {
                        cell.innerHTML = value;
                    }
                });
            });
        } else
        {
            console.log("error when parsing");
        }

    }
}
;
    
function ready() {
    let xhttp = CreateRequest();
    if (!xhttp)
    {
        return;
    }

    xhttp.onreadystatechange = function () { refresh(this); };
    xhttp.open('POST', '../db_proxy.php', true);
    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhttp.send("request=getContacts");
}

function deleteContact(obj) {
    let xhttp = CreateRequest();
    if (xhttp)
    {
        let id = obj.id;

        xhttp.onreadystatechange = function () { ready(); };
        xhttp.open('POST', '../db_proxy.php', true);
        xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhttp.send("request=delete&id=" + id);
    } 
}

document.addEventListener("DOMContentLoaded", ready);

document.getElementById("adding").onclick = function() {
    let xhttp = CreateRequest();
    if (xhttp)
    {
        let name = document.getElementById("name").value;
        let phone = document.getElementById("phone").value;

        xhttp.onreadystatechange = function () { ready(); };
        xhttp.open('POST', '../db_proxy.php', true);
        xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhttp.send("request=insert&name=" + name + "&phone=" + phone);
    }
};