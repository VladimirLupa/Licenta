<?php
include("bd_config.php");
error_reporting(0);
session_start();
$_SESSION['error']='';
unset($_SESSION['email_input']); 
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    $_SESSION['email_input'] = $_POST['email_input'];
    if (isset($_POST['submit'])) 
    {  
        if (empty($_POST['email_input'])) 
            {
				$error = "Nu a fost completat emailul";
				$_SESSION['error'] = $error;
            }

        else
            {
                $email = test($_POST['email_input']);
                if(verifyEmail($email) == "true")
                {
                    $userId = UserID($email);
                    $token = generateRandomString();
                    $procedure_input = mysqli_prepare($db,'CALL sp_dezactivare_token(?)');
                    $procedure_input->bind_param('i',  $userId);
                    $procedure_input->execute();
                    // $procedure_input->close(); 
                    $timezone = date_default_timezone_set('Europe/Bucharest');
                    $date = new \DateTime();
                    $date= date_format($date, 'Y-m-d H:i:s');
                    $expiredate = date('Y-m-d H:i:s',strtotime('+3 hours',strtotime($date)));
                    $query = mysqli_query($db, "INSERT INTO RecuperareParola (IdUtilizator, Token, DataActivare, Valid, DataExpirare) VALUES ('$userId', '$token', '$date', 1, '$expiredate')");
                    if (!$query) 
                    {
                        printf("Error: %s\n", mysqli_error($db));
                        exit();
                    }
                    if ($query)
                    {
                        $link = 'localhost/interfata_login/v1.0/forgpass.php?email='.$email.'&token='.$token;
                        $headers  = 'MIME-Version: 1.0' . "\r\n";
                        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                        $message = "<style>
                            input{
                                width:40%;
                                background-color: blue;
                                color:white;
                            }
                            </style>
                        <div class = '' >Hello <br><br>
                        Ati cerut recent resetarea parolei pentru contul dumneavoastra. Click pe butonul de mai jos pentru a o reseta. <br /><br />
                        <div  class='text-center mb-5'>
                            <a href='$link' target='_blank'>
                                <input class='col-sm-12' name='submit' type='submit' value='Confirmare'></a>
                            Daca nu ati cerut resetarea parolei, va rugam ignorati acest mail sau .Acest link pentru resetarea parolei este valabil pentru urmatoarele 3 ore.
                            Va multumim,
	                                Adminul siteului
                        </div>
                        <hr>
                        <div>
                        Daca nu puteti accesa butonul, copiati linkul de mai jos in browserul dumneavoastra.
                        <a href='$link' target='_blank'>localhost/interfata_login/v1.0/forgpass.php?email=$email&token=$token</a></div>";
                        $mail = mail($email, 'Instructiuni recuperare parola', $message,$headers);
                        if ($mail == "TRUE")
                           { 
                                $error = "Un mail cu instructiunile necesare schimbarii parolei a fost trimis pe adresa dumneavoastra.";
                                $_SESSION['error'] = $error ;
                                unset($_SESSION['email_input']);
                           }
                    }//end if ($query)
                }//if(verifyEmail($email) == "true")
                else
                {
                    $error = "Mail introdus gresit";
                    $_SESSION['error'] = $error;
                }
              
            }// end else if (empty($_POST['email_input']))
    }// end if (isset($_POST['submit']))
}//end if ($_SERVER["REQUEST_METHOD"] == "POST") 














function test($data) 
{
    global $db;
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    mysqli_real_escape_string($db, $data);
    return $data;
}

function verifyEmail($email)
{
    global $db;
    $query = mysqli_query($db, "SELECT IdUtilizator FROM Utilizatori WHERE Email = '$email'");

    if(mysqli_num_rows($query) > 0)
        return 'true';
    else
        return 'false';
}



function UserID($email)
{
    global $db;
    $query = mysqli_query($db, "SELECT IdUtilizator FROM Utilizatori WHERE Email = '$email'");
    $row = mysqli_fetch_assoc($query);
    return $row['IdUtilizator'];
}


function generateRandomString($length = 20) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

?>





<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="recover.css">
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <title>Recuperare parola</title>
    </head>
    <body>
        <div class ="container" id="container-login">
            <div class="container container-panou-login">
                <div class = "invisible"></div>
                <div class = "eroare">
                	<span style = "color:red;">
            			<?php
							if(isset($_SESSION['error']) && $_SESSION['error'] !='')
								{ 
                                    echo("*{$_SESSION['error']}");
                                    echo("<script>
                                        $('span').css('color','red');
                                        $('.invisible').css('margin-bottom','30px');
                                        $('.container-panou-login').css('height','410px');
                                    </script>");
                                }
                                
                            if ($_SESSION['error'] == "Un mail cu instructiunile necesare schimbarii parolei a fost trimis pe adresa dumneavoastra.") 
                                {
                                    echo("<script>
                                    $('span').css('color','green');
                                    </script>");
                                }
                                
                        ?>
                         
                        </span>

                <form action="" method="post" id="input_form" class="form-group mb-3">
                    <div id="" class="input-block mb-5">
                        <input class="input_email_value" type="email" name="email_input" placeholder="Email" spellcheck="false" value="<?php echo $_SESSION['email_input'];?>" autofocus />		
                    </div>
                    <div id="" class="text-center mb-5">
                            <input class="col-sm-12" name="submit" type="submit" value="Confirmare">
                        </div>
                </form> 
                <hr>
                <div class="text-center">
                    <a href="index.php" class="link_revenire">Anulare</a>
                </div>
            </div>
        </div>
    </body>
</html>

                
            
                