<?php

/**
 * notam short summary.
 *
 * notam description.
 *
 * @version 1.0
 * @author rt-2
 */
class Notam
{
    private $airport = null;
    private $time_from = null;
    private $time_to = null;
    private $time_human = null;
    private $text = null;


    public function __construct($configArray) {
    


        if(isset($configArray['airport'])) $this->airport = $configArray['airport'];
        if(isset($configArray['time_from'])) $this->time_from = $configArray['time_from'];
        if(isset($configArray['time_to'])) $this->time_to = $configArray['time_to'];
        if(isset($configArray['time_human'])) $this->time_human = $configArray['time_human'];
        if(isset($configArray['text'])) $this->text = $configArray['text'];



    }
    function GetAirport()
    {
        return $this->airport;
    }
    function GetTimeFrom()
    {
        return $this->time_from;
    }
    function GetTimeTo()
    {
        return $this->time_to;
    }
    function GetTimeHuman()
    {
        return $this->time_human;
    }
    function GetText()
    {
        return $this->text;
    }
}