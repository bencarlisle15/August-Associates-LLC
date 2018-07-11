		<?php include('bin/head.php'); ?>
		<style>
			<?php include('css/sell-your-home.css'); ?>
		</style>
		<title>August Associates LLC - Sell Your Home</title>
		<meta name="description" content="See how much your home could be worth here. August Associates, your valued guide in real estate." />
	</head>
	<body>
		<?php include('bin/nav.php'); ?>
		<div id="sellSection" class="section">
			<h1 id="sellTitle">See How Much Your House is Worth</h1>
			<div id="sellOverlay" onkeypress="removeSellOverlay()" onclick="removeSellOverlay()">
				<div id="sellInfo" onclick="insideClickHandler()">
					<h2 id="sellAddress"></h2>
					<h2 id="sellCity"></h2>
					<h3 id="sellAverage"></h3>
					<h4 id="sellRange"></h4>
				</div>
			</div>
			<form id="sellHouseForm" align="center" border="1px" action="javascript:submitForm()">
				<input type="text" id = "formName" placeholder="Name" class="formLineElement" required>
				<input type="email" id="formEmail" class="formLineElement" placeholder="Email">
				<input type="text" id="formAddress" placeholder="Address" class="formLineElement" required>
				<div id = "formLine">
					<input type="text" id="formCity" class="formLineElement" placeholder="City" required>
					<input type="number" class="formLineElement" id="formZip" placeholder="Zipcode" required>
					<select id="formState" class="formLineElement">
						<option value="AL">AL</option>
						<option value="AK">AK</option>
						<option value="AR">AR</option>
						<option value="AZ">AZ</option>
						<option value="CA">CA</option>
						<option value="CO">CO</option>
						<option value="CT">CT</option>
						<option value="DC">DC</option>
						<option value="DE">DE</option>
						<option value="FL">FL</option>
						<option value="GA">GA</option>
						<option value="HI">HI</option>
						<option value="IA">IA</option>
						<option value="ID">ID</option>
						<option value="IL">IL</option>
						<option value="IN">IN</option>
						<option value="KS">KS</option>
						<option value="KY">KY</option>
						<option value="LA">LA</option>
						<option value="MA">MA</option>
						<option value="MD">MD</option>
						<option value="ME">ME</option>
						<option value="MI">MI</option>
						<option value="MN">MN</option>
						<option value="MO">MO</option>
						<option value="MS">MS</option>
						<option value="MT">MT</option>
						<option value="NC">NC</option>
						<option value="NE">NE</option>
						<option value="NH">NH</option>
						<option value="NJ">NJ</option>
						<option value="NM">NM</option>
						<option value="NV">NV</option>
						<option value="NY">NY</option>
						<option value="ND">ND</option>
						<option value="OH">OH</option>
						<option value="OK">OK</option>
						<option value="OR">OR</option>
						<option value="PA">PA</option>
						<option value="RI" selected="selected">RI</option>
						<option value="SC">SC</option>
						<option value="SD">SD</option>
						<option value="TN">TN</option>
						<option value="TX">TX</option>
						<option value="UT">UT</option>
						<option value="VT">VT</option>
						<option value="VA">VA</option>
						<option value="WA">WA</option>
						<option value="WI">WI</option>
						<option value="WV">WV</option>
						<option value="WY">WY</option>
					</select>
				</div>
				<button id="formSubmit" class="formLineElement">Submit</button>
			</form>
		</div>
		<?php include('bin/footer.html'); ?>
	</body>
</html>

<script>
	<?php
		include('js/load.js');
		include('js/sell-your-home.js');
	?>
</script>
