<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
    include("loginForm.php");
    $display_block = loginForm("userlogin.php");


?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>test</title>
    </head>
    <body>
        <?php
        // put your code here
            echo $display_block;
        ?>
        <a href="applyaccount.php">Sign Up</a>
    </body>
</html>
