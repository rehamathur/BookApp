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


    <div class="container">
        
    </div>
        <div class="container">
            <div class="card-panel" style="padding:20px">
                <h1 class = "card-text">Discover new groups</h1>
                <?php
			if(!count($records)) {

				echo 'no teams found'; 
				} else {  
		?>


                <table style="" class="responsive-table">
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

        </div>
          

</body>

</html>