<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PinList
 *
 * @author z
 */
include_once '../php/DbHelper.php';
include_once '../php/Pin.php';

class PinList {
    //put your code here
    private $pinList = NULL;
    private $db = NULL;
    private $userID = NULL;
    private $nodeID = NULL;
    private $childID = NULL;
    private $sensorID = NULL;

    function __construct($userID, $nodeID, $childID, $sensorID){
        $this->pinList = new SplObjectStorage();
        $this->db = new dbhelper();
        $this->userID = $userID;
        $this->nodeID = $nodeID;
        $this->childID = $childID;
        $this->sensorID = $sensorID;
        $results = $this->db ->querySensorPins($this->userID, $nodeID, $childID);
        if(isset($results)){
            $lastPinNumber = NULL;
            $pin = NULL;
            foreach ($results as $row){
                if ($row["pinNumber"] != $lastPinNumber){
                    $pin = new Pin();
                    $pin->setPinNumber($row["pinNumber"]);
                    $pin->setMode($row["Mode"]);
                    $pin->setType($row["Type"]);
                    $this->attachPin($pin);
                    $lastPinNumber = $row["pinNumber"];
                }
                if ($row["SetPin"] == TRUE){
                    $pin->setSelectedSensorPinID($row["SensorPinID"]);
                }
                $pin->addAddress($row["SensorPinID"], $row["Address"]);
            }
        }
    }
    
    function setSensorID($sensorID) {
        $this->sensorID = $sensorID;
    }
    
    function attachPin($pin){
        $sucess = !$this->pinList->contains($pin);
        if($sucess == TRUE){
            $this->pinList->attach($pin);
        }
        return $sucess;
    }
    
    function addPin($pin) {
        
    }
    
    function changePin($pinId) {
        
    }

    function deleteAllPins() {
        $this->db->deleteAllSensorPins($this->userID, $this->nodeID, $this->childID);
    }
    
    function deletePin($pinID) {
        
    }

    function printTable ($style){
        $style['headers'] = FALSE;
       
        $table = "<form method='POST' action='".$style['http'].$style['page']."?node=$this->nodeID'><table class='pinList'>";
        if ($style['headers'] == TRUE){
            $table .= "<tr><th>Adress</th><th>Mode</th><th>Type</th>";
            $table .= "</tr>";
        }
        foreach ($this->pinList as $pin) {
            $table .= $pin->printRow($pin);
        }
        $table .= "</table><input type='submit' name='submit' value='saveSelectedPins' /></form>";
        return $table;
    }
}
