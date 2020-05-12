<?php
	if(!$_POST) exit;
	
	//PHP Mailer
	require_once(dirname(__FILE__)."/layout/plugins/phpmailer/PHPMailerAutoload.php");
	
	///////////////////////////////////////////////////////////////////////////

		//Enter name & email address that you want to emails to be sent to.
		
		$toName = "Sena";
		$toAddress = "email@sitename.com";
		
	///////////////////////////////////////////////////////////////////////////
	
	//Only edit below this line if either instructed to do so by the author or have extensive PHP knowledge.
	
	//Form Fields
	$name = trim($_POST["name"]);
	$email = trim($_POST["email"]);
	$phone = trim($_POST["phone"]);
	$message = trim($_POST["message"]);
	
	//Check for empty fields
	if (empty($name) or empty($message)) {
		echo json_encode(array("status" => "error"));
	} else if (empty($email) or !filter_var($email, FILTER_VALIDATE_EMAIL)) {
		echo json_encode(array("status" => "email"));
	} else {		
		//Send message via E-mail
		if(get_magic_quotes_gpc()) {
			$message = stripslashes($message);
		}
		
		$subject = "Contact Support";
		
		$body = "<p>You have been contacted by <b>".$name."</b>. The message is as follows.</p>
						<p>----------</p>
						<p>".preg_replace("/[\r\n]/i", "<br />", $message)."</p>
						<p>----------</p>
						<p>
							E-mail Address: <a href=\"mailto:".$email."\">".$email."</a>
						</p>";
		
		$objmail = new PHPMailer();
		
		//Use this line if you want to use PHP mail() function
		$objmail->IsMail();
		
		//Use the codes below if you want to use SMTP mail
		/*			
		$objmail->IsSMTP();
		$objmail->SMTPAuth = true;
		$objmail->Host = "mail.yourdomain.com";
		$objmail->Port = 587;	//You can remove that line if you don't need to set the SMTP port
		$objmail->Username = "example@yourdomain.com";
		$objmail->Password = "email_address_password";
		*/
		
		$objmail->SetFrom($email, $name);
		$objmail->AddAddress($toAddress, $toName);		
		$objmail->Subject = $subject;
		$objmail->MsgHTML($body);
		
		if($objmail->Send()) {
			echo json_encode(array("status" => "ok"));
		} else {
			echo json_encode(array("status" => "error"));
		}
	}
?>