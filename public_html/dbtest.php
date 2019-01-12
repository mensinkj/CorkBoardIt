<?php
include_once "utility/config.php";
include_once "utility/dbclass.php";

$db = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_SCHEMA);

if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error() . NEWLINE;
    echo "Running on: " . DB_HOST . ":" . DB_PORT . '<br>' . "Username: " . DB_USER . '<br>' . "Password: " . DB_PASS . '<br>' . "Database: " . DB_SCHEMA;
    exit();
} else {
    echo "A connection was established with DB Schema: ".DB_SCHEMA.", see the available tables below<br>";
}

$result = mysqli_query($db, "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE = 'BASE TABLE' AND TABLE_SCHEMA='cs6400_fa18_team043'");

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "Table Name: " . $row["TABLE_NAME"] . "<br>";
        // while ($row2 = mysqli_fetch_assoc(mysqli_query($db, "SELECT COLUMN_NAME from information_schema.columns where table_schema = 'cs6400_fa18_team043'"))){
        //     echo "&nbsp;&nbsp;Column Name: ". $row2["COLUMN_NAME"] . "<br>";
        // }
    }
} else {
    echo "There were not tables!";
}

mysqli_close($db);

?>