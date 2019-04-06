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
			 $booktablename = str_replace(' ', '',$Title);  

              
				$sql = "CREATE TABLE ".$booktablename." (
				id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
                title TEXT,
				text TEXT,
                username TEXT,
				dateofpost DATE, 
                chapter INT, 
                page INT
				)";
				if ($db->query($sql) === TRUE) {
				    echo "Table MyGuests created successfully";
				} else {
				    echo "Error creating table: " . $db->error;
				}
					if($insert->execute()) {

						header('Location:index.php'); 
						die(); 
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
        <meta name="viewport" content="width=device-width, initial-scale=1.0" /> </head>
            <link href="https://fonts.googleapis.com/css?family=Muli" rel="stylesheet">
    <body class="grey lighten-4">
        <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script type="text/javascript" src="js/materialize.min.js"></script>
        
        <nav>
    <div class="nav-wrapper blue lighten-2">
      <a href="index.php" class="brand-logo center">Book Group</a>
      <ul id="nav-mobile" class="right hide-on-med-and-down">
                <li><a href="index.php">Home Page</a></li>

      </ul>
    </div>
  </nav>
        <div class ="container"> 
            <div class ="card-panel">
         <h3> Start your own book group</h3>
                <p>Enter your title, author and genre and you'll be all set!</p>
                    <form action="" method="post">
                        <div class="field">
                            <label for "Title">Book Title</label>
                            <input type="text" name="Title" id="Title" autocomplete="off"> </div>
                        <div class="field">
                            <label for "Author">Author</label>
                            <input type="text" name="Author" id="Author" autocomplete="off"> </div>
                        
                         <div class="field">
                            <label for "Genre">Genre</label>
                            <input type="text" name="Genre" id="Genre" autocomplete="off"> </div>
                       
                            <input type="submit" class="blue lighten-2 btn waves-effect waves-light" value="Start Your Group"> </div>
                    </form>
        </div> 
        </div>
        </body>