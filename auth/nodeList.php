<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
    session_start();
    include_once '../include/NodeList.php';
    include_once '../include/Node.php';
    
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
                       "http"    => "./");
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
        if($action == "removeNode"){
            $nodeList->deleteNode(filter_input(INPUT_GET, "node"));
        }
        $node = new Node($_SESSION['USER_ID'], filter_input(INPUT_POST, 'nodeId'));
        $node->setNote(filter_input(INPUT_POST, 'notes'));
        $nodeList->createNode($node);
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
