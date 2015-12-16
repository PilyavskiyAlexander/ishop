<?php

	// Include the PHPMailer classes
	// If these are located somewhere else, simply change the path.
	require_once("PHPMailer2/_acp-ml/phpmailer/class.phpmailer.php");
	require_once("PHPMailer2/_acp-ml/phpmailer/class.smtp.php");
	require_once("PHPMailer2/_acp-ml/phpmailer/language/phpmailer.lang-ru.php");
	
	// mostly the same variables as before
	// ($to_name & $from_name are new, $headers was omitted) 
	$to_name = "Саша";
	$to = "pilyavskiy.a@gmail.com";
	$subject = "Mail Test at ".strftime("%T", time());
	$message = "This is a test.";
	$message = wordwrap($message,70);
	$from_name = "Интернет платок";
	$from = "pilyavskiy92@mail.ru";
	
	// PHPMailer's Object-oriented approach
	$mail = new PHPMailer();
	
	// Can use SMTP
	// comment out this section and it will use PHP mail() instead
	$mail->IsSMTP();
	$mail->Host     = "https://mail.ru/";
	$mail->Port     = 25;
	$mail->SMTPAuth = false;
	$mail->Username = "pilyavskiy92@mail.ru";
	$mail->Password = "Kavashi81";
	
	// Could assign strings directly to these, I only used the 
	// former variables to illustrate how similar the two approaches are.
	$mail->FromName = $from_name;
	$mail->From     = $from;
	$mail->AddAddress($to, $to_name);
	$mail->Subject  = $subject;
	$mail->Body     = $message;
	
	$result = $mail->Send();
	echo $result ? 'Sent' : 'Error';
  
?>