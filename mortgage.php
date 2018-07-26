	<?php include('bin/head.php'); ?>
	<link rel="stylesheet" type="text/css" href="/css/mortgage.css">
	<link rel="canonical" href="https://www.augustassociatesllc.net/mortgage" />
	<title>August Associates LLC - Mortgage Calculator</title>
	<meta name="description" content="Calculate what you would pay for your mortgage. August Associates, your valued guide in real estate." />
</head>
<body>
	<?php include('bin/nav.php'); ?>
	<div id="mortgageSection" class="section">
		<h2 id="mortgageTitle">See What You Would Pay Per Month</h2>
		<form id="mortgageForm" action="javascript:submitMortgageForm()">
			<div id="mortgageHouseAndDown">
				<input type="text" title="House Cost" id="mortgageHouseCost" class="mortgageElement" placeholder="House Cost" required>
				<input type="text" title="Down Payment" id="mortgageDownPayment" class="mortgageElement" placeholder="Down Payment" required>
			</div>
			<div id="mortgageYearsAndInterest">
				<input type="number" title="Mortgage Length (Years)" id="mortgageYears" class="mortgageElement" placeholder="Mortgage Length (Years)">
				<input type="number" title="Yearly Interst (%)" step="0.001" id="mortgageInterest" class="mortgageElement" placeholder="Yearly Interest (%)">
			</div>
			<button id="mortgageSubmit" class="mortgageElement">Calculate</button>
		</form>
	</div>
	<?php include('bin/footer.html'); ?>
	<script src="/js/load.js" async></script>
	<script src="/js/mortgage.js" async></script>
</body>
</html>
