
<?php
session_start(); 
//insert.php

$connect = new PDO('mysql:host=localhost;dbname=bookapp', 'root', '');
 $selected_val = $_SESSION['selectedBookGroup'];  // Storing Selected Value In Variable
$eventsTable = $selected_val ."events";
if(isset($_POST["title"]))
{
 $query = "
 INSERT INTO ".$eventsTable." 
 (title, start_event, end_event) 
 VALUES (:title, :start_event, :end_event)
 ";
 $statement = $connect->prepare($query);
 $statement->execute(
  array(
   ':title'  => $_POST['title'],
   ':start_event' => $_POST['start'],
   ':end_event' => $_POST['end']
  )
 );
}


?>
