
<?php

//update.php

session_start(); 
//insert.php

$connect = new PDO('mysql:host=localhost;dbname=bookapp', 'root', '');
 $selected_val = $_SESSION['selectedBookGroup'];  // Storing Selected Value In Variable
$eventsTable = $selected_val ."events";

if(isset($_POST["id"]))
{
 $query = "
 UPDATE ".$eventsTable." 
 SET title=:title, start_event=:start_event, end_event=:end_event 
 WHERE id=:id
 ";
 $statement = $connect->prepare($query);
 $statement->execute(
  array(
   ':title'  => $_POST['title'],
   ':start_event' => $_POST['start'],
   ':end_event' => $_POST['end'],
   ':id'   => $_POST['id']
  )
 );
}

?>
