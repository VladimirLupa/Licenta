<!-- //<?php
// $error = '';

// $name = 'gabriel';

// echo litera_mare($name);

//     function litera_mare($str)
//     {
//         $chr = mb_substr ($str, 0, 1, "UTF-8");
//         $low = mb_strtolower($chr);
//         if ($low == $chr)
//             {
//                 $error = 'Numele trebuie sa inceapa cu litera mare';
//                 return $error; 
//             }
//     }
// ?> -->






<?php

$nume ='as';
$error = '';
$password = 'asd';
if(strlen($password) < 8)
    die('Password must be at least 8 characters');
               
echo $nume; 
echo litere($nume);
if(litere($nume) == 1)
{
    $error = 'eroareeeeeeeeeeeeeeeeeeeeeeee';
}
echo $error;
function litere($str)
{   
    $ok = 0; //varianta corecta, avem numai litere si cuvantul incepe cu litera mare
    $chr = mb_substr ($str, 0, 1, "UTF-8");
    $low = mb_strtolower($chr);
    if ($low == $chr || !preg_match("/^[a-zA-Z]*$/",$str) )
        {
            $ok = 1; //incorect
        }

    return $ok;
}



?>
