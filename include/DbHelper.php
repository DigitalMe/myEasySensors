<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of dbhelper
 *
 * @author z
 */
include_once 'DB.php';

class DbHelper {
    //put your code here
    private static $db;
    
    function __construct(){
        if(!isset(self::$db)){
            self::$db = new DB();
        }
    }   
    
    private function query($sql){
        return self::$db->query($sql);
    }

    private function select($sql) {
        $results = self::$db->select($sql);
        if(!$results){
            $results = NULL;
        }
        return $results;
    }
    
    public function queryUserLogin($userName, $password) {
        $sql = "SELECT * FROM Users "
             . "WHERE email = '$userName' AND "
             . "      password = PASSWORD('$password')";
        return $this->select($sql);
    }
    
    public function queryUserNodes($UserID){
        $sql = "SELECT   NodeID, Note 
                FROM     User_Nodes
                WHERE    UserID   = $UserID
                ORDER BY NodeID";
        return $this->select($sql);
    }
    
    public function queryNodeSensors($UserID, $NodeID){
        $sql = "SELECT ns.ChildID, s.*, sp.PinNumber, p.* "
             . "FROM node_sensors ns "
             . "INNER JOIN sensors s  on ns.SensorID   = s.SensorID "
             . "LEFT JOIN set_pins sp on ns.UserID     = sp.UserID   AND "
                                      . "ns.NodeID     = sp.NodeID   AND "
                                      . "ns.ChildID    = sp.ChildID "
             . "LEFT JOIN pins p      on sp.PinID      = p.PinID "
             . "WHERE ns.UserID = '$UserID'   AND "
                   . "ns.NodeID = '$NodeID' "
             . "ORDER BY ns.ChildID";
        return $this->select($sql);
    }

    public function queryAllSensors(){
        $sql = "SELECT * FROM `sensors`";
        return $this->select($sql);
    }
        
    public function querySensor($UserID, $NodeID, $ChildID){
        $sql = "SELECT ns.ChildID "
             . "FROM node_sensors ns "
             . "INNER JOIN sensors s  on ns.SensorID   = s.SensorID "
             . "WHERE ns.UserID   = '$UserID'   AND "
                   . "ns.NodeID   = '$NodeID'   AND "
                   . "ns.ChildID  = '$ChildID'";
        return $this->select($sql);
    }
    
    public function queryPins($UserID, $NodeID, $ChildID){
        $sql = "SELECT sp.PinNumber, p.*
                FROM set_pins sp
                INNER JOIN pins p on sp.PinID = p.PinID
                WHERE sp.UserID   ='$UserID'   AND
                      sp.NodeID   ='$NodeID'   AND
                      sp.ChildID  ='$ChildID'";
        return $this->select($sql);
    }
    
    public function insertNode($node) {
        $sql = "INSERT INTO `user_nodes`
                VALUES (".$node->getUserID().", ".$node->getID().", '".$node->getNote()."')";
        $this->query($sql);
    }
    
    public function insertSensor($sensor) {
        $sql = "INSERT INTO `node_sensors`
                VALUES (".$sensor->getUserID().   ", "
                         .$sensor->getNodeID().   ", "
                         .$sensor->getID().       ", "
                         .$sensor->getChildID().  ", "
                         ."'".$sensor->getNote().     "')";
        return $this->query($sql);
    }
    
    public function deleteNode($node){
        $sql = "DELETE FROM `user_nodes` 
                WHERE userID = ".$node->getUserID()." AND
                      nodeID = ".$node->getID();
        return $this->query($sql);
    }
    
    public function deleteSensor($sensor){
        $sql = "DELETE FROM `node_sensors` 
                WHERE userID  = ".$sensor->getUserID()." AND
                      nodeID  = ".$sensor->getNodeID()." AND
                      childID = ".$sensor->getChildID(); 
        return $this->query($sql);
    }
    
    public function deleteAllSensorPins($userID, $nodeID, $childID) {
        $sql = "DELETE FROM `set_pins` 
                WHERE userID  = ".$userID." AND
                      nodeID  = ".$nodeID." AND
                      childID = ".$childID;
        return $this->query($sql);    }
    
    public function deletePin($pin, $userID, $nodeID, $childID){
        $sql = "DELETE FROM `set_pins` 
                WHERE userID    = ".$userID."           AND
                      nodeID    = ".$nodeID."           AND
                      childID   = ".$childID."          AND
                      pinNumber = ".$pin->getNumber();
        return $this->query($sql);
    }
}
