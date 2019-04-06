<?php
// Include config file
require_once "db/connect.php";
 
// Define variables and initialize with empty values
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = ?";
        
        if($stmt = $db->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // store result
                $stmt->store_result();
                
                if($stmt->num_rows == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        $stmt->close();
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have at least 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Passwords did not match.";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
         
        if($stmt = $db->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("ss", $param_username, $param_password);
            
            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Redirect to login page
                header("location: login.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        $stmt->close();
        
         $tbname = $username . "groups";
    $createGroups = "CREATE TABLE ".$tbname." (
				id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
				Title TEXT,
				Author TEXT,
				Genre TEXT
				)";
				if ($db->query($createGroups) === TRUE) {
				    echo "Groups created successfully";
				} else {
				    echo "Error creating table: " . $db->error;
				}
    }
   
    // Close connection
    $db->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link type="text/css" rel="stylesheet" href="css/materialize.css" media="screen,projection" />
    <link type="text/css" rel="stylesheet" href="css/main.css" />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans|Source+Sans+Pro" rel="stylesheet">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.5/js/materialize.min.js"></script>

</head>

<body>
    <!--
    <div class="wrapper">
        <h2>Sign Up</h2>
        <p>Please fill this form to create an account.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
                <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                    <label>Confirm Password</label>
                    <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                    <span class="help-block"><?php echo $confirm_password_err; ?></span>
                </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>
            <p>Already have an account? <a href="login.php">Login here</a>.</p>
        </form>
    </div>    
-->

    <main>
        <center>
            <nav>
                <div class="nav-wrapper" style="background-color: #eee7dd;">
                    <a href="index.php" class="brand-logo center"><img class="responsive-img" style="width: 250px;" src="imgs/CrowdReads_Banner_final.png" /></a>
                    <ul id="nav-mobile" class="right hide-on-med-and-down" style="color: #F678A7;">
                        <li><a href="login.php">Log in</a></li>
                    </ul>
                </div>
            </nav>



            <h4 style="font-family: 'Source Sans Pro', sans-serif;">Sign up!</h4>
            

            <div class="container">
                <div class="z-depth-1 grey lighten-4 row" style="display: inline-block; padding: 32px 48px 0px 48px; border: 1px solid #EEE;">

                    <form class="col s12" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class='row'>
                            <div class='col s12'>
                            </div>
                        </div>

                        <div class='row'>
                            <div class='input-field col s12' class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                                <input class='validate' type='text' name='username' id='username' value="<?php echo $username; ?>"/>
                                <label for='username'>Enter your username</label>
                                <span style="color: #F678A7; font-family: 'Source Sans Pro', sans-serif;" class="help-block"><b><?php echo $username_err; ?></b></span>
                            </div>
                        </div>

                        <div class='row'>
                            <div class='input-field col s12' class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                                <input class='validate' type='password' name='password' id='password' value="<?php echo $password; ?>"/>
                                <label for='password'>Enter your password</label>
                                <span style="color: #F678A7; font-family: 'Source Sans Pro', sans-serif;" class="help-block"><b><?php echo $password_err; ?></b></span>
                            </div>
                            <label style='float: right;'>
                                <b style='color: #f678a7;'>Make sure your password has at least 6 characters!</b>
                            </label>
                        </div>
                        
                        <div class='row'>
                            <div class='input-field col s12' class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                                <input class='validate' type='password' name='confirm_password' id='password' value="<?php echo $confirm_password; ?>"/>
                                <label for='password'>Confirm your password</label>
                                <span style="color: #F678A7; font-family: 'Source Sans Pro', sans-serif;" class="help-block"><b><?php echo $confirm_password_err; ?></b></span>
                            </div>
                        </div>
                        
                        
                        
                        <center>
                            <div class='row'>
                                <button type='submit' name='btn_login' class='col s12 btn btn-large waves-effect ' style="background-color: #87BEDF;">Sign Up!</button>
                            </div>
                        </center>
                    </form>
                </div>
            </div>
        </center>
    </main>
</body>

</html>
