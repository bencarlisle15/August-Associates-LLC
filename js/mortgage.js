var formatter = new Intl.NumberFormat('en-US', {
	style: 'currency',
	currency: 'USD',
});

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
	document.getElementById("mortgageDownPayment").style.opacity = "0.25";
	document.getElementById("mortgageHouseCost").style.opacity = "0.25";
	document.getElementById("mortgageInterest").style.opacity = "0.25";
	document.getElementById("mortgageYears").style.opacity = "0.25";
	document.getElementById("mortgageSubmit").style.opacity = "0.25";
}

function removeMortgageOverlay() {
	document.getElementById("mortgageOverlay").style.display = "none";
	document.getElementById("mortgageDownPayment").style.opacity = "1";
	document.getElementById("mortgageHouseCost").style.opacity = "1";
	document.getElementById("mortgageInterest").style.opacity = "1";
	document.getElementById("mortgageYears").style.opacity = "1";
	document.getElementById("mortgageSubmit").style.opacity = "1";
}
