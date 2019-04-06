	<?php 
		session_start(); 
		$db = new mysqli('localhost', 'root', '', 'bookapp');

	 	if($db->connect_errno) { 
	 		die('Sorry we having some connection problems');
	 	} 
		$records = array();

    
        $selected_val = $_SESSION['selectedBookGroup'];  // Storing Selected Value In Variable
        $notcleantitle = $_SESSION['notcleanBookGroup'];

		$booktable = strtolower($selected_val);
        

        if($results = $db->query("SELECT * FROM ".$booktable."")) {
			if($results->num_rows) {
				while($row = $results->fetch_object()) { 
					$records[] = $row; 
				}
				$results->free(); 
			}
		}

    if(!empty($_POST)) {
		if(isset($_POST['Title'],$_POST['text'],$_POST['chapter'],$_POST['page'])) {

				$Title = trim($_POST['Title']); 
				$text = trim($_POST['text']); 
				$chapter = trim($_POST['chapter']); 
				$page = trim($_POST['page']); 
                $username = $_SESSION['username']; 
                $date = date('Y-m-d H:i:s');


				
				$insert = $db->prepare("INSERT INTO ".$booktable." (title, text, username, dateofpost, chapter, page) VALUES (?,?,?,?,?,?)");
				$insert->bind_param('ssssii', $Title, $text, $username, $date,$chapter,$page);
			
					if($insert->execute()) {

						header('Location:bookgroup.php'); 
						die(); 
					}
			
			}

	}
       
		
	?> 
	<!DOCTYPE html>
	<html>
	<head>
		<title></title>
        <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <!--Import materialize.css-->
        <link type="text/css" rel="stylesheet" href="css/materialize.css" media="screen,projection" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" /> </head>
            <link href="https://fonts.googleapis.com/css?family=Muli" rel="stylesheet">
    <body class="grey lighten-4">
        <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script type="text/javascript" src="js/materialize.min.js"></script>
        <nav>
            <div class="blue lighten-2 nav-wrapper">
                <a href="competition.php" class="center brand-logo">
                    <?php echo $notcleantitle; ?>
                </a>
                <ul id="nav-mobile" class="right hide-on-med-and-down">
                    <li><a href="index.php">Other groups</a></li>
                </ul>
            </div>
        </nav>
		<div class = "container">
         
            <div class ="card-panel">
			<h3>Posts</h3>
					<?php
						if(!count($records)) {

							echo 'no posts found'; 
							} else {  
					?>
					<table> 
						<thead><tr> 
							<th>Post</th>
							<th>Date</th>
							<th>Chapter</th>
							<th>Page</th>
							<th>Username</th>
                            </tr>
							</thead>
						<tbody>
						<?php
							foreach($records as $r){
														
							?>
							<tr>
								<td><?php echo $r->title; ?></td>
                                
								<td><?php echo $r->dateofpost; ?></td>
								<td><?php echo $r->chapter; ?></td>
								<td><?php echo $r->page; ?></td>
								<td><?php echo $r->username; ?></td>
						
								
							</tr>
							<?php
						}
							?>
						</tbody>	
					</table>
					<?php 
								} 
							?>
                
                <hr>
                 
                    <form action="" method="post">
                         <div class="field">
                            <label for "Title">Title</label>
                            <input type="text" name="Title" id="Title" autocomplete="off"> </div>
                        <div class="field">
                            <label for "text">Text</label>
                            <textarea name="text" id="text"></textarea>
                        </div>
                       <div class="field">
                            <label for "chapter">Chapter</label>
                            <input type="number" name="chapter" id="chapter" autocomplete="off"> </div>
                       <div class="field">
                            <label for "page">Page</label>
                            <input type="number" name="page" id="page" autocomplete="off"> </div>
                        <div class="field">
                
                            <input type="submit" class="blue lighten-2 btn waves-effect waves-light" value="Insert"> </div>
                    </form>
            </div>
            </div>
	</body> 
	</html>
