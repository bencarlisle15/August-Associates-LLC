<?php
	// header("Content-Security-Policy: default-src 'none'; font-src 'self'; img-src 'self'; object-src 'none'; script-src 'self'; style-src 'self'");
	// header('Strict-Transport-Security','max-age=31536000; includeSubDomains; preload');
	// header('Access-Control-Allow-Origin: *');
	// header("X-Frame-Options: SAMEORIGIN");
	// header("X-Content-Type-Options: nosniff");
	// header("X-XSS-Protection: 1; mode=block");
?>
<!DOCTYPE html>
<html lang="en" dir="ltr" xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
	<head>
		<meta charset="UTF-8">
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
			"logo": "http://www.augustassociatesllc.com/images/august logo.png",
			"contactPoint": [
				{ "@type": "ContactPoint",
				"telephone": "+1(401) 487-1510",
				"contactType": "Customer Service"
				}
			],
			"sameAs": [
				"http://www.facebook.com/necompass",
				"https://www.linkedin.com/company/august-associates-llc/"
			],
			"potentialAction": {
				"@type": "SearchAction",
				"target": "https://augustassociatesllc.com/find-homes?searchCities={search_term_string}",
				"query-input": "required name=search_term_string"
			}
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
			<!-- Facebook Pixel Code -->
			!function(f,b,e,v,n,t,s)
			{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
				n.callMethod.apply(n,arguments):n.queue.push(arguments)};
				if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
				n.queue=[];t=b.createElement(e);t.async=!0;
				t.src=v;s=b.getElementsByTagName(e)[0];
				s.parentNode.insertBefore(t,s)}(window, document,'script',
				'https://connect.facebook.net/en_US/fbevents.js');
				fbq('init', '1251530264943817');
				fbq('track', 'PageView');
		</script>
		<noscript>
			<img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=1251530264943817&ev=PageView&noscript=1"/>
		</noscript>
