<!DOCTYPE html>
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
    #search, #result {
      padding: 5px;
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
        <input name="icao" type="text" maxlength="4" />
        <input type="submit" value="Search" />
      </form>
    </div>
    <div id="result">
    <?php
      if(isset($_POST['icao']) && strlen($_POST['icao']) == 4)
      {
        // Requires the CANotAPI script from this package
        require('./CANotAPI.inc');

        //
        //	Show notams with a list or search words
        //
        //echo '<h2>Important Notams for CYUL</h2>';

        // This function echos the html result
        CANotAPI_EchoNotamsString($_POST['icao'], ['CLSD', 'NOT AUTH'], false);
      }
    ?>
    </div>
  </body>
</html>
