<?php
	header('Content-Type: application/json');
	switch($_POST['functionname']) {
		case 'sendEmail':
			require_once('../vendor/phpmailer/phpmailer/src/PHPMailer.php');
			require_once('../vendor/phpmailer/phpmailer/src/Exception.php');
			require_once('../vendor/phpmailer/phpmailer/src/SMTP.php');
			require_once('keys.php');
			try {
				//to joseph.mccarthy@fivestreet.me
				$mail = new PHPMailer\PHPMailer\PHPMailer();
				$mail->IsSMTP();
				$mail->SMTPDebug = 2;
				$mail->SMTPAuth = true;
				$mail->SMTPSecure = 'ssl';
				$mail->Host = "mail.augustassociatesllc.net";
				$mail->Port = 465;
				$mail->IsHTML(false);
				$mail->Username = getUser();
				$mail->Password = getPassword();
				$mail->SetFrom("support@augustassociatesllc.net");
				$mail->FromName = "August Associates LLC";
				$mail->Subject = "Website Form";
				$mail->Body = $_POST['body'];
				$mail->AddAddress("augustassociatesllc@gmail.com");
				$mail->Send();
				echo 'success';
			} catch (phpmailerException $e) {
				echo $e->errorMessage();
			} catch (Exception $e) {
				echo $e->getMessage();
			}
		break;
		case 'getEstimate':
			require_once('keys.php');
			$url = "http://www.zillow.com/webservice/GetSearchResults.htm?zws-id=" . getZillowAPI() . "&address=" . $_POST['address'];
			echo file_get_contents($url);
			break;
		case 'sendCMA':
			require_once('keys.php');
			$url = "https://www.cloudcma.com/cmas/widget?api_key=" . getCmaAPI() . "&name=" . $_POST['sellerName'] . "&email_to=" . $_POST['email'] . "&address=" . $_POST['address'];
			file_get_contents($url);
			echo $url;
			break;
		case 'ipCheck':
			require_once('keys.php');
			echo in_array($_SERVER['REMOTE_ADDR'], getIpAddresses());
			break;
		default:
			echo $_POST['functionname'];
			break;
	}
?>
