<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of pin
 *
 * @author ian
 */
class Pin {
    private $id;
    private $number;
    private $address;
    private $type;
    private $mode;
    //put your code here
    function __construct(){
    }
    
    function setID($id) {
        $this->id = $id;
    }
    
    function getID(){
        return $this->Id;
    }
    
    function setNumber($number){
        $this->number = $number;
    }
    
    function getNumber(){
        return $this->number;
    }
    
    function setAddress($address){
        $this->address = $address;
    }
    
    function getAddress(){
        return $this->address;
    }
    
    function setType($type){
        $this->type = $type;
    }
    
    function getType(){
        return $this->type;
    }
    
    function setMode($mode){
        $this->mode = $mode;
    }
    
    function getMode(){
        return $this->mode;
    }
    
    function printRow($style, $possiblePins){
        var_dump($possiblePins);
        
        foreach ($possiblePins as $key => $value) {
            if ($key == $this->getID()){
                $row .= "<option value='".$value['pinID']."'>".$value['address']."</option>";
            }
            
        }
/*        $row = "<tr class='sensor'>";
        $row .= "<td>".$this->getNumber()."</td>";
        $row .= "<td>".$this->getAddress()."</td>";
        $row .= "<td>".$this->getMode()."</td>";
        $row .= "<td>".$this->getType()."</td>";
        $row .= "</tr>";*/
        return $row;
    }
}
