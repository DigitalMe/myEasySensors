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
    
    private function query($sql) {
        $results = self::$db->select($sql);
        if(!$results){
            $results = NULL;
        }
        return $results;
    }
            
    function __construct(){
        if(!isset(self::$db)){
            self::$db = new DB();
        }
    }
    
    public function queryUserLogin($userName, $password) {
        $sql = "SELECT * FROM Users "
             . "WHERE email = '$userName' AND "
             . "      password = PASSWORD('$password')";
        return $this->query($sql);
    }
    
    public function queryUserNodes($UserID){
        $sql = "SELECT   NodeID, Note 
                FROM     User_Nodes
                WHERE    UserID   = $UserID
                ORDER BY NodeID";
        return $this->query($sql);
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
        return $this->query($sql);
    }
    
    public function querySensor($UserID, $NodeID, $ChildID){
        $sql = "SELECT ns.ChildID "
             . "FROM node_sensors ns "
             . "INNER JOIN sensors s  on ns.SensorID   = s.SensorID "
             . "WHERE ns.UserID   = '$UserID'   AND "
                   . "ns.NodeID   = '$NodeID'   AND "
                   . "ns.ChildID  = '$ChildID'";
        return $this->query($sql);
    }
    
    public function queryPins($UserID, $NodeID, $ChildID){
        $sql = "SELECT sp.PinNumber, p.*
                FROM set_pins sp
                INNER JOIN pins p on sp.PinID = p.PinID
                WHERE sp.UserID   ='$UserID'   AND
                      sp.NodeID   ='$NodeID'   AND
                      sp.ChildID  ='$ChildID'";
        return $this->query($sql);
    }
}
