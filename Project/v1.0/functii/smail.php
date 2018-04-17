<?php
 $recipient="username@localhost";
 $subject="Test Email";
 $mail_body="Nobody is going to get this email but me.";
 $headers =  'MIME-Version: 1.0' . "\r\n"; 
$headers .= 'From: Your name <lupa_vladimir96@yahoo.com>' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n"; 
 mail($recipient, $subject, $mail_body,$headers);
 ?>