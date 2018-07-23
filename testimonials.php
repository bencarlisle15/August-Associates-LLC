		<?php include('bin/head.php'); ?>
		<style>
			<?php include('css/testimonials.css'); ?>
		</style>
		<title>August Associates LLC - Testimonials</title>
		<meta name="description" content="View our testimonials or add your own. August Associates, your valued guide in real estate." />
	</head>
	<body>
		<?php include('bin/nav.php'); ?>
		<div id="testimonialsSection" class="section">
			<h1 id="testimonialsName">Testimonials</h1>
			<div id="testimonialsWrapper">
				<div id="testimonialsList">
					<div class="testimonialFrame">
						<p class="testimonialText">Being deployed and in the middle of looking for my 1st home, you guys were the best!! Patient with all my pickiness, wants and needs. I have looked for a LONG time for my "perfect home" and you made it possible! I thought the process was nerve wrecking but you stayed level headed and made sure my concerns were felt with. Thank you for making this a smooth and easy process!!!!!</p>
						<p class="testimonialName">-Yronelis</p>
					</div>
					<div class="testimonialFrame">
						<p class="testimonialText">We met Joseph last year (2016) when we were searching for our dream house. It had been a 2.5+ year process and had had a big disappointment earlier that year, which left us quite gun-shy. We immediately felt at ease with him while he showed us several properties that we were interested in. His years of experience and expertise gave us sound feedback at each property and through this process, he quickly assessed what we were looking for in a home. His input was invaluable. After several months of looking, we found a home which he helped broker for us. Joseph's ability to stay calm when dealing with difficult personalities proved to be our anchor when dealing with several people in our search and final decision. His professionalism is top notch and we would highly recommend him to anyone looking for a home. His ethics are exemplary and his knowledge of the real estate market is outstanding. We sincerely appreciate what he brokered for us and are happily settled in our forever home.</p>
						<p class="testimonialName">-Georgina</p>
					</div>
					<div class="testimonialFrame">
						<p class="testimonialText">Joseph has sold a few of our homes. I wouldn't even think of considering any other realtor. Joseph understand his clients needs and is brilliant in negotiating the best price.</p>
						<p class="testimonialName">-Phoebe</p>
					</div>
					<div class="testimonialFrame">
						<p class="testimonialText">I have worked with Joseph on multiple purchase and sales and have always been impressed with the depth of knowledge and integrity displayed by Joseph. On each and every occasion he has exceeded my expectations and delivered top notch service. I would highly recommend Joseph to anyone entering into a real estate venture.</p>
						<p class="testimonialName">-Jacqueline</p>
					</div>
					<div class="testimonialFrame">
						<p class="testimonialText">Joe and I have worked together for over 10 years and he has assisted with the purchase and sale of over two dozen investment properties. As a REALTOR, Joe is a great resource because he understands the nuances of home financing and uses all avenues of available funding. He has worked through difficult transactions with ease which resulted in great success for both buyer and seller! I highly recommend Joe!</p>
						<p class="testimonialName">-Michele</p>
					</div>
					<div class="testimonialFrame">
						<p class="testimonialText">Joe is the most knowledeable realtor in the business. He knows construction and building code law. He has my back. He has put my interests above making a commission more than once. Simply said, I trust Joe above anyone in the business and I give my permission to use any or all of my statement in any ad. Dr John DeMello</p>
						<p class="testimonialName">-Jack</p>
					</div>
					<div class="testimonialFrame">
						<p class="testimonialText">Joe was our realtor 4 years ago when we bought our first home. He was incredibly helpful, patient, and went ABOVE AND BEYOND for us. We are still so very grateful that we had the pleasure of working with him and to have had him working for us.</p>
						<p class="testimonialName">-Hannah</p>
					</div>
				</div>
				<div id= "addTestimonialsWrapper">
					<h2 id="testimonialsAddText">Add Your Own</h2>
					<form id="testimonialsForm" action="javascript:submitTestimonialsForm()">
						<input type="text" title="Name" id="testimonialsFormName" placeholder="Name" required>
						<textarea rows="10" title="Text" id="testimonialsFormText" placeholder="Enter your Message Here" required></textarea>
						<button id="testimonialsFormSubmit">Submit</button>
					</form>
				</div>
			</div>
		</div>
		<?php include('bin/footer.html'); ?>
	</body>
</html>

<script>
	<?php
		include('js/load.js');
		include('js/testimonials.js');
	?>
</script>
