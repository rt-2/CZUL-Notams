<!DOCTYPE html>
<?php

require_once(dirname(__FILE__).'/CANotAPI.inc.php');
require_once(dirname(__FILE__).'/resources/fir.data.inc.php');

$icaoInput = '';
$icaoOutside = false;

if(isset($_REQUEST['icao']) && strlen($_REQUEST['icao']) == 4)
{
	$icaoInput = strtoupper($_REQUEST['icao']);
}

$mustShowSearchUi = (isset($_GET['nosearch']) ? false : true );

if(strlen($icaoInput) === 4)
{

    if(!array_key_exists($icaoInput, $firAirports))
    {
        $icaoOutside = true;
    }
}
if(!$icaoOutside)
{

    //Fetch NOTAMs
    $notamsIds = file('../ACTIVE_NOTAMS_IDS.data.cnf');
    foreach($notamsIds as $value)
    {
        $notam_id = trim(preg_replace("/\;.*$/mu", '', $value));
        if(strlen($notam_id) > 0)
        {
            $GLOBALS['RECCOM_NOTAMS_IDS'][] = $notam_id;
        }
    }

}

function GetAllMandatoryForICAO($icao)
{
    $ret = []; 
    foreach(CANotAPI_GetNotamsSearch($icao, ' ') as $ths_notam_obj)
    {
        if(in_array($ths_notam_obj->GetIdent(), $GLOBALS['RECCOM_NOTAMS_IDS']))
        {
            $ret[] = $ths_notam_obj;
        }
    }
    return $ret;
}

?>
<html>
    <head>
    <meta charset="UTF-8">
    <title>NOTAMs</title>

    <link rel="stylesheet" type="text/css" href="assets/base.css" />
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
        padding: 7px;
    }
    #result {
        padding: <?=($mustShowSearchUi?'25':'7')?>px;
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
    <?php
    if($mustShowSearchUi)
    {
    ?>
    <div id="search">
        <form action="" method="POST">
            Airport ICAO:
            <input name="icao" type="text" maxlength="4" value="<?=$icaoInput?>" />
            <input type="submit" value="Search" />
        </form>
        <?php
        
            if($icaoOutside)
            {
                echo '<b>ICAO en dehors de la FIR<b>';
            }
        ?>
    </div>

    <?php
        
    }
    ?>
    <div id="result">
        
        <?php
        if($mustShowSearchUi)
        {
            ?>
            <hr />
            <br />
            <?php
        }
        $echoedNotams = 0;
        if(isset($_GET['allMandatory']))
        {
            $arrayOfArrayIGuess = [
                'CYUL' => GetAllMandatoryForICAO('CYUL'),
                'CYHU' => GetAllMandatoryForICAO('CYHU'),
                'CYQB' => GetAllMandatoryForICAO('CYQB'),
                'CYOW' => GetAllMandatoryForICAO('CYOW'),
                'CYRC' => GetAllMandatoryForICAO('CYRC'),
                'CYJN' => GetAllMandatoryForICAO('CYJN'),
            ];
            foreach($arrayOfArrayIGuess as $ArrayIGuess)
            {
                foreach($ArrayIGuess as $this_notam_obj)
                {
                    echo CANotAPI_GetHTMLBiutifulForNotam($this_notam_obj);
                    $echoedNotams++;
                }
            }
            if($echoedNotams == 0)
            {
                echo '<br /><u>No NOTAMs in operation in the FIR.</u><br />';
            }
        }

        if(!$icaoOutside && strlen($icaoInput) === 4)
        {
                if(isset($_GET['mandatory']))
                {
            
                    foreach(GetAllMandatoryForICAO($icaoInput) as $this_notam_obj)
                    {
                        echo CANotAPI_GetHTMLBiutifulForNotam($this_notam_obj);
                        $echoedNotams++;
                    }
                    if($echoedNotams == 0)
                    {
                        echo '<br /><u>No NOTAMs in operation at '.$icaoInput.'.</u><br />';
                    }
                }
                else
                {
                    CANotAPI_EchoNotamsString($icaoInput, ['CLSD', 'NOT AUTH'], false);

                }

        }
        ?>
        </div>
        <?php
        if(isset($_GET['mandatory']) || isset($_GET['mandatory']))
        {
            ?>
            <small>
                <span>
                    Les NOTAMs affichés ici sont uniquement ceux applicables aux opérations de VATSIM et en usage par la FIR de Montréal.
                </span>
                <br />
                <span>
                    The NOTAMs shown here are only those applicable to VATSIM operations and in use by the Montréal FIR.
                </span>
            </small>
            <?php
        }
        ?>
    </body>
</html>
