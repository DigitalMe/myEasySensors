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
    private $pinNumber;
    private $selectedSensorPinID = -1;
    private $allowedAddresses;
    private $type;
    private $mode;
    //put your code here
    function __construct(){
    }

    function getSelectedSensorPinID() {
        return $this->selectedSensorPinID;
    }

    function setSelectedSensorPinID($selectedSensorPinID) {
        $this->selectedSensorPinID = $selectedSensorPinID;
    }
        
    function setPinNumber($pinNumber){
        $this->pinNumber = $pinNumber;
    }
    
    function getPinNumber(){
        return $this->pinNumber;
    }
    
    function getSelectedAddress(){
        foreach ($this->allowedAddresses as $key => $value) {
            if ($key == $this->selectedSensorPinID){
                return $value;
            }
        }
    }
    
    function addAddress($sensorPinID, $address) {
        $this->allowedAddresses[$sensorPinID] = $address;
    }
    
    function deleteAddress($address) {
        foreach ($this->allowedAddresses as $key => $value) {
            if ($value == $address){
                unset($this->allowedAddresses[$key]);
            }
        }
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
    
    function printRow(){
        $row = "<tr><td><select name='setPin_".$this->pinNumber."'>";
        foreach ($this->allowedAddresses as $sensorPinID => $Address){
            $row .= "<option value='$sensorPinID'".($sensorPinID == $this->selectedSensorPinID?" selected='selected'":"").">$Address</option>";
        }
        $row .= "</select></td><td>$this->mode</td><td>$this->type</td></tr>\n";
        return $row;
    }
}
