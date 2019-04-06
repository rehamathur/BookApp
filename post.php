<?php 
require 'db/connect.php';
session_start(); 


 $title = $_GET['id'];
     $title = preg_replace("/[^A-Za-z0-9 ]/", '', $title);
$selected_val = $_SESSION['selectedBookGroup']; 
$getPost = " SELECT * FROM ".$selected_val." WHERE title = '$title'";

$sql = "SELECT * FROM ".$selected_val." WHERE title='$title' limit 1";
$result = $db->query($sql);
$value = mysqli_fetch_object($result);

	$records = array();

    
$commentsTable = $selected_val . $title . "comments"; 
$commentsTable = str_replace(' ', '',$commentsTable);  


        if($results = $db->query("SELECT * FROM ".$commentsTable."")) {
			if($results->num_rows) {
				while($row = $results->fetch_object()) { 
					$records[] = $row; 
				}
				$results->free(); 
			}
		}


 if(!empty($_POST)) {
		if(isset($_POST['text'])) {

			
				$text = trim($_POST['text']); 
				
                $username = $_SESSION['username']; 
                $date = date('Y-m-d H:i:s');


				
				$insert = $db->prepare("INSERT INTO ".$commentsTable." (text, username, dateofpost) VALUES (?,?,?)");
				$insert->bind_param('sss', $text, $username, $date);
            
              
					if($insert->execute()) {

						header('Location:post.php?id='.$title.''); 
						die(); 
					}
            
           
			
			
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
              <ul id="nav-mobile" class="left hide-on-med-and-down">
                <li><a href="discover.php" style="color: #F678A7;">Discover other groups</a></li>
            </ul>

        </div>
    </nav>


    <div class="container">
        <div class="card-panel" style="padding:20px">

            <h3 class="card-text">
                <?php echo $value->title ?>
            </h3>
            <p style="color:#87bedf;text-align:center;">by
                <?php echo $value->username ?> | on
                <?php echo $value->dateofpost ?> | from
                <?php echo $value->chapter ?>:
                <?php echo $value->page ?>
            </p>

            <p>
                <?php echo $value->text ?>
            </p>

        </div>
    </div>
    <div class="container">
        <div class="card-panel" style="padding:20px">
            <h4>Comments</h4>
            <?php
						if(!count($records)) {

							echo 'No comments.'; 
							} else {  
					?>

            <?php
							foreach($records as $r){
														
							?>

            <div class="card-panel grey lighten-4" style="padding:20px">
                <h5>
                    <?php echo $r->username; ?>
                </h5>
                <p>
                    <?php echo $r->dateofpost; ?>
                </p>
                <p>
                    <?php echo $r->text; ?>
                </p>


            </div>





            <?php
						}
							
								} 
							?>
        </div>
    </div>


    <div class="container">
        <div class="card-panel" style="padding:20px">

            <form action="" method="post">
                <div class="field">

                    <label for="text">Comment</label>
                    <textarea name="text" id="text"></textarea>
                </div>
                <div class="field">
                    <button type='submit' class='col s12 btn btn-large waves-effect' style="background-color: #87BEDF;">Comment</button>
                </div>
            </form>

        </div>
    </div>



</body>

</html>
