<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function loginForm($handler){
    $html_block ="<form method=\"post\" action=\"$handler\">
    <p><strong>email:</strong><br/>
    <input type=\"text\" name=\"username\"/></p>
    <p><strong>password:</strong><br/>
    <input type=\"password\" name=\"password\"/></p>
    <p><input type=\"submit\" name=\"submit\" value=\"login\"/></p>
    </form>";
    return $html_block;
}