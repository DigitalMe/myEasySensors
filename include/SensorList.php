<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of sensorList
 *
 * @author z
 */
include_once '../include/DbHelper.php';
include_once '../include/Sensor.php';

class SensorList {
    //put your code here       
    private $sensorList = NULL;
    private $db = NULL;
    private $userID = NULL;
    private $nodeID = NULL;
 
    function __construct($userID, $nodeID){
        $this->sensorList = new SplObjectStorage();
        $this->db = new dbhelper();
        $this->userID = $userID;
        $this->nodeID = $nodeID;
        
        $results = $this->db -> queryNodeSensors($this->userID, $nodeID);
        if(isset($results)){
            foreach ($results as $row){
                $sensor = new Sensor($userID, $nodeID, $row["ChildID"]);
                $sensor->setID($row["SensorID"]);
                $sensor->setName($row["SensorName"]);
                $sensor->setType($row["VType"], $row["SType"]);
                $this->addSensor($sensor);
            }
        }
    }
    
    function addSensor($sensor){
        $sucess = !$this->sensorList->contains($sensor);
        if($sucess == TRUE){
            $this->sensorList->attach($sensor);
        }
        return $sucess;
    }
    
    function deleteAllSensors() {
        foreach ($this->sensorList as $sensor) {
            $sensor->deleteAllPins();
            $this->sensorList->detach($sensor);
            $this->db->deleteSensor($sensor);   
        }
    }
    
    function deleteSensor($childID) {
        $sucess = FALSE;
        $sensor = $this->findSensorById($childID);
        if (isset($sensor)) {
            $sucess = $this->sensorList->contains($sensor);
            if($sucess == TRUE){
                $sensor->deleteAllPins();
                $this->db->deleteSensor($sensor);            
                $this->sensorList->detach($sensor);
            }
        }
        return $sucess;
    }
    
    function findSensorById($childID) {
        $this->sensorList->rewind();
        while($this->sensorList->valid() && $childID != $this->sensorList->current()->getChildID()){
            $this->sensorList->next();
        }
        if($this->sensorList->valid()){
            $node = $this->sensorList->current();
            return $node;
        }
        return NULL;
    }
    
    function printTable ($style){
        $table = "<table class='sensor'>";
        if ($style['headers'] == TRUE){
            $table .= "<tr><th>Child ID</th><th>Name</th>";
            if($style['details'] == "long") {
                $table .= "<th>Sensor Type</th><th>Value Type</th><th>Pins</th>";
            }
            $table .= "</tr>";
        }
        foreach ($this->sensorList as $sensor) {
            $table .= $sensor->printRow($style, $this->nodeID);
        }
        $table .= "<tr><td colspan='2'>add sensor</td></tr>";
        $table .="</table>";
        return $table;
    }
}
