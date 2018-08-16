<?php
	start:
	switch($_POST['functionname']) {
		case 'sendEmail':
			//sends email
			require_once('../vendor/phpmailer/phpmailer/src/PHPMailer.php');
			require_once('../vendor/phpmailer/phpmailer/src/Exception.php');
			require_once('../vendor/phpmailer/phpmailer/src/SMTP.php');
			require_once('keys.php');
			try {
				$mail = new PHPMailer\PHPMailer\PHPMailer();
				$mail->IsSMTP();
				$mail->SMTPDebug = 0;
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
				$mail->AddAddress("joseph.mccarthy@fivestreet.me");
				$mail->Send();
			} catch (phpmailerException $e) {
			} catch (Exception $e) {
			}
		break;
		case 'getEstimate':
			//returns zestimate
			require_once('keys.php');
			$url = "http://www.zillow.com/webservice/GetSearchResults.htm?zws-id=" . getZillowAPI() . "&address=" . addPluses($_POST['address']) . "&citystatezip=" . $_POST['zip'] . "&rentzestimate=true";
			echo file_get_contents($url);
			break;
		case 'getMLSNumber':
			//returns mlsNumber from zillow id
			require_once('keys.php');
			$url = "http://www.zillow.com/webservice/GetUpdatedPropertyDetails.htm?zws-id=" . getZillowAPI() . "&zpid=" . $_POST['zillowId'];
			echo file_get_contents($url);
			break;
		case 'sendCMA':
			//creates cma
			require_once('keys.php');
			$url = "https://www.cloudcma.com/cmas/widget?api_key=" . getCmaAPI() . "&name=" . addPluses($_POST['sellerName']) . "&email_to=" . addPluses($_POST['email']) . "&address=" . createAddress($_POST['address'], $_POST['city'], $_POST['state'], $_POST['zip']);
			file_get_contents($url);
			break;
		case 'ipCheck':
			require_once('keys.php');
			//checks if ip is in the ignore list
			if (in_array($_SERVER['REMOTE_ADDR'], getIpIgnoredAddresses())) {
				echo -1;
			} else {
				//checks if ip is in users list
				echo in_array($_SERVER['REMOTE_ADDR'], getIpAddresses());
			}
			break;
		case "addIP":
			//adds ip to the list
			require_once('keys.php');
			addIPAddress($_SERVER['REMOTE_ADDR'], $_POST['name'], $_POST['email']);
			break;
		case "ipReturned":
			//sends email with recroded ip info
			require_once('keys.php');
			$IPInfo = getIpInfo($_SERVER['REMOTE_ADDR']);
			$_POST['body'] = "Source: Website Recorded IP\nName: " . $IPInfo['name'] . "\nEmail: " . $IPInfo['email'] . "\nPhone: \nAddress: \nMLS Number: " . $_POST['MLSNumber'] . "\nNotes: User returned to website on page " . $_SERVER["HTTP_REFERER"];
			$_POST['functionname'] = 'sendEmail';
			//sorry
			goto start;
			break;
		default:
			echo "An error occured";
			break;
	}

	//changes spaces to pluses
	function addPluses($str) {
		return str_replace(' ', '+', $str);;
	}

	//creates address from info
	function createAddress($address, $city, $state, $zip) {
		return addPluses($address) . ",+" . addPluses($city) . ",+" . $state . "+" . $zip;
	}
?>
