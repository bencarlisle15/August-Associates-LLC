<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<?php
			// header("Content-Security-Policy: default-src 'none'; font-src 'self'; img-src 'self'; object-src 'none'; script-src 'self'; style-src 'self'");
			// header('Strict-Transport-Security','max-age=31536000; includeSubDomains; preload');
			// header('Access-Control-Allow-Origin: *');
			// header("X-Frame-Options: SAMEORIGIN");
			// header("X-Content-Type-Options: nosniff");
			// header("X-XSS-Protection: 1; mode=block");
		?>
		<link rel="manifest" href="/manifest.webmanifest">
		<meta name="theme-color" content="#383493">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="icon" href="/images/icon.png" type="image/ico" />
		<style>
			<?php
				include($_SERVER['DOCUMENT_ROOT'].'/css/default.css');
			?>
		</style>
		<!-- <link rel="stylesheet" href="../css/default.css"> -->
		<script type="application/ld+json"> {
			"@context": "http://schema.org",
			"@type": "Organization",
			"url": "http://www.augustassociatesllc.com",
			"contactPoint": [
				{ "@type": "ContactPoint",
				"telephone": "+1(401) 487-1510",
				"contactType": "Customer Service"
				}
			]
		} </script>
		<script async src="https://www.googletagmanager.com/gtag/js?id=UA-121414619-1"></script>
		<script>
			window.dataLayer = window.dataLayer || [];
			function gtag(){dataLayer.push(arguments);}
			gtag('js', new Date());
			gtag('config', 'UA-121414619-1');
		</script>
