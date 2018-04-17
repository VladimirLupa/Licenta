<?php
include("bd_config.php");
session_start();
$_SESSION['error']  ='';
$email = $_GET['email'];
$token = $_GET['token'];

$userId = UserID($email);
$verifytoken = verifytoken($userId, $token);
$verifydate = expiredate($userId);



if ($_SERVER["REQUEST_METHOD"] == "POST")
   { 
       $new_password = $_POST['new_password'];
       $retype_password = $_POST['retype_password'];
            if(isset($_POST['submit']))
            {
                if (empty($_POST['new_password']) || empty($_POST['retype_password']) )
                     $_SESSION['error'] =  "Unul dintre campuri nu este completat"; 
                else if (!preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).(?=.*[0-9]).{8,16}$/", $_POST['new_password']))
                        {
                        $_SESSION['error'] =  "Parola trebuie sa contina minim 8 caractere din care o litera mare, o litera mica, un caracter special si o cifra"; 
                        //    echo $error;
                        }
                // $valid = mysqli_query($db, "SELECT valid FROM parola_recuperata where idUtilizator = '$userId'");
                else if ($verifytoken == 0 || $verifydate == 0)
                {
                    $_SESSION['error'] =  "Acest token nu mai este valid.";
                    $update_valid = mysqli_query($db, "UPDATE RecuperareParola SET Valid = 0 WHERE IdUtilizator = '$userId' AND Token = '$token'");
                }
                else if($new_password == $retype_password  )
                {
                    $new_password = password_hash($new_password, PASSWORD_DEFAULT);
                    $update_password = mysqli_query($db, "UPDATE Utilizatori SET Parola = '$new_password' WHERE IdUtilizator = '$userId'");
                    $timezone = date_default_timezone_set('Europe/Bucharest');
                    $date = new \DateTime();
                    $date= date_format($date, 'Y-m-d H:i:s');
                    $sql_date = "UPDATE Utilizatori SET DataModificarii ='$date' WHERE IdUtilizator= '$userId'";
                    $query = mysqli_query($db,$sql_date);
                    if($update_password)
                    {
                            header("location: index.php");
                            $_SESSION['error'] = 'Parola schimbata cu succes. Va rugam inregistrati-va cu noua parola.';
                    }
                    $update_valid = mysqli_query($db, "UPDATE RecuperareParola SET Valid = 0 WHERE IdUtilizator = '$userId' AND Token = '$token'");
                }
                else
                {
                    $_SESSION['error'] = "Parolele nu corespund";

                }
                
            }
        }





function UserID($email)
{
    global $db;
    $query = mysqli_query($db, "SELECT IdUtilizator FROM Utilizatori WHERE Email = '$email'");
    $row = mysqli_fetch_assoc($query);
    return $row['IdUtilizator'];
}

function expiredate($userId)
{
    global $db;
    $query = mysqli_query($db, "SELECT DataExpirare FROM RecuperareParola WHERE IdUtilizator = '$userId' AND Valid = 1");

    if (!$query) 
    {
        printf("Error: %s\n", mysqli_error($db));
        exit();
    }
    $obj = mysqli_fetch_object($query);
    $rows = mysqli_num_rows($query);

    $timezone = date_default_timezone_set('Europe/Bucharest');
    $date = new \DateTime();
    $date= date_format($date, 'Y-m-d H:i:s');
    if($rows  > 0)
    {
        if($obj->DataExpirare > $date)
        {
            return 1;
        }
        else
        {
            return 0;
        }

    }
    else
    {
        return 0;
    }
}


function verifytoken($userId, $token)
{	
	global $db;

    $sql = "SELECT Valid FROM RecuperareParola WHERE IdUtilizator = $userId AND Token = '$token'";
    $query = mysqli_query($db,$sql);
    if (!$query) 
    {
        printf("Error: %s\n", mysqli_error($db));
        exit();
    }
    $obj = mysqli_fetch_object($query);
    $rows = mysqli_num_rows($query);
	if($rows  > 0)
	{
		if($obj->Valid == 1)
		{
			return 1;
		}else
		{
			return 0;
		}
	}else
	{
		return 0;
	}
	
}



?>



<html>
	<head>
		
		<title>Schimbare parol&#259;</title>
		
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
		<link rel="stylesheet"  href="forgpass.css">
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	</head>
	<body>
		<div class ="container" id="container-login">
			<div class="container container-panou-login">
				<div class = "eroare">
                	<span style = "color:red;" >
                    
            			<?php
							if(isset($_SESSION['error']) && $_SESSION['error'] !='' && $_SESSION['error'] !='Acest token nu mai este valid.' )
								{
                                     echo("*{$_SESSION['error']}");
                                     echo("<script>
                                    
                                    $('.container-panou-login').css('height','410px');
								</script>");
                                }
                            if ($_SESSION['error'] =='Acest token nu mai este valid.')
                                {
                                    echo("<a style = 'color:red; text-decoration:underline;' href = 'recover.php' > *Acest token nu mai este valid. Apasati aici pentru retrimiterea mailului.</a>");
                                }
						?>
				<form action="" method="post" id="input_form" class="form-group mb-3">
					<div id="" class="input-block mb-5">
						<input class="input_password_value" type="password" name="new_password" placeholder="Parol&#259; nou&#259;" spellcheck="false" value="" autofocus/>
						<!-- <p class="username-text"></p> -->
					</div>

			    	<div id="" class="input-block mb-5">
				    	<input class="input_password_value" type="password" name="retype_password" placeholder="Repetare parol&#259;" spellcheck="false" value="" />
						<!-- <p class="password-text"></p> -->
					</div>
					
					<div id="" class="text-center mb-5">
						<input class="col-sm-12" name="submit" type="submit" value="Confirmare">
					</div>
				</form> 


			</div>
		</div>
	</body>
</html>