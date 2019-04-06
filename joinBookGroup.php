<?php 
	require 'db/connect.php';

    session_start(); 

    $title = $_GET['id'];
    
    unset($_SESSION['selectedBookGroup']);
    $_SESSION['selectedBookGroup'] = str_replace(' ', '',$title);  
    $bookgrouptable = $_SESSION['username'] . "groups";
    $_SESSION['notcleanBookGroup'] = $title; 

    strtolower($bookgrouptable);
    
    echo $bookgrouptable; 
    echo $title; 
    
                        
    $insert = "INSERT INTO ".$bookgrouptable." (Title, Author, Genre)
                            SELECT * FROM bookgroups 
                            WHERE Title = '$title'";

                    
 	if ($db->query($insert) === TRUE) {
				    echo "inserted created successfully";
				} else {
				    echo "Error creating table: " . $db->error;
				}
     header('Location: bookgroup.php')
?> 