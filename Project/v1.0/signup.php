<?php
include("bd_config.php");

session_start();


error_reporting(0);
// initializare variabile carora le asignez mesajele de eroare;

// $error = '';
$TREZULTAT = '';
$P2 = '';
$getRecords = '' ;
unset($_SESSION['nume_introdus']);
unset($_SESSION['prenume_introdus']);
unset($_SESSION['username_introdus']);
unset($_SESSION['email_introdus']);
unset($_SESSION['error']);
unset($_SESSION['rasp_baza']);


if ($_SERVER["REQUEST_METHOD"] == "POST") 
{   
    
    $_SESSION['nume_introdus'] = $_POST['nume_introdus'];
    $_SESSION['prenume_introdus'] = $_POST['prenume_introdus'];
    $_SESSION['username_introdus'] = $_POST['username_introdus'];
    $_SESSION['email_introdus'] = $_POST['email_introdus'];


    if (isset($_POST['submit'])) 
    {   

        if (empty($_POST['nume_introdus']) || empty($_POST['prenume_introdus']) || empty($_POST['username_introdus']) || empty($_POST['email_introdus']) || empty($_POST['parola_introdusa']) || empty($_POST['parola_repetata']) ) 
            {
                //$error = "Nu a fost completat unul dintre campuri";
                $_SESSION['error'] = "Nu a fost completat unul dintre campuri"; 
                // echo $error;
            }

        else if (!preg_match("/^[a-zA-Z]*$/", $_POST['nume_introdus']))
            {
                $error = 'Eroare la introducerea numelui';
                $_SESSION['error'] = $error;
                
                // echo $error;                            
            }

        else if (!preg_match("/^[a-zA-Z]*$/", $_POST['prenume_introdus']))
            {   
                $error = 'Eroare la introducerea prenumelui';
                $_SESSION['error'] = $error; 
                // echo $error;
            }

        else if (!filter_var($_POST['email_introdus'], FILTER_VALIDATE_EMAIL))
            {
                $error = 'Eroare la introducerea mailului';
                $_SESSION['error'] = $error; 
                // echo $error;
            }
        else if (!preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).(?=.*[0-9]).{8,16}$/", $_POST['parola_introdusa']))
            {
               $error = 'Parola trebuie sa contina minim 8 caractere din care o litera mare, o litera mica, un caracter special si o cifra'; 
               $_SESSION['error'] = $error; 
            //    echo $error;
            }
        else if ($_POST['parola_introdusa'] != $_POST['parola_repetata'] )
            {
                $error = 'Parola reintrodusa gresit';
                $_SESSION['error'] = $error; 
                // echo $error;
            }
        

   
        else
            {  
                $nume = test($_POST['nume_introdus']);
                // $nume =  TODO STOCARE NUME CORECT 
                $prenume = test($_POST['prenume_introdus']);
                $username = test($_POST['username_introdus']);
                $email = test($_POST['email_introdus']);
                $parola = test($_POST['parola_introdusa']);
                $parola = password_hash($parola, PASSWORD_DEFAULT);
                $procedure_input = mysqli_prepare($db,'CALL sp_adduser(?, ?, ?, ?, ?, @TREZULTAT, @P2)');
                $procedure_input->bind_param('sssss',  $nume, $prenume,  $username, $email, $parola);
                $procedure_input->execute();
                if (!$procedure_input) 
				{
                    printf("Error: %s\n", mysqli_error($db));
                    exit();
                }
                $result = $procedure_input->get_result();
                $row = $result->fetch_array(MYSQLI_NUM);
                $procedure_input->close(); 
                unset($_SESSION['nume_introdus']);
                unset($_SESSION['prenume_introdus']);
                unset($_SESSION['username_introdus']);
                unset($_SESSION['email_introdus']);
                $_SESSION['rasp_baza'] = $row[0];

                
            }
    }      
} 


function test($data) {
    global $db;
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    $data = mysqli_real_escape_string($db,$data);
    return $data;
  }
?>



<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="signup.css">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <title>&#206;nregistrare</title>
</head>
<body>
 
   

    <div class ="container" id="container-login">
        <div class="container container-panou-login">
            <ul class="lista-butoane mb-1" type="none">
                <li id="sign-in"> <a href="index.php">LOGARE </a> </li>
                <li id="sign-up">  <a href="signup.php">&#206;NREGISTRARE </a></li>
            </ul>
            <div class="active-underline mb-2"></div>
            <div class = "eroare">
                <span style = "color:red;">
            <?php
                    if(isset($_SESSION['error']) && $_SESSION['error'] !='')
                        { echo("*{$_SESSION['error']}");
                          
                           echo("<script>
                            $('.container-panou-login').css('height','750px');
                           </script>");
                        }
                        if(isset($_SESSION['rasp_baza']) && $_SESSION['rasp_baza'] !='')
                        {
                            echo("*{$_SESSION['rasp_baza']}");
                            echo("<script>
                            $('.container-panou-login').css('height','750px');
                           </script>");
                        }
                       if ($_SESSION['rasp_baza'] == 'Adaugare cu succes a userului in baza de date'&& $_SESSION['rasp_baza'] !='') 
                       {
                        echo("<script>
                        $('span').css('color','green');
                       </script>");
                       }
                       if ($_SESSION['error'] == 'Parola trebuie sa contina minim 8 caractere din care o litera mare, o litera mica, un caracter special si o cifra'&& $_SESSION['error'] !='') 
                       {
                        echo("<script>
                        $('.container-panou-login').css('height','800px');
                       </script>");
                       }

                ?>
                </span>
            </div> 
            <form action="" method="post" id="input_form" class="form-group">
                <div id="" class="input-block mb-5">
                    <input id = "nume_introdus" class="input_value" type="text" name="nume_introdus" placeholder="Nume" spellcheck="false" value = "<?php echo $_SESSION['nume_introdus'];?>" autofocus />
                </div>
                <div id="" class="input-block mb-5">
                    <input class="input_value" type="text" name="prenume_introdus" placeholder="Prenume" spellcheck="false" value="<?php  echo $_SESSION['prenume_introdus'];?>" />
                    <p class="password-text"></p>
                </div>
                <div id="" class="input-block mb-5">
                    <input class="input_value" type="text" name="username_introdus" placeholder="Username" spellcheck="false" value="<?php echo $_SESSION['username_introdus'];?>" />
                    <p class="password-text"></p>
                </div>
                <div id="" class="input-block mb-5">
                    <input class="input_value" type="email" name="email_introdus" placeholder="Email" spellcheck="false" value="<?php echo $_SESSION['email_introdus'];?>" />
                    <p class="password-text"></p>
                </div>
                <div id="" class="input-block mb-5">
                    <input class="input_value" type="password" name="parola_introdusa" placeholder="Parol&#259;" spellcheck="false" value="" />
                    <p class="password-text"></p>
                </div>
                <div id="" class="parola-repetata input-block mb-5">
                    <input class="input_value" type="password" name="parola_repetata" placeholder="Parol&#259;" spellcheck="false" value="" />
                </div>
                <div id="" class="text-center">
                    <input class="col-sm-12" name="submit" type="submit" value="Adaug&#259;">
                </div>
        </div>
    </div>

          
</body>
</html>