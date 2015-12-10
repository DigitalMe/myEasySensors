<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
    include_once './php/DbHelper.php';
    $firstname = "";
    $lastname ="";
    $email ="";
    $password ="";
    $errors ="";
    if(filter_input(INPUT_POST, 'submit')){
        $firstname = filter_input(INPUT_POST, 'firstname');
        $lastname = filter_input(INPUT_POST, 'lastname');
        $email = strtolower(filter_input(INPUT_POST, 'email'));
        $password = filter_input(INPUT_POST, 'password');
        $age = filter_input(INPUT_POST, 'age');
        $gender = filter_input(INPUT_POST, 'gender');
        

        if($firstname==""){
            $errors = $errors . "<p class =\"error\">Missing a first name</p>";}
        if($lastname==""){
            $errors = $errors . "<p class =\"error\">Missing a last name</p>";}
        if($email ==""){
            $errors = $errors . "<p class =\"error\">Missing an email address</p>";
        }else {
            //connect to server and select database
            $db = new dbhelper();
            $result = $db->queryEmail($email);
            if (count($result) > 0){
                $errors = $errors . "<p class =\"error\">Your email address has already been used! Please use a different email address for a new account.</p>";
            }
        }
    }
    
    if(filter_input(INPUT_POST, 'submit') && $errors == ""){
        if(!isset($db)){
            $db = new dbhelper();
        }
        $result = $db->insertUser("", $password, $firstname, $lastname, $email);
        if ($result){
            $display_block = "
                <p>Your new account has been created. Thank you for joining us!</p>
                <p><a href=\"index.php\">Return to login page</a>";
        } else {
            $display_block = "An error occured, contact support.";
        }
        
    } else {
        $display_block = "
            <div><form method =\"POST\" action=\"applyaccount.php\">
                <p>Please enter your information to create an account<p>
                <p>First name</br><input type=\"text\" name=\"firstname\" value=\"$firstname\"></input></p>
                <p>Last name</br><input type=\"text\" name=\"lastname\" value=\"$lastname\"></input></p>
                <p>Email address</br><input type=\"text\" name=\"email\" value=\"$email\"></input></p>
                <p>Password</br><input type=\"password\" name=\"password\" value=\"$password\"></input></p>
                <p><input type=\"submit\" name=\"submit\"></p>
            </form></div>";
    }

?>
<html>
    <head>
        <meta charset="UTF-8">
        <style type="text/css">
            .error{color: red;}
        </style>

        <title></title>
    </head>
    <body>
        <?php
        echo "$display_block";
        echo "$errors";
        ?>
    </body>
</html>
