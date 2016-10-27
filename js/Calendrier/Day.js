function eventDescription(eventID)
{
	$("#eventDescription").load("eventDesc.php?eventID="+eventID);
}

function changeManifType()
{
	var _a = document.getElementById("checkTout").value;
	var _0 = document.getElementById("checkManifPublique").value;
	var _1 = document.getElementById("checkManifInterne").value;
	var _2 = document.getElementById("checkCalendaire").value;
	var _3 = document.getElementById("checkAdminRH").value;
	var _4 = document.getElementById("checkFinancier").value;

	var newManifType = _a + _0 + _1 + _2 + _3 + _4;

	alert(newManifType);
}

