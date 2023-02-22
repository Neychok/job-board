<?php
require "config.php";
session_start();

class Requests{
    function __construct(){ }
    function connectDB(){
        $conn = mysqli_connect(HOST, USER, PASSWORD, DB_NAME);
        if(!$conn){
            echo("Error connecting");
        }
        mysqli_select_db($conn, DB_NAME) or die(mysqli_error($conn));
        return $conn;
    }
}