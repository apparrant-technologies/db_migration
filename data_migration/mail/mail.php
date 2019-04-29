<?php


require __DIR__.'/vendor/phpmailer/phpmailer/PHPMailerAutoload.php';
//require 'vendor/autoload.php';

class customMAIL{
	
	public function onbMAIL($user,$pass,$to=array(),$attachmentFile=array(),$cc='saurabhchhabra018@yahoo.com',$subject='ONB',$body='ONB by <b>Saurabh Chhabra</b>',$debug='true',$host='smtp.gmail.com'){
	$mail = new PHPMailer;
	//echo "<pre>";
	$mail->SMTPDebug = 3;                               // Enable verbose debug output

	$mail->isSMTP();                                      // Set mailer to use SMTP
	$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
	$mail->SMTPAuth = true;                               // Enable SMTP authentication
	$mail->Username = $user;                 // SMTP username
	$mail->Password = $pass;                           // SMTP password
	$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
	$mail->Port = 587;                                    // TCP port to connect to

	$mail->setFrom($user,'Saurabh Chhabra');
	//$mail->addAddress('saurabhchhabra018@gmail.com', 'Joe User');     // Add a recipient
	$mail->addAddress($to);               // Name is optional
	$mail->addAddress('');               // Name is optional
	//$mail->addReplyTo('info@example.com', 'Information');
	$mail->addCC($cc);
	//$mail->addBCC('bcc@example.com');

	$mail->addAttachment($attachmentFile);         // Add attachments
	//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
	$mail->isHTML(true);                                  // Set email format to HTML
        
        $mail->ConfirmReadingTo = 'saurabhchhabra018@yahoo.com';

	$mail->Subject = $subject;
	$mail->Body    = $body;
	$mail->AltBody = 'You are Reading as You are non-HTML Client';

	if(!$mail->send()) {
		echo 'Message could not be sent.';
		echo 'Mailer Error: ' . $mail->ErrorInfo;
	} else {
		echo 'Message has been sent';
	}

	}
}