function submitMortgageForm() {
	var interest = document.getElementById("mortgageInterest").value/1200;
	var years = document.getElementById("mortgageYears").value;
	var downPayment = document.getElementById("mortgageDownPayment").value;
	var houseCost = document.getElementById("mortgageHouseCost").value;
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
