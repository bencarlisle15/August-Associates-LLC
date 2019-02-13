		<?php include('bin/head.php'); ?>
		<link rel="canonical" href="https://www.augustassociatesllc.com/newsletter" />
		<title>August Associates LLC - Newsletter</title>
		<meta name="description" content="Look at our newsletter to stay up to date on the real estate market. August Associates, your valued guide in real estate." />
	</head>
	<body>
		<?php //include('bin/nav.php');
		$start = strtotime('2019-01-04');
		$end = time();
		$weeks_between = floor(abs($end - $start) / 1209600);
		$startID = 1855996 + $weeks_between;
		$url = "https://newsletter.homeactions.net/archive/newsletter/11260/4265518/" . $startID;
		echo '<META HTTP-EQUIV=REFRESH CONTENT="1; '.$url.'">';
 		?>
		<!-- <iframe src='<?php echo $url ?>' width="1000" height=1000">
			<a href='<?php echo $url ?>'>
				Our Newsletter
			</a>
		</iframe>
		<?php include('bin/footer.html'); ?> -->
	</body>
</html>
