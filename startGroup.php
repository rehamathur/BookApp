<?php
session_start(); 
	require 'db/connect.php';
$records = array();
	if(!empty($_POST)) {
		if(isset($_POST['Title'],$_POST['Author'],$_POST['Genre'])) {

				$Title = trim($_POST['Title']); 
				$Author = trim($_POST['Author']); 
				$Genre = trim($_POST['Genre']); 
				

                
				
				$insert = $db->prepare("INSERT INTO bookgroups (Title, Author, Genre) VALUES (?,?,?)");
				$insert->bind_param('sss', $Title, $Author, $Genre);
                       
            $booktablename = preg_replace("/[^A-Za-z0-9 ]/", '', $Title);

			 $booktablename = str_replace(' ', '',$booktablename);  
			 $booktablenameevents = $booktablename . "events";  

              
				$sql = "CREATE TABLE ".$booktablename." (
				id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
                title TEXT,
				text TEXT,
                username TEXT,
				dateofpost DATE, 
                chapter INT, 
                page INT
				)";
            
            $sql2 = "CREATE TABLE ".$booktablenameevents." (
			  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `start_event` datetime NOT NULL,
  `end_event` datetime NOT NULL
				)";
            
            
				if ($db->query($sql) === TRUE) {
				    echo "Table MyGuests created successfully";
				} else {
				    echo "Error creating table: " . $db->error;
				}
            if ($db->query($sql2) === TRUE) {
				    echo "Table MyGuests created successfully";
				} else {
				    echo "Error creating table: " . $db->error;
				}
                        $bookgrouptable = $_SESSION['username'] . "groups";

             $insert2 = "INSERT INTO ".$bookgrouptable." (Title, Author, Genre)
                            SELECT * FROM bookgroups 
                            WHERE Title = '$Title'";
            
					if($insert->execute()) {


					}
                         
 	if ($db->query($insert2) === TRUE) {
				    echo "inserted created successfully";
                    header("Location:index.php"); 
                    die(); 
				} else {
				    echo "Error creating table: " . $db->error;
				}
			
			}

	}
?>
   <!DOCTYPE html>
<html>

<head>
    <title>Create a Book Group!</title>
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
        </div>
    </nav>
    <div class="container">
        <div class="card-panel">
            <h3 class = "card-text"> Start your own book group</h3>
            <p style="color: #87BEDF;text-align:center;">Enter your title, author and genre and you'll be all set!</p>
            <form action="" method="post">
                <div class="field">
                    <label for="Title">Book Title</label>
                    <input type="text" name="Title" id="Title" autocomplete="off"> </div>
                <div class="field">
                    <label for="Author">Author</label>
                    <input type="text" name="Author" id="Author" autocomplete="off"> </div>

                <div class="field">
                    <label for="Genre">Genre</label>
                    <input type="text" name="Genre" id="Genre" autocomplete="off"> </div>
                <a>
                    <button type='submit' class='col s12 btn btn-large waves-effect' style="background-color: #87BEDF;">Start Your Group</button>
                </a>
            </form>
        </div>

    </div>
</body>
