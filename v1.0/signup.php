<?php
include("bd_config.php");
echo"aici";
session_start();
echo"aici2";
$error=''; // variabila careia ii asignez mesajele de eroare;
echo"aici3";
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    echo"aici4";
    if (isset($_POST['submit'])) 
    {   echo"aici5";
        if (empty($_POST['nume_introdus']) || empty($_POST['prenume_introdus']) || empty($_POST['username_introdus']) || empty($_POST['email_introdus']) || empty($_POST['parola_introdusa']) || empty($_POST['parola_repetata']) ) 
            {
                $error = "Nu a fost completat unul dintre campuri";
                echo $error;
            }
    }
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
    <title>Inregistrare</title>
</head>
<body>
    <div class ="container" id="container-login">
        <div class="container container-panou-login">
            <ul class="lista-butoane mb-1" type="none">
                <li id="sign-in"> <a href="index.php">SIGN IN </a> </li>
                <li id="sign-up">  <a href="signup.php">SIGN UP </a></li>
            </ul>
            <div class="active-underline"></div> 
            <form action="" method="post" id="input_form" class="form-group">
                <div id="" class="input-block mb-5">
                    <input class="input_value" type="text" name="nume_introdus" placeholder="Nume" spellcheck="false" value="" />
                </div>
                <div id="" class="input-block mb-5">
                    <input class="input_value" type="text" name="prenume_introdus" placeholder="Prenume" spellcheck="false" value="" />
                    <p class="password-text"></p>
                </div>
                <div id="" class="input-block mb-5">
                    <input class="input_value" type="text" name="username_introdus" placeholder="Username" spellcheck="false" value="" />
                    <p class="password-text"></p>
                </div>
                <div id="" class="input-block mb-5">
                    <input class="input_value" type="email" name="email_introdus" placeholder="Email" spellcheck="false" value="" />
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
          
</body>
</html>