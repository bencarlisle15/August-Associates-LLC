		<?php include('bin/amp-head.php'); ?>
			<?php
				include('css/home-mobile.css');
			?>
		</style>
		<link rel="canonical" href="https://www.m.augustassociatesllc.net/" />
		<title>August Associates LLC - Rhode Island Real Estate</title>
		<meta name="description" content="August Associates is a real estate agency looking to help you buy or sell a home. North, South, East, West, your valued guide in real estate" />
		<script async custom-element="amp-facebook-like" src="https://cdn.ampproject.org/v0/amp-facebook-like-0.1.js"></script>
		<script async custom-element="amp-form" src="https://cdn.ampproject.org/v0/amp-form-0.1.js"></script>
		<script async custom-element="amp-social-share" src="https://cdn.ampproject.org/v0/amp-social-share-0.1.js"></script>
	</head>
	<body>
		<?php include('bin/nav.php'); ?>
		<div id='imageWrapper'>
			<amp-img width='350px' height='350px' id='whoLogo' alt='August Associates Logo' src='/images/august%20splash.png'></amp-img>
		</div>
		<div id='whoWrapper'>
			<h2 id='whoTitle'>Who We Are</h2>
			<p id='whoInfo'>Lorem ipsum nam porta nibh non arcu aliquet lobortis. Integer a egestas sem. Suspendisse lacinia erat sit amet turpis tempus auctor. Pellentesque cursus augue sapien, vitae consectetur diam lobortis ut. Pellentesque cursus augue sapien, vitae consectetur diam lobortis ut.</p>
		</div>
		<div id='missionWrapper'>
			<h2 id='missionTitle'>Our Mission</h2>
			<p id='missionInfo'>Lorem ipsum nam porta nibh non arcu aliquet lobortis. Integer a egestas sem. Suspendisse lacinia erat sit amet turpis tempus auctor. Pellentesque cursus augue sapien, vitae consectetur diam lobortis ut. Pellentesque cursus augue sapien, vitae consectetur diam lobortis ut.</p>
		</div>
		<div id="linkButtons" class="section">
			<a class="linkButton button" href="/find-homes">Find Your Perfect Home</a>
			<a class="linkButton button" href="/sell-your-home">Find Out What Your Home is Worth</a>
			<a class="linkButton button" href="/testimonials">See Our Testimonials</a>
		</div>
		<div id="houses" class="section">
			<div class="houseImageWrapper">
				<a href="/find-homes?searchCities=Cranston" class="houseLink">
					<amp-img class="houseImage" width="160px" height="100" alt="Cranston Image" src="/images/cranston.jpg"></amp-img>
				</a>
				<p class="caption">Cranston</p>
			</div>
			<div class="houseImageWrapper">
				<a href="/find-homes?searchCities=Warwick" class="houseLink">
					<amp-img class="houseImage" width="160px" height="100" alt="Warwick Image" src="/images/warwick.jpg"></amp-img>
				</a>
				<p class="caption">Warwick</p>
			</div>
			<div class="houseImageWrapper">
				<a href="/find-homes?searchCities=North-Kingstown" class="houseLink">
					<amp-img class="houseImage" width="160px" height="100" alt="North Kingstown Image" src="/images/nk.jpg"></amp-img>
				</a>
				<p class="caption">North Kingstown</p>
			</div>
			<div class="houseImageWrapper">
				<a href="/find-homes?searchCities=East-Greenwich" class="houseLink">
					<amp-img class="houseImage" width="160px" height="100" alt="East Greenwich Image" src="/images/east.jpg"></amp-img>
				</a>
				<p class="caption">East Greenwich</p>
			</div>
			<div class="houseImageWrapper">
				<a href="/find-homes?searchCities=Providence" class="houseLink">
					<amp-img class="houseImage" width="160px" height="100" alt="Providence Image" src="/images/providence.jpg"></amp-img>
				</a>
				<p class="caption">Providence</p>
			</div>
		</div>
		<div id="searchBox" class="section">
			<h2 id="searchHomes">Search Homes</h2>
			<form id= "searchForm" method="POST" target="_top" action-xhr="/phpRequests/submitSearchForm.php">
				<div class="searchFormLine">
					<input name="searchAddresses" type="text" title="Addresses" id="searchAddresses" placeholder="Addresses" class="searchElement">
					<input name="searchCities" type="text" title="Cities" id="searchCities" placeholder="Cities" class="searchElement">
					<input name="searchZips" type="text" title="Zipcodes" id="searchZips" placeholder="Zipcodes" class="searchElement">
					<select name="searchPropertyType" id="searchPropertyType" title="Property Type" class="searchElement">
						<option title="Property Type" value="" selected>Property Type</option>
						<option title="Single Family" value="Single Family">Single Family</option>
						<option title="Rental" value="Rental">Rental</option>
						<option title="Multi Family" value="	2-4 Units Multi Family">Multifamily	</option>
						<option title="Condo" value="Condominium">Condo</option>
						<option title="Vacant Land" value="Vacant Land">Vacant Land</option>
					</select>
				</div>
				<div class="searchFormLine">
					<input name="searchMinPrice" type="text" title="Min Price" id="searchMinPrice" placeholder="Min Price" class="searchElement">
					<input name="searchMaxPrice" type="text" title="Max Price" id="searchMaxPrice" placeholder="Max Price" class="searchElement">
					<input name="searchBeds" type="number" title="Min Bedrooms" id="searchBeds" placeholder="Min Bedrooms" class="searchElement">
					<input name="searchBaths" type="number" title="Min Bathrooms" id="searchBaths" placeholder="Min Bathrooms" class="searchElement">
					<input name="searchMinFeet" type="number" title="Min Square Feet" id="searchMinFeet" placeholder="Min Square Feet" class="searchElement">
					<input name="searchMaxFeet" type="number" title="Max Square Feet" id="searchMaxFeet" placeholder="Max Square Feet" class="searchElement">
				</div>
				<div id="searchSubmitWrapper" class="searchFormLine">
					<button id="searchSubmit" class="searchElement">Search</button>
				</div>
			</form>
		</div>
		<div id="infoWrapper">
			<h2 id="infoTitle">Our Info</h2>
			<div id="infoText">
				<p class="infoElement"><b>Phone: </b> (401) 461-0700</p>
				<p class="infoElement"><b>Email: </b><a href="mailto:jmccarthy@necompass.com">jmccarthy@necompass.com</a></p>
				<p class="infoElement"><b>Address: </b><a href="https://www.google.com/maps/place/946+Park+Ave,+Cranston,+RI+02910/@41.7808564,-71.4423498,17z/data=!3m1!4b1!4m5!3m4!1s0x89e44f0e74f416a7:0x9bb4c58a58a98e90!8m2!3d41.7808564!4d-71.4401611">946 Park Avenue, Cranston, RI</a></p>
			</div>
		</div>
		<div id="contactWrapper">
			<h2 id="contactTitle">Contact Us</h2>
			<form id="contactForm" method="POST"  action-xhr="/phpRequests/submitContactForm.php" target="_top" on="submit: contactForm.clear">
				<input type="text" title="Name" id="contactFormName" placeholder="Name" class="contactFormElement" required>
				<input type="email" title="Email" id="contactFormEmail" placeholder="Email" class="contactFormElement">
				<input type="tel" title="Phone" id="contactFormPhone" placeholder="Phone Number" class="contactFormElement">
				<textarea rows="10" title="Text" id="contactFormText" placeholder="Enter your Message Here" class="contactFormElement" required></textarea>
				<button id="contactFormSubmit" class="contactFormElement">Submit</button>
			</form>
		</div>
		<div id="socialButtons">
			<div id="facebookSocialWrapper">
				<amp-facebook-like id="fbLike" width="70px" height="20px"
					layout="fixed"
					data-layout="button_count"
					data-href="https://www.facebook.com/necompass/">
				</amp-facebook-like>
			</div>
			<amp-social-share type="twitter" width="60" height="44"
				data-param-text="Visit August Associates LLC at"
				data-param-url="https://www.augustassociatesllc.com" aria-label="Twitter">
			</amp-social-share>
			<amp-social-share type="linkedin" width="60" height="44"
				data-param-text="Visit August Associates LLC at https://www.augustassociatesllc.com"
				data-param-url="https://www.linkedin.com/company/august-associates-llc/" aria-label="LinkedIn">
			</amp-social-share>
			<amp-social-share type="gplus" width="60" height="44"
				data-param-text="Visit August Associates LLC at https://www.augustassociatesllc.com"
				data-param-url="https://plus.google.com/u/1/114941366286269838561" aria-label="Google+">
			</amp-social-share>
		</div>
		<?php include('bin/footer.html'); ?>
	</body>
</html>
