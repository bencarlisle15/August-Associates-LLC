(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

ga('create', 'UA-XXXX-Y', 'auto');
ga('send', 'pageview');

$(document).ready(function() {
	editHeight();
	setTimeout(function() {
		editHeight();
	}, 1000);
});

$(window).resize(function() {
	editHeight()
});


$("nav").hover(function() {
	navSizeChange(true);
}, function() {
	navSizeChange(false);
})

function navSizeChange(increase) {
	$("nav").height($("#desktopNav").height() + (increase ? 10 : -10));
}

function editHeight() {
	var navHeight = $("nav").height();
	var footerHeight =$("footer").height();
	if (!navHeight) {
		$(document).ready(function() {
			editHeight();
		});
		return;
	} else {
		$("body").children().eq(1).css("margin-top", navHeight + 20);
		$("nav").css("top", 0);
	}
	if (!footerHeight) {
		$(document).ready(function() {
			editHeight();
		});
		return;
	} else {
		$("body").css("padding-bottom", footerHeight + 20);
	}
}
