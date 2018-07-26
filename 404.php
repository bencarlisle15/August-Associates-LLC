		<?php include($_SERVER['DOCUMENT_ROOT'].'/bin/head.php'); ?>
		<link rel="stylesheet" type="text/css" href="/css/error.css">
		<link rel="canonical" href="https://www.augustassociatesllc.net/404" />
		<title>August Associates LLC - 404</title>
		<meta name="description" content="404, this page could not be found. August Associates, your valued guide in real estate." />
	</head>
	<body>
		<?php include($_SERVER['DOCUMENT_ROOT'].'/bin/nav.php'); ?>
		<div class="errorPage">
			<h2 class="errorCode errorElement">404</h2>
			<h2 class="errorElement">Oops, looks like this page doesn't exist.</h2>
			<h3 class="errorElement">You should probably head back to the homepage or report a problem if you want</h3>
			<button class="errorElement" onclick="window.location.href='/'">Home</button>
			<button class="errorElement" onclick="window.location.href='/contact'">Report a Problem</button>
		</div>
		<?php include($_SERVER['DOCUMENT_ROOT'].'/bin/footer.html'); ?>
		<script src="/js/load.js"></script>
	</body>
</html>
