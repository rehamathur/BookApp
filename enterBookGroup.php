<?php 
	require 'db/connect.php';

    session_start(); 

    $title = $_GET['id'];
    
    unset($_SESSION['selectedBookGroup']);
    $_SESSION['selectedBookGroup'] = str_replace(' ', '',$title);
      $_SESSION['selectedBookGroup'] = preg_replace("/[^A-Za-z0-9 ]/", '', $_SESSION['selectedBookGroup']);

    $_SESSION['notcleanBookGroup'] = $title; 
    
     header('Location: bookgroup.php')
?> 