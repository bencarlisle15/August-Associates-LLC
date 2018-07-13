(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

ga('create', 'UA-XXXX-Y', 'auto');
ga('send', 'pageview');

document.addEventListener('DOMContentLoaded', function() {
	editHeight();
	setTimeout(function() {
		editHeight();
	}, 1000);
});

window.addEventListener("resize", function() {
	editHeight()
});

String.prototype.toProperCase = function() {
	var i, j, str, lowers, uppers;
	str = this.replace(/([^\W_]+[^\s-]*) */g, function(txt) {
		return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
	});
	lowers = ['A', 'An', 'The', 'And', 'But', 'Or', 'For', 'Nor', 'As', 'At', 'By', 'For', 'From', 'In', 'Into', 'Near', 'Of', 'On', 'Onto', 'To', 'With'];
	for (i = 0, j = lowers.length; i < j; i++) {
		str = str.replace(new RegExp('\\s' + lowers[i] + '\\s', 'g'), function(txt) {
				return txt.toLowerCase();
		});
	}
	uppers = ['Id', 'Tv'];
	for (i = 0, j = uppers.length; i < j; i++) {
		str = str.replace(new RegExp('\\b' + uppers[i] + '\\b', 'g'), uppers[i].toUpperCase());
	}
	return str;
}

function getWidth(elem) {
	return parseInt(window.getComputedStyle(document.querySelector(elem), null).width);
}

function getHeight(elem) {
	return parseInt(window.getComputedStyle(document.querySelector(elem), null).height);
}

function editHeight() {
	var navHeight = getHeight("nav");
	var footerHeight = getHeight("footer")
	if (!navHeight) {
		document.addEventListener('DOMContentLoaded', function() {
			editHeight();
		});
		return;
	} else {
		document.body.childNodes[3].style.marginTop = navHeight + 20 + "px";
		document.getElementsByTagName("nav")[0].style.top = "0px";
	}
	if (!footerHeight) {
		document.addEventListener('DOMContentLoaded', function() {
			editHeight();
		});
		return;
	} else {
		document.body.style.paddingBottom = footerHeight + 20 + "px";
	}
}
