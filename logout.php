<?php 

require_once "classes/Db-connection.php";


session_start();

session_unset();
setCookie('cookie_hash', $cookie_hash, time()-1);
session_destroy();

header("Location: index.php");
?>