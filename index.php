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

//$eventsrecords = array(); 
//				foreach($records2 as $r) {
//                    $eventsDataBases = $r->Title . "events"; 
//                    echo $r->Title; 
//                        $eventsDataBases = str_replace(' ', '',$eventsDataBases);  
//
//                    $sql = "SELECT * FROM ".$eventsDataBases."";
//                    $eventresult = $db->query($sql);
//
//                    if ($eventresult->num_rows > 0) {
//                        // output data of each row
//                       
//                        while($eventrow = $eventresult->fetch_assoc()) {
//                            echo "id: " . $eventrow["title"]. " - Name: " . $eventrow["start_event"]. " " . $eventrow["end_event"]. "<br>";
//                        }
//                    } else {
//                        echo "0 results";
//                    }
//
//
//                   }
?>
<!DOCTYPE html>
<html>

<head>
    <title>Crowd Reads</title>
   <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="css/materialize.css" media="screen,projection" />
    <link type="text/css" rel="stylesheet" href="css/main.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>
<link href="https://fonts.googleapis.com/css?family=Muli" rel="stylesheet">

<body class="grey lighten-4">
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="js/materialize.min.js"></script>

    <nav>
        <div class="nav-wrapper" style="background-color: #eee7dd;">
            <a href="index.php" class="brand-logo center"><img class="responsive-img" style="width: 250px;padding-top:11px" src="imgs/CrowdReads_Banner_final.png" /></a>
            <ul id="nav-mobile" class="right hide-on-med-and-down">
                <li><a href="logout.php" style="color: #F678A7;">Log out</a></li>
            </ul>
            <ul id="nav-mobile" class="right hide-on-med-and-down">
                <li><a href="startGroup.php" style="color: #F678A7;">Start your own book group</a></li>
            </ul>
            <ul id="nav-mobile" class="left hide-on-med-and-down">
                <li><a href="discover.php" style="color: #F678A7;">Discover other groups</a></li>
            </ul>

        </div>
    </nav>

<br> 
    <div class="container">
        <div class = "row">
        <div class = "col s6">
        <div class="card-panel" style="padding:20px">
            <h1 class = "card-text">My Groups</h1>
            <?php
			if(!count($records2)) {

				echo 'no teams found'; 
				} else {  
		?>


            <table style="" class="responsive-table ">
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
            </div>
            <div class = "col s6">
                <div class="card-panel" style="padding:20px; ">
                    
                    <h4 class = "card-text">Upcoming Events</h4>
            <?php 
                
                    $eventsrecords = array(); 
				foreach($records2 as $r) {
                    $eventsDataBases = $r->Title . "events"; 
                    echo "<div class = 'card-panel grey lighten-4' >"; 
                    echo "<h5>" . $r->Title . "</h5>"; 
                        $eventsDataBases = str_replace(' ', '',$eventsDataBases);  

                    $sql = "SELECT * FROM ".$eventsDataBases."";
                    $eventresult = $db->query($sql);

                    if ($eventresult->num_rows > 0) {
                        // output data of each row
                       
                        while($eventrow = $eventresult->fetch_assoc()) {
                            echo "<p><div style = 'font-weight:bold'>" . $eventrow["title"]. "  " .  "</div>" . substr($eventrow["end_event"], 0, 11). "</p>";
                        }
                    } else {
                        echo "0 results";
                    }
                    echo "</div>"; 

                   }
                ?> 
                </div>
            </div>
            </div>
            </div>

</body>

</html>