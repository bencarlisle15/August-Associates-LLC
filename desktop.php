		<?php include('bin/head.php'); ?>
		<style>
			<?php include('css/home.css'); ?>
		</style>
		<title>August Associates LLC - Rhode Island Real Estate</title>
		<meta name="description" content="August Associates is a real estate agency looking to help you buy or sell a home. North, South, East, West, your valued guide in real estate" />
	</head>
	<body>
		<?php include('bin/nav.php'); ?>
		<div id='bigImage'>
			<img id="largeImage" src='/images/large august logo.webp' width='100%' alt='August Associates Logo' id='bigLogo' style="display: block; z-index: 1;"/>
			<img id="smallImage" src='/images/small august logo.webp' width='100%' alt='August Associates Logo' id='bigLogo'/>
			<img id='arrow' src='/images/arrow.webp' alt='Arrow'/>
		</div>
		<div id="linkButtons" class="section">
			<a class="button" href="/find-homes">Find Your Perfect Home</a>
			<a class="button" href="/sell-your-home">Find Out Whay Your Home is Worth</a>
			<a class="button" href="/testimonials">See Our Testimonials</a>
		</div>
		<div id="houses" class="section">
			<div id="cranstonWrapper" class="houseImageWrapper" onclick="window.location.href='/find-homes?searchCities=Cranston'">
				<img class="image house" id="cranston" alt="Cranston Image" src="/images/cranston.webp"/>
				<p class="caption">Cranston</p>
			</div>
			<div id="warwickWrapper" class="houseImageWrapper" onclick="window.location.href='/find-homes?searchCities=Warwick'">
				<img class="image house" id="warwick" alt="Warwick Image" src="/images/warwick.webp"/>
				<p class="caption">Warwick</p>
			</div>
			<div id="northKingstownWrapper" class="houseImageWrapper" onclick="window.location.href='/find-homes?searchCities=North-Kingstown'">
				<img class="image house" id="northKingstown" alt="North Kingstown Image" src="/images/nk.webp"/>
				<p class="caption">North Kingstown</p>
			</div>
			<div id="eastGreenwichWrapper" class="houseImageWrapper" onclick="window.location.href='/find-homes?searchCities=East-Greenwich'">
				<img class="image house" id="eastGreenwich" alt="East Greenwich Image" src="/images/east.webp"/>
				<p class="caption">East Greenwich</p>
			</div>
			<div id="providenceWrapper" class="houseImageWrapper" onclick="window.location.href='/find-homes?searchCities=Providence'">
				<img class="image house" id="providence" alt="Providence Image" src="/images/providence.webp"/>
				<p class="caption">Providence</p>
			</div>
		</div>
		<div id="whoMissionInfo">
			<div id='whoWrapper'>
				<h2 id='whoTitle'>Who We Are</h2>
				<p id='whoInfo'>Lorem ipsum nam porta nibh non arcu aliquet lobortis. Integer a egestas sem. Suspendisse lacinia erat sit amet turpis tempus auctor. Pellentesque cursus augue sapien, vitae consectetur diam lobortis ut. Pellentesque cursus augue sapien, vitae consectetur diam lobortis ut.</p>
			</div>
			<div id='missionWrapper'>
				<h2 id='missionTitle'>Our Mission</h2>
				<p id='missionInfo'>Lorem ipsum nam porta nibh non arcu aliquet lobortis. Integer a egestas sem. Suspendisse lacinia erat sit amet turpis tempus auctor. Pellentesque cursus augue sapien, vitae consectetur diam lobortis ut. Pellentesque cursus augue sapien, vitae consectetur diam lobortis ut.</p>
			</div>
		</div>
		<div id="searchBox">
			<form id= "searchForm" action="javascript:submitSearch()">
				<div id="searchFirstLine">
					<input type="text" id="searchAddresses" placeholder="Addresses">
					<input type="text" id="searchCities" placeholder="Cities">
					<input type="text" id="searchZips" placeholder="Zipcodes">
					<select id="searchPropertyType">
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
					<input type="number" id="searchMinPrice" placeholder="Min Price">
					<input type="number" id="searchMaxPrice" placeholder="Max Price">
					<input type="number" id="searchBeds" placeholder="Min Bedrooms">
					<input type="number" id="searchBaths" placeholder="Min Bathrooms">
					<input type="number" id="searchMinFeet" placeholder="Min Square Feet">
					<input type="number" id="searchMaxFeet" placeholder="Max Square Feet">
				</div>
				<div id="searchSubmitWrapper">
					<button id="searchSubmit">Search</button>
				</div>
			</form>
		</div>
		<div id="infoContact" class="section">
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
				<form id="contactForm" border="1px" action="javascript:submitContactForm()">
					<input type="text" id="contactFormName" placeholder="Name" required>
					<input type="email" id="contactFormEmail" placeholder="Email">
					<input type="tel" id="contactFormPhone" placeholder="Phone Number">
					<textarea rows="10" id="contactFormText" placeholder="Enter your Message Here" required></textarea>
					<button id="contactFormSubmit">Submit</button>
				</form>
			</div>
			<div id="facebookWrapper">
				<iframe title="Facebook Page" src="https://www.facebook.com/plugins/page?href=https%3A%2F%2Fwww.facebook.com%2FJoseph-McCarthy-Real-Estate-Broker-642396402607701%2F&tabs=timeline&width=500&height=500&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true&appId" style="width: 500px; height:500px;" scrolling="no" frameborder="0" allowTransparency="true" allow="encrypted-media"></iframe>
			</div>
		</div>
		<!-- <div id="socialIcons" width="100%" height="25px">
			<h4>Facebook</h4>
			<h4>Twitter</h4>
			<h4>LinkedIn</h4>
			<h4>Google+</h4>
		</div> -->
		<?php include('bin/footer.html'); ?>
	</body>
</html>
	<script>
		<?php
			include('bin/jquery.js');
			include('js/load.js');
			include('js/home.js');
		?>
	</script>
