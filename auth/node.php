<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
    session_start();
    include_once '../include/sensorList.php';
    if(!isset($_SESSION['USER_ID'])){
        header("Location: /myEasySensors/index.php");
        exit;
    }
    $userID = $_SESSION['USER_ID'];
    $nodeID =  filter_input(INPUT_GET, 'node');
    $style = array("headers" => TRUE,
                   "details" => "long",
                   "http"    => "./");
    $sensorList = new sensorList($userID, $nodeID);
    
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        echo $nodeID;
        echo $sensorList->printTable($style);
        // put your code here
        ?>
    </body>
</html>
