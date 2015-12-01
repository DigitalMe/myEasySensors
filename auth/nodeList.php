<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
    session_start();
    include_once '../php/NodeList.php';
    include_once '../php/Node.php';
    include_once '../php/SensorList.php';
    include_once '../php/Sensor.php';
    
    var_dump($_POST);
    
    $nodeList = new nodeList($_SESSION['USER_ID']);
    
    if(!isset($_SESSION['USER_ID'])){
        header("Location: /myEasySensors/index.php");
        exit;
    }

    function nodeTable($nodeList){
        $removeButton = array("Image"    => "../images/minus.png",
                              "Class"    => "minus",
                              "Listener" => "onClick=(removeNode)");
        $addButton = array("Image"    => "../images/add.png",
                           "Class"    => "add",
                           "Listener" => "onClick=(addNode)");
        
        $style = array("headers" => TRUE,
                       "details" => "short",
                       "http"    => "./",
                       "page"    => "nodeList.php");
        return $nodeList->printTable($style);

    }

    function addNode($nodeID, $note){
        $db = new DB();
        $sql = "INSERT INTO `User_Nodes`(`UserID`, `NodeID`, `Note`) "
             . "VALUES (" . $_SESSION['USER_ID'] . ", $nodeID, $note)";
        $db -> select($sql);
    }

    if(filter_input(INPUT_POST, 'submit')){
        $action = filter_input(INPUT_POST, 'submit');
        $nodeID = filter_input(INPUT_GET, "node");
        switch ($action) {
            case "removeNode":
                $nodeList->deleteNode($nodeID);
                break;
            case "removeSensor":
                $childID = filter_input(INPUT_GET, "child");
                $node = $nodeList->findNodeByID($nodeID);
                if(isset($node)){
                    $node->deleteSensor($childID);
                }
                break;
            case "addNode":
                $node = new Node($_SESSION['USER_ID'], filter_input(INPUT_POST, 'nodeId'));
                $node->setNote(filter_input(INPUT_POST, 'notes'));
                $nodeList->addNode($node);
                break;
            case "addSensor":
                $childID = filter_input(INPUT_POST, "childID");
                $node = $nodeList->findNodeByID($nodeID);
                $sensor = new Sensor($_SESSION['USER_ID'], $nodeID, $childID, filter_input(INPUT_POST, "sensor"));
                $sensor->setNote(filter_input(INPUT_POST, "notes"));
                $node->addSensor($sensor);
                break;
            default:
                break;
        }
    }
    
    $display_block = nodeTable($nodeList);
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" type="text/css" href="../css/myEasySensors.css">
    </head>
    <body>
        <?php
        // put your code here
        echo $display_block;
        ?>
    </body>
</html>
