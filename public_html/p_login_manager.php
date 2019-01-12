<?php
include_once "utility/config.php";
include_once "utility/dbclass.php";
include_once "utility/functions.php";

$objDB = new DB();

$email = loadVariable('email');
$pin = loadVariable('pin');
$type = loadVariable('type');

if($type == 'login'){

    if(!$email || !$pin){
        $_SESSION[ERROR_MSG] = "Please enter both your email and pin.";
		header("location: login");
		exit();
        echo ($email." and pin is: ".$pin);
    }

    $sql = "SELECT pin, UserID FROM `User` WHERE email='".$email."' AND pin= ".$pin;
    $objDB->setQuery($sql);
    $result = $objDB->select();

    if($result){
        $_SESSION[USER_SESSION_VAR] = $result[0]['UserID'];
        setcookie("userID",$rs[0]['userID'],time()+3600*24,'/', '.CorkBoardIt');
        header("location: home");
        exit();
    } else {
        $objDB->close();
        $_SESSION[ERROR_MSG] = "Invalid Email / Pin.";
        header("location: login");
        exit();
    }
}

if($type == 'logout'){
    $objDB->close();
    session_destroy();
    header("location: login");
    exit();
}

?>