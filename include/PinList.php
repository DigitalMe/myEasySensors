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
include_once '../include/DbHelper.php';
include_once '../include/Pin.php';

class PinList {
    //put your code here
    private $pinList = NULL;
    private $db = NULL;
    private $userID = NULL;
    private $nodeID = NULL;
    private $childID = NULL;
 
    function __construct($userID, $nodeID, $childID){
        $this->pinList = new SplDoublyLinkedList();
        $this->db = new dbhelper();
        $this->userID = $userID;
        $this->nodeID = $nodeID;
        $this->childID = $childID;
        $results = $this->db ->queryPins($this->userID, $nodeID, $childID);
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
        }
    }
    
    function addPin($pin){
        $this->pinList->push($pin);
    }
    
    function printTable ($style){
        $this->pinList->rewind();
        $table = "<table class='pinList'>";
        $style['headers'] = FALSE;
        if ($style['headers'] == TRUE){
            $table .= "<tr><th>Adress</th><th>Mode</th><th>Type</th>";
            $table .= "</tr>";
        }
        while($this->pinList->valid()){
            $pin = $this->pinList -> current();
            $table .= $pin->printRow($style);
            $this->pinList->next();
        }
        $table .= "<tr><td colspan='2'>add pin</td></tr>";
        $table .="</table>";
        return $table;
    }
}