<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
    session_start();
    include('../include/nodeList.php');
    
    if(!isset($_SESSION['USER_ID'])){
        header("Location: /myEasySensors/index.php");
        exit;
    }

    function nodeTable(){

        $nodeList = new nodeList($_SESSION['USER_ID']);
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
    
    $display_block = nodeTable();
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <style type="text/css">
            table, td, th { color:  blue;
                            border: 1px solid black;
                            text-align: right;}
            img.minus { height: 1em;
                        width:  1em}
    </style>
    </head>
    <body>
        <?php
        // put your code here
        echo $display_block;
        ?>
    </body>
</html>
