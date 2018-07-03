		<?php include('bin/amp-head.php'); ?>
			<?php
				include('css/home-mobile.css');
			?>
		</style>
		<title>August Associates LLC - Rhode Island Real Estate</title>
		<meta name="description" content="August Associates is a real estate agency looking to help you buy or sell a home. North, South, East, West, your valued guide in real estate" />
		<script async custom-element="amp-facebook-like" src="https://cdn.ampproject.org/v0/amp-facebook-like-0.1.js"></script>
		<script async custom-element="amp-form" src="https://cdn.ampproject.org/v0/amp-form-0.1.js"></script>
		<script async custom-element="amp-social-share" src="https://cdn.ampproject.org/v0/amp-social-share-0.1.js"></script>
		<link rel="canonical" href="http://www.augustassociatesllc.com" />
	</head>
	<body>
		<?php include('bin/nav.php'); ?>
		<div id='imageWrapper'>
			<amp-img class='image' width='350px' height='350px' id='whoLogo' alt='August Associates Logo' src='/images/august splash.png'/>
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
			<a class="button" href="/find-homes">Find Your Perfect Home</a>
			<a class="button" href="/sell-your-home">Find Out Whay Your Home is Worth</a>
			<a class="button" href="/testimonials">See Our Testimonials</a>
		</div>
		<div id="houses" class="section">
			<div id="cranstonWrapper" class="houseImageWrapper">
				<a href="/find-homes?searchCities=Cranston" class="houseLink">
					<amp-img class="image house" id="cranston" width="160px" height="100" alt="Cranston Image" src="/images/cranston.jpg"/>
				</a>
				<p class="caption">Cranston</p>
			</div>
			<div id="warwickWrapper" class="houseImageWrapper">
				<a href="/find-homes?searchCities=Warwick" class="houseLink">
					<amp-img class="image house" id="warwick" width="160px" height="100" alt="Warwick Image" src="/images/warwick.jpg"/>
				</a>
				<p class="caption">Warwick</p>
			</div>
			<div id="northKingstownWrapper" class="houseImageWrapper">
				<a href="/find-homes?searchCities=North-Kingstown" class="houseLink">
					<amp-img class="image house" id="northKingstown" width="160px" height="100" alt="North Kingstown Image" src="/images/nk.jpg"/>
				</a>
				<p class="caption">North Kingstown</p>
			</div>
			<div id="eastGreenwichWrapper" class="houseImageWrapper">
				<a href="/find-homes?searchCities=East-Greenwich" class="houseLink">
					<amp-img class="image house" id="eastGreenwich" width="160px" height="100" alt="East Greenwich Image" src="/images/east.jpg"/>
				</a>
				<p class="caption">East Greenwich</p>
			</div>
			<div id="providenceWrapper" class="houseImageWrapper">
				<a href="/find-homes?searchCities=Providence" class="houseLink">
					<amp-img class="image house" id="providence" width="160px" height="100" alt="Providence Image" src="/images/providence.jpg"/>
				</a>
				<p class="caption">Providence</p>
			</div>
		</div>
		<div id="searchBox">
			<form id= "searchForm" method="POST" target="_top" action-xhr="/phpRequests/submitSearchForm.php">
				<div id="searchFirstLine">
					<input type="text" id="searchAddresses" name="searchAddresses" placeholder="Addresses">
					<input type="text" id="searchCities" name="searchCities" placeholder="Cities">
					<input type="text" id="searchZips" name="searchZips" placeholder="Zipcodes">
					<select id="searchPropertyType" name="searchPropertyType">
						<option value="" selected>Property Type</option>
						<option value="resedential">Resedential</option>
						<option value="rental">Rental</option>
						<option value="multifamily">Multifamily	</option>
						<option value="condominium">Condo</option>
						<option value="commerical">Commerical</option>
						<option value="land">Land</option>
						<option value="farm">Farm</option>
					</select>
				</div>
				<div id="searchSecondLine">
					<input type="number" id="searchMinPrice" name="searchMinPrice" placeholder="Min Price">
					<input type="number" id="searchMaxPrice" name="searchMaxPrice" placeholder="Max Price">
					<input type="number" id="searchBeds" name="searchBeds" placeholder="Min Bedrooms">
					<input type="number" id="searchBaths" name="searchBaths" placeholder="Min Bathrooms">
					<input type="number" id="searchMinFeet" name="searchMinFeet" placeholder="Min Square Feet">
					<input type="number" id="searchMaxFeet" name="searchMaxFeet" placeholder="Max Square Feet">
				</div>
				<div id="searchSubmitWrapper">
					<button id="searchSubmit">Search</button>
				</div>
			</form>
		</div>
		<div id="infoWrapper">
			<h2 id="infoTitle">Our Info</h2>
			<div id="infoText">
				<p><b>Phone: </b>(401) 487-1510</p>
				<p><b>Email: </b><a href="mailto:jmccarthy@necompass.com">jmccarthy@necompass.com</a></p>
				<p><b>Address: </b><a href="https://www.google.com/maps/place/946+Park+Ave,+Cranston,+RI+02910/@41.7808564,-71.4423498,17z/data=!3m1!4b1!4m5!3m4!1s0x89e44f0e74f416a7:0x9bb4c58a58a98e90!8m2!3d41.7808564!4d-71.4401611">946 Park Avenue, Cranston, RI</a></p>
			</div>
		</div>
		<div id="contactWrapper">
			<h2 id="contactTitle">Contact Us</h2>
			<form id="contactForm" method="POST"  action-xhr="/phpRequests/submitContactForm.php" target="_top" on="submit: contactForm.clear">
				<input type="text" name="name" id="contactFormName" placeholder="Name" required>
				<input type="email" name="email" id="contactFormEmail" placeholder="Email">
				<input type="tel" name="phone" id="contactFormPhone" placeholder="Phone Number">
				<textarea rows="10" name="text" id="contactFormText" placeholder="Enter your Message Here" required></textarea>
				<button id="contactFormSubmit">Submit</button>
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
