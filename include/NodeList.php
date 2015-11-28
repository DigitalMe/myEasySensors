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
    private $availNodeIDs = NULL;
    private $db = NULL;
    private $userID = NULL;

    //put your code here
    function __construct($userID){
        $this->nodeList = new SplDoublyLinkedList();
        $this->availNodeIDs = new SplDoublyLinkedList();
        $this->db = new DbHelper();
        $this->userID = $userID;
        for ($index = 1; $index <= 254; $index++) {
            $this->availNodeIDs->push($index);        
        }
        
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
        if(!NULL == ($this->findNode($node))){
            $this->addNode($node);
        }
    }
            
    function addNode($node){
        $this->nodeList->push($node);
        $this->availNodeIDs->rewind();
        while($this->availNodeIDs->current() && $node->getID() != $this->availNodeIDs->current()){
            $this->availNodeIDs->next();
        }
        if($this->availNodeIDs->current()){
            $this->availNodeIDs->shift();
            $this->availNodeIDs->pop();
        }
    }
    
    function removeNode($node){
        $this->availNodeIDs->push($node->getID());
        $this->nodeList->rewind();
        while($this->nodeList->current() && $node != $this->nodeList->current()){
            $this->nodeList->next();
        }
        if($this->nodeList->current()){
            $this->nodeList->pop();
        }
    }
    
    function findNode($node){
        $this->nodeList->rewind();
        while($this->nodeList->valid() && $node->getID() != $this->nodeList->current()->getID()){
            $this->nodeList->next();
        }
        if($this->nodeList->valid()){
            $node = $this->nodeList->current();
            $this->nodeList->rewind();
            return $node;
        }
        return NULL;
    }
    
    function printTable($style){       
        $this->nodeList->rewind();
        $table = "<table class='nodeList'>\n";
        if ($style['headers'] == TRUE){
            $table .= "\t\t\t<tr><th>Node ID</th><th>Node Details</th><th>Notes</th></tr>\n";
        }
        while($this->nodeList->valid()){
            $node = $this->nodeList -> current();
            $table .= "\t\t\t".$node->printRow($style);
            $this->nodeList->next();
        }
        $table .= "\t\t\t<tr><td colspan='2'>"
                . "<form>Node ID:"
                    . "<select>";
        $this->availNodeIDs->rewind();
        while($this->availNodeIDs->valid()){
            $table .= "<option value='".$this->availNodeIDs->current()."'>".$this->availNodeIDs->current()."</option>";
            $this->availNodeIDs->next();
        }

        $table .=     "</select>"
                    . "<textarea rows='3'></textarea>add node"
                . "</form></td><tr>\n";
        $table .="\t\t</table>\n";
        return $table;
    }
}
