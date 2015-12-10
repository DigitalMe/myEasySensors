<?php
    session_start();
    include('php/dbhelper.php');
    if (!filter_input(INPUT_POST, 'submit') || filter_input(INPUT_GET, "logout") == "true") { //if they didn't come from the login page
    	session_unset();
        session_destroy(); 
        header("Location: index.php");
	exit;
    }
    $db = new dbhelper();
    $userName = filter_input(INPUT_POST, 'username');
    $password = filter_input(INPUT_POST, 'password');
    $rows = $db ->queryUserLogin($userName, $password);
    
    if (count($rows) == 1) {
        $cookie_name = "SID";
        $cookie_value = htmlspecialchars(SID);
        setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 
        $_SESSION['USER_ID'] = $rows[0]["UserID"];
        $_SESSION['USER_NAME'] = $rows[0]["UserName"];
        $_SESSION['USER_F_NAME'] = $rows[0]["FirstName"];
        $_SESSION['USER_L_NAME'] = $rows[0]["LastName"];
        var_dump($_SESSION);
        header("Location: auth/nodeList.php");
    } else {
        header("Location: index.php");
    }
    
