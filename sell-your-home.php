		<?php include('bin/head.php'); ?>
		<link rel="stylesheet" type="text/css" href="/css/sell-your-home.css">
		<link rel="canonical" href="https://www.augustassociatesllc.net/sell-your-home" />
		<title>August Associates LLC - Sell Your Home</title>
		<meta name="description" content="See how much your home could be worth here. August Associates, your valued guide in real estate." />
	</head>
	<body>
		<?php include('bin/nav.php'); ?>
		<div id="sellSection" class="section">
			<h2 id="sellTitle">See How Much Your House is Worth</h2>
			<form id="sellHouseForm" action="javascript:submitForm()">
				<input type="text" title="Name" id="formName" placeholder="Name" class="formLineElement" required>
				<input type="email" title="Email" id="formEmail" class="formLineElement" placeholder="Email">
				<input type="text" title="Address" id="formAddress" placeholder="Address" class="formLineElement" required>
				<div id="formLine">
					<input type="text" title="City" id="formCity" class="formLineElement" placeholder="City" required>
					<input type="number" title="Zipcode" class="formLineElement" id="formZip" placeholder="Zipcode" required>
					<select title="State" id="formState" class="formLineElement">
						<option title="AL" value="AL">AL</option>
						<option title="AK" value="AK">AK</option>
						<option title="AR" value="AR">AR</option>
						<option title="AZ" value="AZ">AZ</option>
						<option title="CA" value="CA">CA</option>
						<option title="CO" value="CO">CO</option>
						<option title="CT" value="CT">CT</option>
						<option title="DC" value="DC">DC</option>
						<option title="DE" value="DE">DE</option>
						<option title="FL" value="FL">FL</option>
						<option title="GA" value="GA">GA</option>
						<option title="HI" value="HI">HI</option>
						<option title="IA" value="IA">IA</option>
						<option title="ID" value="ID">ID</option>
						<option title="IL" value="IL">IL</option>
						<option title="IN" value="IN">IN</option>
						<option title="KS" value="KS">KS</option>
						<option title="KY" value="KY">KY</option>
						<option title="LA" value="LA">LA</option>
						<option title="MA" value="MA">MA</option>
						<option title="MD" value="MD">MD</option>
						<option title="ME" value="ME">ME</option>
						<option title="MI" value="MI">MI</option>
						<option title="MN" value="MN">MN</option>
						<option title="MO" value="MO">MO</option>
						<option title="MS" value="MS">MS</option>
						<option title="MT" value="MT">MT</option>
						<option title="NC" value="NC">NC</option>
						<option title="NE" value="NE">NE</option>
						<option title="NH" value="NH">NH</option>
						<option title="NJ" value="NJ">NJ</option>
						<option title="NM" value="NM">NM</option>
						<option title="NV" value="NV">NV</option>
						<option title="NY" value="NY">NY</option>
						<option title="ND" value="ND">ND</option>
						<option title="OH" value="OH">OH</option>
						<option title="OK" value="OK">OK</option>
						<option title="OR" value="OR">OR</option>
						<option title="PA" value="PA">PA</option>
						<option title="RI" value="RI" selected="selected">RI</option>
						<option title="SC" value="SC">SC</option>
						<option title="SD" value="SD">SD</option>
						<option title="TN" value="TN">TN</option>
						<option title="TX" value="TX">TX</option>
						<option title="UT" value="UT">UT</option>
						<option title="VT" value="VT">VT</option>
						<option title="VA" value="VA">VA</option>
						<option title="WA" value="WA">WA</option>
						<option title="WI" value="WI">WI</option>
						<option title="WV" value="WV">WV</option>
						<option title="WY" value="WY">WY</option>
					</select>
				</div>
				<button id="formSubmit" class="formLineElement">Submit</button>
			</form>
		</div>
		<p id="zestimateDisclaimer">&copy; Zillow, Inc., 2006-2016. Use is subject to <a href="/corp/Terms.htm">Terms of Use</a><br /><a href="/wikipages/What-is-a-Zestimate/">What's a Zestimate?</a></p>
		<?php include('bin/footer.html'); ?>
		<script src="/js/sell-your-home.js" async></script>
	</body>
</html>
