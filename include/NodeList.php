<?php
//include SplDoublyLinkedList;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of nodeList
 *
 * @author ian
 */
include_once '../include/DbHelper.php';
include_once '../include/Node.php';

    
class NodeList {
    
    private $nodeList = NULL;
    private $db = NULL;
    private $userID = NULL;

    //put your code here
    function __construct($userID){
        $this->nodeList = new SplObjectStorage();
        $this->db = new DbHelper();
        $this->userID = $userID;
        
        $results = $this->db -> queryUserNodes($this->userID);
        if(isset($results)){
            foreach ($results as $row){
                $node = new Node($userID, $row["NodeID"]);
                $node ->setNote($row["Note"]);
                $this -> addNode($node);
            }
        }
    }
    
    function createNode($node){
        if(NULL == ($this->findNodeByID($node->getID()))){
            $this->db->insertNode($node);
            $this->addNode($node);
        }
    }
    
    function deleteNode($nodeID) {
        $node = $this->findNodeByID($nodeID);
        $this->removeNode($node);
        $this->db->deleteNode($node);
    }

    function addNode($node){
        $sucess = !$this->nodeList->contains($node);
        if($sucess == TRUE){
            $this->nodeList->attach($node);
        }
        return $sucess;
    }
    
    function removeNode($node){
        $sucess = $this->nodeList->contains($node);
        if($sucess == TRUE){
            $this->nodeList->detach($node);
        }
    }
    
    function findNodeByID($nodeID){
        $this->nodeList->rewind();
        while($this->nodeList->valid() && $nodeID != $this->nodeList->current()->getID()){
            $this->nodeList->next();
        }
        if($this->nodeList->valid()){
            $node = $this->nodeList->current();
            return $node;
        }
        return NULL;
    }
    
    function printTable($style){
        $table = "<table class='nodeList'>\n";
        if ($style['headers'] == TRUE){
            $table .= "\t\t\t<tr><th>Node ID</th><th>Node Details</th><th>Notes</th></tr>\n";
        }
        foreach ($this->nodeList as $node) {
            $table .= "\t\t\t".$node->printRow($style);
        }
        $table .= "\t\t\t<tr><td colspan='2'>"
                . "<form method='POST' action='".$style['http']."nodeList.php'>Node ID:"
                    . "<select name='nodeId'>";
        for ($index = 1; $index <= 254; $index++) {
            if(NULL == ($this->findNodeByID($index))){
                $table .= "<option value='".$index."'>".$index."</option>";
            }
        }
        $table .=     "</select>"
                    . "<textarea name='notes' rows='3'></textarea><input type='submit' name='submit' value='add node'>"
                . "</form></td><tr>\n";
        $table .="\t\t</table>\n";
        return $table;
    }
    
}
