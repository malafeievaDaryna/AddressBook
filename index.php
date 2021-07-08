
<html>
    <head>
        <script src="scripts/script.js" defer></script>
        <link rel="stylesheet" type="text/css" href="css/general_style.css">
        <title>Title</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <div id="header">
            <h1>AddressBook</h1>
            <h5>To modify existing contact: just select any available contact and change phone number at editing form</h5>
        </div>
        <div id="content">
            <table id="contacts">
                <!--<tr>
                    <th>Name</th>
                    <th>Phone</th>
                </tr>-->
            </table>

            <div id="newContact">
                <p>Contact name:&nbsp; <input type="text" id="name" size="20" style="text-align: left" /></p>
                <p>Contact phone: <input type="text" id="phone" size="20" style="text-align: left" /></p>
                <p style="text-align: center"> <button id = "adding"> add/modify Contact </button>
            </div>
        </div>
    </body>
</html>
