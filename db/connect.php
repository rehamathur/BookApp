<?php
 	$db = new mysqli('localhost', 'root', '', 'bookapp');

 	if($db->connect_errno) { 
 		die('Sorry we having some connection problems');
 	} 
 ?> 