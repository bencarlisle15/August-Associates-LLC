<!DOCTYPE html>
<html lang="en" dir="ltr" xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
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
		<meta name="mobile-web-app-capable" content="yes">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="icon" href="/images/icon.png" type="image/ico" />
		<link rel="stylesheet" type="text/css" href="/css/default.css">
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
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

			ga('create', 'UA-XXXX-Y', 'auto');
			ga('send', 'pageview');

		</script>
