//all currency input
var vals = ["mortgageHouseCost","mortgageDownPayment"];
for (var i in vals) {
	document.getElementById(vals[i]).addEventListener("keyup", function() {
		this.value = formatCurrency(this.value);
	});
}

//automatically updates currency input
function formatCurrency(oldVal) {
	var num = oldVal.replace(/(,)/g, '');
	var val = num.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
	if (val.slice(0,1)!='$' && val != '') {
		val = '$'+ val;
	}
	return val;
}

function submitMortgageForm() {
	var interest = document.getElementById("mortgageInterest").value/1200;
	var years = document.getElementById("mortgageYears").value;
	var downPayment = document.getElementById("mortgageDownPayment").value.replace(/(,)/g, '').substr(1);
	var houseCost = document.getElementById("mortgageHouseCost").value.replace(/(,)/g, '').substr(1);
	var interestPowered = Math.pow(1+interest, years*12);
	var mortgageMonthlyCost = (houseCost-downPayment)*interest*interestPowered/(interestPowered-1);
	var mortgageOverlay = document.createElement("div");
	mortgageOverlay.id = "mortgageOverlay";
	mortgageOverlay.onclick = function() {
		document.getElementById("mortgageSection").removeChild(document.getElementById("mortgageOverlay"));
	}
	mortgageOverlay.innerHTML = "<div id='mortgageInfo'><h2 id='mortgageMonthlyCost'>" + (interestPowered == 1 ? "Your Monthly Cost Could Not Be Calculated" : ("Your Monthly Cost is " + formatCurrency(mortgageMonthlyCost))) + "</h2></div>";
	document.getElementById("mortgageSection").prepend(mortgageOverlay);
	document.getElementById("mortgageSubmit").focus();
	document.getElementById("mortgageSubmit").blur();
	document.getElementById("mortgageInfo").onclick = function(e) {
		var event = e ? e : window.event;
		event.cancelBubble = true;
	}
}
