<?php
    session_start(); 
	require 'db/connect.php';
    error_reporting(0);
	if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
	if($results = $db->query("SELECT * FROM bookgroups")) {
		if($results->num_rows) {
			while($row = $results->fetch_object()) { 
				$records[] = $row; 
			}
			$results->free(); 
		}
	}

  $bookgrouptable = $_SESSION['username'] . "groups";

	if($results2 = $db->query("SELECT * FROM " .$bookgrouptable)) {
		if($results2->num_rows) {
			while($row2 = $results2->fetch_object()) { 
				$records2[] = $row2; 
			}
			$results2->free(); 
		}
	}



//if(isset($_POST['submitconference'])) {
//    
//    $number = $_POST['teamNumber']; 
//    $sql = "SELECT Password FROM teams WHERE Number='$number' limit 1";
//    $result = $db->query($sql);
//    $value = mysqli_fetch_object($result);
//    $Password = $value->Password;
//    $submittedPassword = $_POST['teamPassword']; 
//    if ($submittedPassword == $Password) {  
//        unset($_SESSION['conference']);
//        $_SESSION['conference'] = str_replace(' ', '',$_POST['teamNumber']);  
//        header('Location: competition.php');
//        
//        }
//    else { 
//        echo "Incorrect PAssword"; 
//    }
//}
//$conference = $_SESSION['conference'];

?>
    <!DOCTYPE html>
    <html>

    <head>
        <title>bOOK aPP</title>
        <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <!--Import materialize.css-->
        <link type="text/css" rel="stylesheet" href="css/materialize.css" media="screen,projection" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" /> </head>
            <link href="https://fonts.googleapis.com/css?family=Muli" rel="stylesheet">
    <body class="grey lighten-4">
        <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script type="text/javascript" src="js/materialize.min.js"></script>
      
  <nav>
    <div class="nav-wrapper blue lighten-2">
      <a href="index.php" class="brand-logo center">Books</a>
      <ul id="nav-mobile" class="right hide-on-med-and-down">
                <li><a href="startGroup.php">Start your own book group</a></li>

      </ul>
    </div>
  </nav>
        
             
     <div class = "container">    <div class="card-panel" style="padding:20px"> <h1>My Groups</h1>
            <?php
			if(!count($records2)) {

				echo 'no teams found'; 
				} else {  
		?>
         
      
                <table style = "" class="responsive-table striped">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Genre</th>
                            <th></th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php
				foreach($records2 as $r){
				?>
                            <tr>
                                <td>
                                    <?php echo $r->Title; ?>
                                </td>
                                <td>
                                    <?php echo $r->Author; ?>
                                </td>
                                <td>
                                    <?php echo $r->Genre; ?>
                                </td>
                                <td>
                                    <?php echo "<td><a href='enterBookGroup.php?id=".$r->Title."'>Enter</a></td>"?>
                                </td>
                               
                            </tr>
                            <?php
			}
				?>
                    </tbody>
                </table>
                <?php 
					} 
				?>
         </div> 
  <div class = "container">    <div class="card-panel" style="padding:20px"> <h1>All Groups</h1>
            <?php
			if(!count($records)) {

				echo 'no teams found'; 
				} else {  
		?>
         
      
                <table style = "" class="responsive-table striped">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Genre</th>
                            <th></th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php
				foreach($records as $r){
				?>
                            <tr>
                                <td>
                                    <?php echo $r->Title; ?>
                                </td>
                                <td>
                                    <?php echo $r->Author; ?>
                                </td>
                                <td>
                                    <?php echo $r->Genre; ?>
                                </td>
                                <td>
                                    <?php echo "<td><a href='joinBookGroup.php?id=".$r->Title."'>Join Group</a></td>"?>
                                </td>
                               
                            </tr>
                            <?php
			}
				?>
                    </tbody>
                </table>
                <?php 
					} 
				?>
         </div> 


    </body>

    </html>