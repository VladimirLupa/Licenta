<?php
include("bd_config.php");
error_reporting(0);
session_start();
$error = ''; // variabila careia ii asignez mesajele de eroare;
$_SESSION['error'] = '';
unset($_SESSION['username_input']); 
if(isset($_SESSION['login_user'])) 
{
	header("location: asd.php"); // Redirecting To Other Page
}
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
	$_SESSION['username_input'] = $_POST['username_input'];
    if (isset($_POST['submit'])) 
    {  
        if (empty($_POST['username_input']) || empty($_POST['password_input'])) 
            {
				$error = "Nu a fost completat unul dintre campuri";
				$_SESSION['error'] = $error;
            }
        else
            {
                $username=$_POST['username_input'];
                $password=$_POST['password_input'];
                //$str = "Is your name O\'reilly?";
                // Outputs: Is your name O'reilly? taie slashurile
                $username = stripslashes($username);
                $password = stripslashes($password);
                //Escapes special characters in a string for use in an SQL statement
                $username = mysqli_real_escape_string($db,$username);
                $password = mysqli_real_escape_string($db,$password);
                $sql = "SELECT NumeUtilizator, Parola FROM Utilizatori WHERE NumeUtilizator = '$username'";
                $query = mysqli_query($db,$sql);
				if (!$query) 
				{
                    printf("Error: %s\n", mysqli_error($db));
                    exit();
                }
				$obj = mysqli_fetch_object($query);
				// $verify = ;
				$rows = mysqli_num_rows($query);
				if ($rows == 1 && password_verify($password, $obj->Parola))
				{
					$_SESSION['login_user']=$username; // Initializing Session
					$_SESSION['color']='red';
					$timezone = date_default_timezone_set('Europe/Bucharest');
					$date = new \DateTime();
					$date= date_format($date, 'Y-m-d H:i:s');
					$sql_date = "UPDATE Utilizatori SET DataUltimaLogare ='$date' WHERE NumeUtilizator= '$username'";
					$query = mysqli_query($db,$sql_date);
					header("location: asd.php"); // Redirecting To Other Page
				}
				else 
				{
					$error = "Unul dintre campuri este invalid";
					$_SESSION['error'] = $error;
				}
				mysqli_close($db); // Closing Connection               
            }//end of else
    }//end of if (isset($_POST['submit'])) 
}// end of if ($_SERVER["REQUEST_METHOD"] == "POST") 

?>



<html>
	<head>
		
		<title>Logare</title>
		
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
		<link rel="stylesheet"  href="css/logare.css">
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	</head>
	<body>
		<div class ="container" id="container-login">
			<div class="container container-panou-login">
				<ul class="lista-butoane" type="none">
					<li id="sign-in"><a href="index.php">LOGARE</a></li>
					<li id="sign-up">  <a href="pagini/signup.php">&#206;NREGISTRARE </a></li>
				</ul>
				<div class="active-underline"></div> 
				<div class = "eroare">
                	<span style = "color:red;">
            			<?php
							if(isset($_SESSION['error']) && $_SESSION['error'] !='')
								{ 
									echo("*{$_SESSION['error']}");
								}
						?>
					</span>
				</div>
				<form action="" method="post" id="input_form" class="form-group mb-3">
					<div id="" class="input-block mb-5">
						<input class="input_username_value" type="text" name="username_input" placeholder="Username" spellcheck="false" value="<?php echo $_SESSION['username_input'];?>" autofocus/>
						<!-- <p class="username-text"></p> -->
					</div>

			    	<div id="" class="input-block mb-5">
				    	<input class="input_password_value" type="password" name="password_input" placeholder="Parol&#259;" spellcheck="false" value="" />
						<!-- <p class="password-text"></p> -->
					</div>
					
					<div id="" class="text-center mb-5">
						<input class="col-sm-12" name="submit" type="submit" value="Logare">
					</div>
				</form> 
				<hr>
				<div class="text-center">
					<a href="pagini/recover.php" class="link_recup">Recuperare parol&#259;</a>
				</div>

			</div>
		</div>
	</body>
</html>
