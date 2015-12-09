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
        $sql = "SELECT ns.ChildID, ns.Note, s.* "
             . "FROM node_sensors ns "
             . "INNER JOIN sensors s  ON ns.SensorID   = s.SensorID "
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
        $sql = "SELECT DISTINCT ns.*, sp.pinNumber
                FROM node_sensors ns
                LEFT JOIN sensor_pins sp ON ns.SensorID = sp.SensorID
                WHERE ns.UserID  = $UserID  AND
                      ns.NodeID  = $NodeID  AND
                      ns.ChildID = $ChildID";
        return $this->select($sql);
    }
    
    public function querySensorPins($userID, $nodeID, $childID){
        $sql = "SELECT sp.pinNumber, sp.SensorPinID, p.*, IF(IFNULL(setp.SensorPinID, FALSE), TRUE, FALSE) AS SetPin
                FROM node_sensors ns
                INNER JOIN sensor_pins sp ON sp.SensorID    = ns.SensorID
                INNER JOIN pins p         ON sp.PinID       = p.PinID
                LEFT  JOIN set_pins setp  ON ns.UserID      = setp.UserID      AND
                                             ns.NodeID      = setp.NodeID      AND
                                             ns.ChildID     = setp.ChildID     AND
                                             sp.SensorPinID = setp.SensorPinID
                WHERE ns.UserID   = $userID   AND
                      ns.NodeID   = $nodeID   AND
                      ns.ChildID  = $childID
                ORDER BY sp.pinNumber, p.address";
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
                         ."'".$sensor->getNote(). "')";
        return $this->query($sql);
    }
    
    public function updateSensorSetPin($userID, $nodeID, $childID, $newSensorPinID) {
        //first query to see if one or more SensorPinIDs are set for that pinNumber
        //if so delete them
        //add new SensorPinID
        $sql = "SELECT setp.SensorPinID
                FROM node_sensors ns
                INNER JOIN sensor_pins sp ON sp.SensorID    = ns.SensorID
                INNER JOIN set_pins setp  ON ns.UserID      = setp.UserID      AND
                                             ns.NodeID      = setp.NodeID      AND
                                             ns.ChildID     = setp.ChildID     AND
                                             sp.SensorPinID = setp.SensorPinID
                WHERE ns.UserID   = $userID   AND
                      ns.NodeID   = $nodeID   AND
                      ns.ChildID  = $childID
                ORDER BY setp.SensorPinID";
        $result = $this->select($sql);
        if (isset($result)){
            foreach ($result as $row) {
                $sql = "DELETE FROM set_pins
                        WHERE UserID   = $userID   AND
                        NodeID         = $nodeID   AND
                        ChildID        = $childID  AND
                        SensorPinID    = ".$row['SensorPinID'];
                $result = $this->query($sql);
            }
        }
        $sql = "INSERT INTO set_pins VALUES";
        foreach ($newSensorPinID as $pinID){
            $sql .= " ($userID, $nodeID, $childID, $pinID),";
        }
        $sql = substr($sql, 0, strlen($sql)-1);
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
