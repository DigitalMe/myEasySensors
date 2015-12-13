<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();
include_once '../php/DbHelper.php';

function updateSensorSetPin($filteredInput){
    $db = new DbHelper();
    foreach ($filteredInput as $key => $value) {
        if (strpos($key, "setPin") !== FALSE){
            $newSensorPinID[] = $value;
        }
    }
    if (isset($newSensorPinID)){
        $db->updateSensorSetPin($_SESSION['USER_ID'], $filteredInput["nodeID"], $filteredInput["childID"], $newSensorPinID);
        return "Saved";
    } else {
        return "No pins to set";
    }
}

if(isset($_SESSION['USER_ID'])){
    $filteredInput = filter_input_array(INPUT_POST);
    if(isset( $filteredInput )) {
        if(isset($filteredInput['func'])){
            switch ($filteredInput['func']) {
                case "savePinSettings":
                    $result = updateSensorSetPin($filteredInput);
                    break;

                default:
                    $result = "Invalid function";
                    break;
            }
        } else {
            $result = "No function set";
        }
        echo $result;
    }
}

