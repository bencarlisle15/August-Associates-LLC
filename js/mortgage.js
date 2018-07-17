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
	if (interestPowered == 1) {
		document.getElementById("mortgageMonthlyCost").innerHTML = "Your Monthly Cost Could Not Be Calculated";
		addMortgageOverlay();
	} else {
		var mortgageMonthlyCost = (houseCost-downPayment)*interest*interestPowered/(interestPowered-1);
		var formatter = new Intl.NumberFormat('en-US', {
			style: 'currency',
			currency: 'USD',
		});
		document.getElementById("mortgageMonthlyCost").innerHTML = "Your Monthly Cost is " + formatter.format(mortgageMonthlyCost);
		addMortgageOverlay();
	}
}

function insideClickHandler(e) {
	if (!e) {
		var e = window.event;
	}
	e.cancelBubble = true;
}

function addMortgageOverlay() {
	document.getElementById("mortgageOverlay").style.display = "block";
}

function removeMortgageOverlay() {
	document.getElementById("mortgageOverlay").style.display = "none";
}
