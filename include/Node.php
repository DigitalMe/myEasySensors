<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of node
 *
 * @author ian
 */
include_once '../include/SensorList.php';

class Node {
    private $sensorList = NULL;
    private $userID;
    private $nodeID;
    private $note;
    //put your code here
    
    function __construct($userID, $nodeID){
        $this->nodeID = $nodeID;
        $this->userID = $userID;
        $this->sensorList = new SensorList($userID, $nodeID);
    }
    
    function getUserID() {
        return $this->userID;
    }

    function setNote($note){
        $this->note = $note;
    }
    
    function getNote() {
        return $this->note;
    }
    
    function getID(){
        return $this->nodeID;
    }
    
    function deleteAllSensors() {
        $this->sensorList->deleteAllSensors();
    }
    
    function deleteSensor($childID) {
        $this->sensorList->deleteSensor($childID);
    }
    
    function addSensor($sensor){
        $this->sensorList -> push ($sensor);
    }
    
    function removeSensor($sensor){
        $this->sensorList->removeSensor($sensor);
    }
    
    function findSensorById($sensorID) {
        $this->sensorList->findSensorById($sensorID);
    }
    
    function printRow($style) {
           $row = "<tr class='node'>";
           if (isset($style['http'])){
                $addressPath = $style['http'];
                $page = $style['page'];
                $row .= "<td><form method='POST' action='".$style['http'].$page."?node=".$this->getID()."'>"
                            . "<a href='".$addressPath."node.php?node=".$this->getID()."'>".$this->getID()."</a>"
                            . "<input type='submit' name='submit' value='removeNode' class='removeNodeButton' />"
                        . "</form></td>";
            } else {
                $row .= "<td>".$this->getID()."</td>";
            }
            $row .= "<td>".$this->sensorList->printTable($style)."</td>";
            $row .= "<td>".$this->getNote()."</td>";
            $row .= "</tr>\n";
            return $row;
    }
}
