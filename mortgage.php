	<?php include('bin/head.php'); ?>
	<style>
		<?php include('css/mortgage.css'); ?>
	</style>
	<title>August Associates LLC - Mortgage Calculator</title>
	<meta name="description" content="Calculate what you would pay for your mortgage. August Associates, your valued guide in real estate." />
</head>
<body>
	<?php include('bin/nav.php'); ?>
	<div id="mortgageSection" class="section">
		<h1 id="mortgageTitle">See What You Would Pay Per Month</h1>
		<div id="mortgageOverlay" onkeypress="removeMortgageOverlay()" onclick="removeMortgageOverlay()">
			<div id="mortgageInfo" onclick="insideClickHandler()">
				<h2 id="mortgageMonthlyCost" align="center"></h2>
			</div>
		</div>
		<form id="mortgageForm" align="center" border="1px" action="javascript:submitMortgageForm()">
			<div id = mortgageHouseAndDown>
				<input type="number" id="mortgageHouseCost" placeholder="House Cost" required>
				<input type="number" id="mortgageDownPayment" placeholder="Down Payment" required>
			</div>
			<div id="mortgageYearsAndInterest">
				<input type="number" id="mortgageYears" placeholder="Mortgage Length (Years)">
				<input type="number" step="0.001" id="mortgageInterest" placeholder="Yearly Interest (%)">
			</div>
			<button id="mortgageSubmit">Calculate</button>
		</form>
	</div>
	<?php include('bin/footer.html'); ?>
</body>
</html>

<script>
	<?php
		include('bin/jquery.js');
		include('js/load.js');
		include('js/mortgage.js');
	?>
</script>
