		<?php include('bin/head.php');
			//logs into the database to get the rets data
			ini_set('memory_limit', '-1');
			require_once("phpRequests/keys.php");
			$conn = new mysqli("localhost", getDBUser(), getDBPassword(), getDBName());
			$query = "SELECT * FROM RetsData WHERE `MLSNumber`=" . $_GET['id'];
			$result = mysqli_query($conn, $query);
			$res = $result->fetch_assoc();
			if (!$result || !$res) {
				require('404.php');
				die();
			}
		?>
		<div id="fb-root"></div>
		<script>(function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) return;
			js = d.createElement(s); js.id = id;
			js.src = "https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.0";
			fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));</script>
		<script>window.twttr = (function(d, s, id) {
		  var js, fjs = d.getElementsByTagName(s)[0],
		    t = window.twttr || {};
		  if (d.getElementById(id)) return t;
		  js = d.createElement(s);
		  js.id = id;
		  js.src = "https://platform.twitter.com/widgets.js";
		  fjs.parentNode.insertBefore(js, fjs);

		  t._e = [];
		  t.ready = function(f) {
		    t._e.push(f);
		  };

		  return t;
		}(document, "script", "twitter-wjs"));</script>
		<script type="text/javascript" async defer src="//assets.pinterest.com/js/pinit.js"></script>

		<link rel="stylesheet" type="text/css" href="/css/find-your-home.css">
		<link rel="canonical" href="https://www.augustassociatesllc.com/find-your-home" />
		<title>August Associates LLC - Find Your Home</title>
		<meta name="description" content="View your new home here. August Associates, your valued guide in real estate." />
	</head>
	<body>
		<?php include('bin/nav.php'); ?>
		<div id="yourHomeSection" class="section">
			<div id="infoWrapper">
				<?php
					$dir = "images/largeRets/";
					if (!file_exists($dir)) {
						$dir = "testing/images/largeRets/";
					}
					//if the are photos, create a slideshow
					if ($res['PhotoCount']) {
						$total = $res['PhotoCount'];
						echo "<div id='houseSlideshow'>";
						//loops through photos to add them to the slideshow
						for ($i = 0; $i < $res['PhotoCount']; $i++) {
							//determines if the photo is a duplicate or doesn't exist

							if (!file_exists($dir . $res['MLSNumber'] . '/' . $i . '.jpg') || $i >= 1 && file_exists($dir . $res['MLSNumber'] . '/' . ($i-1) . '.jpg') && md5(file_get_contents($dir . $res['MLSNumber'] . '/' . ($i-1) . '.jpg')) == md5(file_get_contents($dir . $res['MLSNumber'] . '/' . $i . '.jpg'))) {
								//decreases the total number of photos
								$total--;
								continue;
							}
							//adds the image
							echo "<div class='houseWrapper'><img src='" $dir . htmlspecialchars($res['MLSNumber']) . "/" . $i . ".jpg' alt='Picture of the House' class='houseImage'/></div>";
						}
						if ($total) {
							echo "<a onclick='plusSlides(-1)' id='prev'>&#10094;</a>
								<a onclick='plusSlides(1)' id='next'>&#10095;</a>
							</div>
							<div id='dots'>";
							//adds a dot for each image
							for ($i = 0; $i < $total; $i++) {
								echo "<span class='dot' onclick='showSlides(" . $i . ")'></span>";
							}
						}
						echo "</div>";
					}
					$url = "https://www.augustassociatesllc.com/find-your-home?id=" . $_GET['id'];
					echo "<div id='addressSocialWrapper'><p/><h2 id='address'>" . htmlspecialchars(toSentenceCase($res['FullStreetNum'])) . ", " . htmlspecialchars(toSentenceCase($res['City'])) . ", " . $res['PostalCode'] . "</h2><div class='fb-share-button'
    data-href='" . $url . "'
    data-layout='button_count'>
  </div><div><a class='twitter-share-button' data-url='" . $url . "' href='https://twitter.com/intent/tweet'>Tweet</a></div></div>
					<h2 id='price'>$" . htmlspecialchars(number_format((float) $res['CurrentPrice'])) . "</h2>
					<div id='tableAndDescription'>
						<p id='description'>" .  htmlspecialchars(toSentenceCase($res['PublicRemarks'])) . "</p>
						<table id='table'>";
						//list of all attributes to use sorted by ['RetsName' => 'Visible name']
						$keys = ["SqFtTotal" => "Living Area Size", "BathsTotal" => "Bathrooms", "NumberOfLevels" => "Stories", "Fireplace"=> "Fireplace", "HeatingSystem"=> "Heating", "BedsTotal"=> "Bedrooms", "Pool"=> "Pool", "WaterAmenities"=> "Water Amenities", "YearBuilt"=> "Year Built", "GarageSpaces"=> "Garage Spaces", "ApproxLotSquareFoot" => "Lot Size", "ListOfficeName" => "Listing Office"];
						//adds all the attirbutes;
						foreach ($keys as $key => $value) {
							$val = $res[$key];
							if ($key == "ApproxLotSquareFoot" || $key == "SqFtTotal") {
								$val = number_format((float)$val) . " Ft";
							}
							addAttribute($value, $val);
						}
						echo "<tr><th class='keys'>Source</th><td class='values'>Rhode Island MLS</td></tr>
						</table>
					</div>";
					echo "<h2 id='interested'>Interested in this Home?</h2>
					<h2 id='interestedContact'>Call us at <a href='tel:4014610700'>(401) 461-0700</a> or Email us at <a href='mailto:info@augustassociatesllc.com'>info@augustassociatesllc.com</a> to get in touch with an agent</h2>";
					//capitalizes the first letter after spaces, ', and "

					function toSentenceCase($str) {
						return str_replace("\" ", "\"", ucwords(str_replace("\"", "\" ", strtolower(str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($str))))))));
					}

					//adds attribute to table
					function addAttribute($keyName, $value) {
						//converts ti int if it is a number and ensures its not 0
						if (is_numeric($value)) {
							$value = (int) $value;
							if (!$value) {
								return;
							}
						}
						//checks if value is valid
						if ($value == null || $value == "None" || $value === " Ft") {
							return;
						}
						echo "<tr><th class='keys'>" . htmlspecialchars($keyName) . "</th><td class='values'>" . htmlspecialchars(str_replace("August Associates,  Llc", "August Associates LLC", strpos($value, "Ft") ? $value : toSentenceCase(str_replace(",", ", ", $value)))) . "</td></tr>";
					}
				?>
				<div id="map"></div>
				<div id="useInfoWrapper">
					<h6 id="useInfo">“IDX information is provided exclusively for consumers’ personal, non-commercial use and may not be used for any purpose other than to identify prospective properties consumers may be interested in purchasing. Information is deemed reliable but is not guaranteed.  © 2018 State-Wide Multiple Listing Service. All rights reserved.”</h6>
				</div>
			</div>
		</div>
		<?php include('bin/footer.html'); ?>
		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBTXHu0_banpDsOMFQSDHOxoqdooVQxreI"></script>
		<script src="/js/find-your-home.js"></script>
		<script>
			//inits map to position
			initMap('<?php echo json_encode([$res['Latitude'], $res['Longitude']]);?>');
		</script>
	</body>
</html>
