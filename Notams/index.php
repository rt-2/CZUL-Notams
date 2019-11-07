<!DOCTYPE html>
<?php
$icaoInput = '';
if(isset($_REQUEST['icao']) && strlen($_REQUEST['icao']) == 4)
{
	require('./CANotAPI.inc.php');
	$icaoInput = strtoupper($_REQUEST['icao']);
}
?>
<html>
    <head>
    <meta charset="UTF-8">
    <title>Title of the document</title>

    <link rel="stylesheet" type="text/css" href="mystyle.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <style>
    .CANotAPI_Notam_active {
        background-color: lightgreen;
    }
    .CANotAPI_Notam_soonActive {
        background-color: yellow;
    }
    .CANotAPI_Notam_inactive {
        background-color: red;
    }
    .CANotAPI_Notam_timeUndef {
        background-color: gray;
    }
    #search {
        padding: 5px;
    }
    #result {
        padding: 25px;
    }
    </style>
    <script>

    /*
    jQuery Document Ready
    */
    $( document ).ready(function() {
    // Document ready
    });

    /*
    Javascript Try/Catch
    */
    try {
    // Try something

    }
    catch(err) {
    // Catch errors (Should be err.message)
    if(console && console.log) console.log(err);
    if(console && console.log) console.log("ERROR:\nAt column "+err.columnNumber+" on line "+err.lineNumber+" of file:"+err.fileName+"\nMessage: "+err.message+"\nStack:\n"+err.stack);
    }

    /*
    jQuery Asynchronous calls (AJAX)
    */
    function sendExampleAJAX() {

    fd = new FormData();
    fd.append( 'file', $('#input1').val() );

    $.ajax({
    url : "AJAX_POST_URL",
    type: "POST",
    data: fd,
    processData: false,
    contentType: false,
    success: function(data, status, responseObject)
    {
    //data - response from server
    },
    error: function (responseObject, status, error)
    {

    }
    });
    }
    </script>
    </head>
    <body>
        <div id="search">
            <form action="" method="POST">
                Airport ICAO:
                <input name="icao" type="text" maxlength="4" value="<?=$icaoInput?>" />
                <input type="submit" value="Search" />
            </form>
        </div>
        <div id="result">
        <?php
        if(strlen($icaoInput) == 4)
        {
            ?>
            <hr />
            <?php
            CANotAPI_EchoNotamsString($icaoInput, ['CLSD', 'NOT AUTH'], false);
        }
        ?>
        </div>
    </body>
</html>
