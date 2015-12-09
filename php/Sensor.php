<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of sensor
 *
 * @author ian
 */
include_once '../php/PinList.php';

class Sensor {
    private $sensorID = NULL;
    private $name = NULL;
    private $childID = NULL;
    private $vType = NULL;
    private $sType = NULL;
    private $note = NULL;
    private $pinList = NULL;
    private $userID = NULL;
    private $nodeID = NULL;
    
    function __construct($userID, $nodeID, $childID, $sensorID){
        $this->userID = $userID;
        $this->nodeID = $nodeID;
        $this->childID = $childID;
        $this->sensorID = $sensorID;
        $this->pinList = new PinList($userID, $nodeID, $childID, $sensorID);
    }
    
    function getNote() {
        return $this->note;
    }

    function setNote($note) {
        $this->note = $note;
    }

    function setID($ID){
        $this->sensorID = $ID;
    }
    
    function getID(){
        return $this->sensorID;
    }
    
    function setName($name){
        $this->name = $name;
    }
            
    function getName(){
        return $this->name;
    }
    
    function setType($vType, $sType){
        $this->vType = $vType;
        $this->sType = $sType;
    }
    
    function getSType(){
        return $this->sType;
    }
    
    function getVType(){
        return $this->vType;
    }
    
    function setChildID($childID){
        $this->childID = $childID;
    }
            
    function getChildID() {
        return $this->childID;
    }

    function getNodeID() {
        return $this->nodeID;
    }

    function getUserID() {
        return $this->userID;
    }
    
    function deleteAllPins() {
        $this->pinList->deleteAllPins();
    }
    
    function deletePin($pinID){
        
    }
    
    function setSelectedSensorPinID($selectedSensorPinID){
        $this->pinList->setSelectedSensorPinID($selectedSensorPinID);
    }
    
    function addPin($pin){}
    
    function removePin($pin){}
    
    function findPinById($pinID) {
        $this->pinList->rewind();
        while($this->pinList->valid() && $pinID != $this->pinList->current()->getId()){
            $this->pinList->next();
        }
        if($this->pinList->valid()){
            $pin = $this->pinList->current();
            return $pin;
        }
        return NULL;
    }
    
    function printTable($style){
        $table = "<table class='sensor'>";
        $table .= $this->printRow($style);
        $table .= "</table>";
    }
    
    
    function printRow($style) {
        $row = "<tr class='sensor'>";
        
        if (isset($style['http'])){
            $addressPath = $style['http'];
            $page = $style['page'];
            $row .= "<td><form method='POST' action='".$style['http'].$page."?node=$this->nodeID&child=".$this->getChildID()."'>"
                . $this->getChildID()
                . "<input type='submit' name='submit' value='removeSensor' class='removeSensorButton' />"
             . "</form></td>";
        } else {
            $row .= "<td>".$this->getChildID()."</td>";
        }
        $row .= "<td>".$this->getName()."</td>";
        if($style['details'] == "long"){
            $row .= "<td>".$this->getSType()."</td><td>".$this->getVType()."</td><td>".$this->pinList->printTable($style)."</td><td>".$this->getNote()."</td>";
        }
        $row .= "</tr>";
        return $row;
    }
}
