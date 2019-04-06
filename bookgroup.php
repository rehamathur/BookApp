	<?php 
		session_start(); 
error_reporting(0);
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
            
                $tb = $selected_val . $Title . "comments"; 
                
              $tb = str_replace(' ', '',$tb);  
           $tb = preg_replace("/[^A-Za-z0-9 ]/", '', $tb);
                echo $tb; 
              
				$sql = "CREATE TABLE ".$tb." (
				id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
				text TEXT,
                username TEXT,
				dateofpost DATE 
				)";
				if ($db->query($sql) === TRUE) {
				    echo "Table MyGuests created successfully";
				} else {
				    echo "Error creating table: " . $db->error;
				}
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
  <title>Book Group</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/css/bootstrap.css" />
        
        <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script type="text/javascript" src="js/materialize.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
       <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	    <!--Import materialize.css-->
	    <link type="text/css" rel="stylesheet" href="css/materialize.css" media="screen,projection" />
	    <link type="text/css" rel="stylesheet" href="css/main.css" />
	    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script>
   
  $(document).ready(function() {
   var calendar = $('#calendar').fullCalendar({
    editable:true,
    header:{
     left:'prev,next today',
     center:'title',
     right:'month,agendaWeek,agendaDay'
    },
    events: 'load.php',
    selectable:true,
    selectHelper:true,
    select: function(start, end, allDay)
    {
     var title = prompt("Enter Event Title");
     if(title)
     {
      var start = $.fullCalendar.formatDate(start, "Y-MM-DD HH:mm:ss");
      var end = $.fullCalendar.formatDate(end, "Y-MM-DD HH:mm:ss");
      $.ajax({
       url:"insert.php",
       type:"POST",
       data:{title:title, start:start, end:end},
       success:function()
       {
        calendar.fullCalendar('refetchEvents');
        alert("Added Successfully");
       }
      })
     }
    },
    editable:true,
    eventResize:function(event)
    {
     var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
     var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
     var title = event.title;
     var id = event.id;
     $.ajax({
      url:"update.php",
      type:"POST",
      data:{title:title, start:start, end:end, id:id},
      success:function(){
       calendar.fullCalendar('refetchEvents');
       alert('Event Update');
      }
     })
    },

    eventDrop:function(event)
    {
     var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
     var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
     var title = event.title;
     var id = event.id;
     $.ajax({
      url:"update.php",
      type:"POST",
      data:{title:title, start:start, end:end, id:id},
      success:function()
      {
       calendar.fullCalendar('refetchEvents');
       alert("Event Updated");
      }
     });
    },

    eventClick:function(event)
    {
     if(confirm("Are you sure you want to remove it?"))
     {
      var id = event.id;
      $.ajax({
       url:"delete.php",
       type:"POST",
       data:{id:id},
       success:function()
       {
        calendar.fullCalendar('refetchEvents');
        alert("Event Removed");
       }
      })
     }
    },

   });
  });
   
  </script>
        
        
        

    
 </head>
            <link href="https://fonts.googleapis.com/css?family=Muli" rel="stylesheet">
        
        
    <body class="grey lighten-4">
       <nav>
	        <div class="nav-wrapper" style="background-color: #eee7dd;">
	            <a href="index.php" class="brand-logo center"><img class="responsive-img" style="width: 250px;padding-top:0px" src="imgs/CrowdReads_Banner_final.png" /></a>
	            <ul id="nav-mobile" class="right hide-on-med-and-down">
	                <li><a href="logout.php" style="color: #F678A7;">Log out</a></li>
	            </ul>
                  <ul id="nav-mobile" class="left hide-on-med-and-down">
                <li><a href="discover.php" style="color: #F678A7;">Discover other groups</a></li>
            </ul>

	        </div>
	    </nav>
         <div class="container">
	        <div class="card-panel">
	            <h2 class="card-text">
	                <?php echo $notcleantitle; ?>
	            </h2>
	        </div>
	    </div>
		<div class = "container">
         
            <div class ="card-panel">
			<h3 class = "card-text">Posts</h3>
					<?php
						if(!count($records)) {

							echo 'There are currently no posts.'; 
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
                                
                                  
                                <td><?php echo "<a href='post.php?id=".$r->title."'>".$r->title."</a>"?></td> 
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
                
                             <button type='submit' class='col s12 btn btn-large waves-effect' style="background-color: #87BEDF;">Post</button>
                        </div>
                    </form>
                <br> 
               
            </div>
            
              <div class="card-panel">
                  <h1 class="card-text">Calendar</h1>
              <div id="calendar"></div>
            </div>
            </div>
         
        
    
        
	</body> 
	</html>
