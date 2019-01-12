<?php
include_once "utility/config.php";
include_once "utility/dbclass.php";
include_once "utility/functions.php";

$page = loadVariable('path', 'login');

if(!file_exists('includes/'.$page.'.php')){
    $page = "404";
}

include_once "includes/".$page.'.php';

ob_end_flush();

?>