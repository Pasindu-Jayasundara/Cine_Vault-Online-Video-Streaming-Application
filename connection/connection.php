<?php

class Database{

public static $db_connection;

public static function setUpConnection(){

    if(!isset(Database::$db_connection)){
        Database::$db_connection = new mysqli("localhost","root","Pasindu328@Bhathiya","cine_vault","3306");
    }

}

public static function iud($q){

    Database::setUpConnection();
    Database::$db_connection->query($q);

}

public static function search($q){

    Database::setUpConnection();
    $resultset = Database::$db_connection->query($q);
    return $resultset;

}

}

?>