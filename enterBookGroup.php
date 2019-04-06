<?php 
	require 'db/connect.php';

    session_start(); 

    $title = $_GET['id'];
    
    unset($_SESSION['selectedBookGroup']);
    $_SESSION['selectedBookGroup'] = str_replace(' ', '',$title);  
    $_SESSION['notcleanBookGroup'] = $title; 
    
     header('Location: bookgroup.php')
?> 