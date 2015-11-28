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
include_once '../include/PinList.php';

class Sensor {
    private $ID = NULL;
    private $name = NULL;
    private $childID = NULL;
    private $vType = NULL;
    private $sType = NULL;
    private $pinList = NULL;
    private $userID = NULL;
    private $nodeID = NULL;
    
    //put your code here
    function __construct($userID, $nodeID, $childID){
        $this->userID = $userID;
        $this->nodeID = $nodeID;
        $this->childID = $childID;
        $this->pinList = new PinList($userID, $nodeID, $childID);
    }
    
    function setID($ID){
        $this->ID = $ID;
    }
    
    function getID(){
        return $this->ID;
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
    
    function addPin($pin){}
    
    function removePin($pin){}
    
    function printTable($style){
        $table = "<table class='sensor'>";
        $table .= $this->printRow($style);
        $table .= "</table>";
    }
    
    
    function printRow($style) {
        $row = "<tr class='sensor'>";
        
        if (isset($style['http'])){
            $addressPath = $style['http'];
                $row .= "<td><a href='".$addressPath."sensor.php?node=$this->nodeID&child=".$this->getChildID()."'>".$this->getChildID()."</a></td>";
        } else {
            $row .= "<td>".$this->getID()."</td>";
        }
        $row .= "<td>".$this->getName()."</td>";
        if($style['details'] == "long"){
            $row .= "<td>".$this->getSType()."</td><td>".$this->getVType()."</td><td>".$this->pinList->printTable($style)."</td>";
        }
        $row .= "</tr>";
        return $row;
    }
}