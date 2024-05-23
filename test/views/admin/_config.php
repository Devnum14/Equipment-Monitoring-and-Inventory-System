<?php

function dbConnection()
{

    //get philippines time zone
    date_default_timezone_set('Asia/Manila');

    // Create connection
    $dbConnection = new PDO('mysql:dbname=smi_database;host=localhost;charset=utf8mb4', 'root', '');

    $dbConnection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return $dbConnection;
    
}


?>