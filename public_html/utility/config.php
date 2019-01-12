<?php
/*
Case sensitive table names:
# The MySQL server add the following line to my.ini
[mysqld]
lower_case_table_names = 2
 */
ob_start();

if (!isset($_SESSION)) {
    session_start();
}
ini_set('session.gc_maxlifetime', 480 * 60);
ini_set('session.gc_probability', 1);
ini_set('session.gc_divisor', 1);

// Allow back button without reposting data
header("Cache-Control: private, no-cache, no-store, proxy-revalidate, no-transform");
date_default_timezone_set('America/New_York');

// output errors and messages
ini_set('display_errors', 'on');
error_reporting(E_ALL ^ E_NOTICE);
ini_set("log_errors", 'on');
ini_set("error_log", getcwd() . SEPARATOR ."error.log");

define('NEWLINE',  '<br>' );
define('REFRESH_TIME', 'Refresh: 1; ');

$encodedStr = basename($_SERVER['REQUEST_URI']); 
//convert '%40' to '@'  example: request_friend.php?friendemail=pam@dundermifflin.com
$current_filename = urldecode($encodedStr);
	

define('DB_HOST', "localhost"); //run "docker-machine ip" to get this
define('DB_PORT', "3306");
define('DB_USER', "gatechUser");
define('DB_PASS', "gatech123");
define('DB_SCHEMA', "cs6400_fa18_team039");
define('MYSQL_ASSOC',1);

// $db = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_SCHEMA);

// if (mysqli_connect_errno())
// {
//     echo "Failed to connect to MySQL: " . mysqli_connect_error() . NEWLINE;
//     echo "Running on: ". DB_HOST . ":". DB_PORT . '<br>' . "Username: " . DB_USER . '<br>' . "Password: " . DB_PASS . '<br>' ."Database: " . DB_SCHEMA;
//     phpinfo();   //unsafe, but verbose for learning. 
//     exit();
// }

?>
