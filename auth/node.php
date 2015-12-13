<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
    session_start();
    include_once '../php/sensorList.php';
    include_once '../php/sensor.php';
    include_once '../php/pinList.php';
    if(!isset($_SESSION['USER_ID'])){
        header("Location: /myEasySensors/index.php");
        exit;
    }
    $userID = $_SESSION['USER_ID'];
    $nodeID =  filter_input(INPUT_GET, 'node');
    $style = array("headers" => TRUE,
                   "details" => "long",
                   "http"    => "./",
                   "page"    => "node.php");
    $sensorList = new sensorList($userID, $nodeID);
    
    if(filter_input(INPUT_POST, 'submit')){
        $action = filter_input(INPUT_POST, 'submit');
        $nodeID = filter_input(INPUT_GET, "node");
        switch ($action) {
            case "removeSensor":
                $childID = filter_input(INPUT_GET, "child");
                $sensorList->deleteSensor($childID);
                break;
            case "addSensor":
                $childID = filter_input(INPUT_POST, "childID");
                $sensor = new Sensor($_SESSION['USER_ID'], $nodeID, $childID, filter_input(INPUT_POST, "sensor"));
                $sensor->setNote(filter_input(INPUT_POST, "notes"));
                $sensorList->addSensor($sensor);
                header("Location: /myEasySensors/auth/node.php?node=".$nodeID);
                break;
            default:
                break;
        }
    }
//    var_dump(filter_input_array(INPUT_POST));
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" type="text/css" href="../css/myEasySensors.css">
        <script src="../js/pinSettings.js"> </script>
    </head>
    <body>
        <a href="../userlogin.php?logout=true">Log off</a><br>
        <a href="nodeList.php">Back</a><br>
        <?php
        echo "Node: <span id='nodeID'>". $nodeID . "</span>";
        echo $sensorList->printTable($style);
        // put your code here
        ?>
    </body>
</html>
