<?php

//load.php
session_start(); 
//insert.php

$connect = new PDO('mysql:host=localhost;dbname=bookapp', 'root', '');
 $selected_val = $_SESSION['selectedBookGroup'];  // Storing Selected Value In Variable
$eventsTable = $selected_val ."events";

$data = array();

$query = "SELECT * FROM ".$eventsTable." ORDER BY id";

$statement = $connect->prepare($query);

$statement->execute();

$result = $statement->fetchAll();

foreach($result as $row)
{
 $data[] = array(
  'id'   => $row["id"],
  'title'   => $row["title"],
  'start'   => $row["start_event"],
  'end'   => $row["end_event"]
 );
}

echo json_encode($data);

?>
