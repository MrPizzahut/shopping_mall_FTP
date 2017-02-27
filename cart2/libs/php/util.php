<?php
class Util{

	public function sendEmailViaPhpMail($from_name, $from_email, $send_to_email, $subject, $body){

		$headers  = "MIME-Version: 1.0\r\n";
		$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
		$headers .= "From: {$from_name} <{$from_email}> \n";

		if(mail($send_to_email, $subject, $body, $headers)){
			return true;
		}else{
			echo "<pre>";
				print_r(error_get_last());
			echo "</pre>";
		}

		return false;

	}
}
?>
