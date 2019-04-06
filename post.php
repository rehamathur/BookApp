<?php 
require 'db/connect.php';
session_start(); 


 $title = $_GET['id'];
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
    <title>bOOK aPP</title>
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="css/materialize.css" media="screen,projection" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>
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


    <div class="container">
        <div class="card-panel" style="padding:20px">

            <h1>
                <?php echo $value->title ?>
            </h1>
            <p>by
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

							echo 'no comments found'; 
							} else {  
					?>

            <?php
							foreach($records as $r){
														
							?>

            <div class="card-panel" style="padding:20px">
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

                    <label for "text">Text</label>
                    <textarea name="text" id="text"></textarea>
                </div>
                <div class="field">
                    <input type="submit" class="blue lighten-2 btn waves-effect waves-light" value="Insert"> </div>
            </form>

        </div>
    </div>



</body>

</html>