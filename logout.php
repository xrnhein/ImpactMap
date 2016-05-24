<?php
session_start();

if(isset($_SESSION['logged_in']))
{
 header("Location: login.php");
 session_destroy();
 //$_SESSION['user'] = NULL;
 //echo 'session destroyed';
}
else if(!isset($_SESSION['logged_in']))
{
 header("Location: login.php");
}

if(isset($_GET['logout']))
{
 session_destroy();
 unset($_SESSION['logged_in']);
 //set($_SESSION['logged_in']="");
 header("Location: login.php");
}
?>