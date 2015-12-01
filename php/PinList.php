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
    private $possiblePins = NULL;
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
        $results = $this->db->queryPossiblePins($this->sensorID);
        if (isset($results)){
            foreach ($results as $row){
                $this->possiblePins[$row['PinNumber']][$row['PinID']] = $row['Address'];
            }
        }
/*        $results = $this->db ->querySetPins($this->userID, $nodeID, $childID);
        if(isset($results)){
            foreach ($results as $row){
                $pin = new Pin();
                $pin->setID($row["PinID"]);
                $pin->setNumber($row["PinNumber"]);
                $pin->setAddress($row["Address"]);
                $pin->setMode($row["Mode"]);
                $pin->setType($row["Type"]);
                $this->addPin($pin);
            }
        }*/
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
    
    function printTypeSelect() {
        
    }
    
    function printAddressSelect(){
        
    }
    
    function printModeSelect() {
/*        $select = "<select name='sensor'>";
        $results = $this->db->queryAllSensors();
        if(isset($results)){
            foreach ($results as $row){
                if($row["SensorID"] != 0){
                    $select .= "<option value='".$row["SensorID"]."'>".$row["SensorName"]."</option>";
                }
            }
        }
        $select .=     "</select>";
        return $select;*/
    }    
    
    function printTable ($style){
        $style['headers'] = FALSE;

        $table = "<table class='pinList'>";
        if ($style['headers'] == TRUE){
            $table .= "<tr><th>Adress</th><th>Mode</th><th>Type</th>";
            $table .= "</tr>";
        }
        $table .= "<tr><td colspan='2'><form method='POST' action='".$style['http'].$style['page']."?node=$this->nodeID'><select name='setPin'>";
        foreach ($this->pinList as $pin) {
            $table .= $pin->printRow($style, $possiblePins);
        }

        $table .=    "</select><input type='submit' name='submit' value='addPin' />"
                . "</form></td></tr>";
        $table .="</table>";
        return $table;
    }
}
