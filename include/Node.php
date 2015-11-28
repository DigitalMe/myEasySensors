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
    private $nodeID;
    private $note;
    //put your code here
    
    function __construct($userID, $nodeID){
        $this->nodeID = $nodeID;
        $this->sensorList = new SensorList($userID, $nodeID);
    }
    
    function setNote($note){
        $this->note = $note;
    }
    
    function getID(){
        return $this->nodeID;
    }
    
    function getNote() {
        return $this->note;
    }
    
    function addSensor($sensor){
        $this->sensorList -> push ($sensor);
    }
    
    function removeSensor($sensor){
        $this->sensorList -> rewind();
        while($this->sensorList -> current() && $sensor != $this->sensorList -> current()){
            $this->sensorList -> next();
        }
        if(!$this->sensorList -> current()){
            $this->sensorList -> pop();
        }
    }
    
    function printRow($style) {
           $row = "<tr class='node'>";
           if (isset($style['http'])){
                $addressPath = $style['http'];
                $row .= "<td><a href='".$addressPath."node.php?node=".$this->getID()."'>".$this->getID()."</a></td>";
            } else {
                $row .= "<td>".$this->getID()."</td>";
            }
            $row .= "<td>".$this->sensorList->printTable($style)."</td>";
            $row .= "<td>".$this->getNote()."</td>";
            $row .= "</tr>\n";
            return $row;
    }
}
