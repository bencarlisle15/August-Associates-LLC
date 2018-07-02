		<?php include($_SERVER['DOCUMENT_ROOT'].'/bin/head.php'); ?>
		<style>
			<?php include($_SERVER['DOCUMENT_ROOT'].'/css/error.css'); ?>
		</style>
		<title>August Associates LLC - 503</title>
		<meta name="description" content="503, this page is down for maintenance. August Associates, your valued guide in real estate." />
	</head>
	<body>
		<?php include('bin/nav.php'); ?>
		<div class="errorPage">
			<h1 class="errorCode">503</h1>
			<h2 class="errorDescription">Oops, looks like this page is down for maintenance, check back soon.</h2>
			<h3 class="errorWhatToDo">You should probably head back to the homepage or report a problem if you want</h3>
			<button id="errorHome" onclick="window.location.href='/'">Home</button>
			<button id="errorReport" onclick="window.location.href='/contact.php'">Report a Problem</button>
		</div>
		<?php include('bin/footer.html'); ?>
	</body>
</html>

<script>
	<?php
		include('bin/jquery.js');
		include('js/load.js');
	?>
</script>
