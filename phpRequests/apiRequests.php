<?php
	header('Content-Type: application/json');
	switch($_POST['functionname']) {
		case 'sendEmail':
			require_once('../vendor/phpmailer/phpmailer/src/PHPMailer.php');
			require_once('../vendor/phpmailer/phpmailer/src/Exception.php');
			require_once('../vendor/phpmailer/phpmailer/src/SMTP.php');
			require_once('keys.php');
			try {
				$mail = new PHPMailer\PHPMailer\PHPMailer();
				$mail->IsSMTP();
				$mail->SMTPDebug = 2;
				$mail->SMTPAuth = true;
				$mail->SMTPSecure = 'ssl';
				$mail->Host = "mail.augustassociatesllc.net";
				$mail->Port = 465;
				$mail->IsHTML(false);
				$mail->Username = getMailUser();
				$mail->Password = getMailPassword();
				$mail->SetFrom("support@augustassociatesllc.net");
				$mail->FromName = "August Associates LLC";
				$mail->Subject = "Website Form";
				$mail->Body = $_POST['body'];
				$mail->AddAddress("augustassociatesllc@gmail.com");
				// $mail->AddAddress("joseph.mccarthy@fivestreet.me");
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
			$url = "http://www.zillow.com/webservice/GetSearchResults.htm?zws-id=" . getZillowAPI() . "&address=" . addPluses($_POST['address']) . "&citystatezip=" . $_POST['zip'] . "&rentzestimate=true";
			echo file_get_contents($url);
			break;
		case 'sendCMA':
			require_once('keys.php');
			$url = "https://www.cloudcma.com/cmas/widget?api_key=" . getCmaAPI() . "&name=" . addPluses($_POST['sellerName']) . "&email_to=" . addPluses($_POST['email']) . "&address=" . createAddress($_POST['address'], $_POST['city'], $_POST['state'], $_POST['zip']);
			file_get_contents($url);
			break;
		case 'ipCheck':
			require_once('keys.php');
			echo in_array($_SERVER['REMOTE_ADDR'], getIpAddresses());
			break;
		default:
			echo isset($_POST['functionname']);
			break;
	}

	function addPluses($str) {
		return str_replace(' ', '+', $str);;
	}

	function createAddress($address, $city, $state, $zip) {
		return addPluses($address) . ",+" . addPluses($city) . ",+" . $state . "+" . $zip;
	}
?>
