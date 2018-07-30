		<?php include($_SERVER['DOCUMENT_ROOT'].'/bin/head.php'); ?>
		<link rel="stylesheet" type="text/css" href="/css/error.css">
		<link rel="canonical" href="https://www.augustassociatesllc.net/503" />
		<title>August Associates LLC - 503</title>
		<meta name="description" content="503, this page is down for maintenance. August Associates, your valued guide in real estate." />
	</head>
	<body>
		<?php include('bin/nav.php'); ?>
		<div class="errorPage">
			<h2 class="errorCode errorElement">503</h2>
			<h2 class="errorDescription errorElement">Oops, looks like this page is down for maintenance, check back soon.</h2>
			<h3 class="errorWhatToDo errorElement">You should probably head back to the homepage or report a problem if you want</h3>
			<button class="errorHome errorElement" onclick="window.location.href='/'">Home</button>
			<button class="errorReport errorElement" onclick="window.location.href='/contact.php'">Report a Problem</button>
		</div>
		<?php include('bin/footer.html'); ?>
	</body>
</html>
