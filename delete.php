
<?php

//delete.php
session_start(); 

if(isset($_POST["id"]))
{
//insert.php

$connect = new PDO('mysql:host=localhost;dbname=bookapp', 'root', '');
 $selected_val = $_SESSION['selectedBookGroup'];  // Storing Selected Value In Variable
$eventsTable = $selected_val ."events"; $query = "
 DELETE from ".$eventsTable." WHERE id=:id
 ";
 $statement = $connect->prepare($query);
 $statement->execute(
  array(
   ':id' => $_POST['id']
  )
 );
}

?>
