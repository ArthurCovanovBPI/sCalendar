function highlightColumn(colval)
{
	var cols = document.getElementsByClassName(colval);
for(i=0; i<cols.length; i++)
	{
		cols[i].classList.add("highlight");
	}
}
function lowlightColumn(colval)
{
	var cols = document.getElementsByClassName(colval);
for(i=0; i<cols.length; i++)
	{
		cols[i].classList.remove("highlight");
	}
}

function eventDescription(timeStamp, calendarCheck)
{
	$("#eventDescription").load("eventsDesc.php?timeStamp="+timeStamp+"&calendarCheck="+calendarCheck);
}

function monthEventDescription(timeStamp, calendarCheck)
{
	$("#eventDescription").load("eventsDesc.php?timeStamp="+timeStamp+"&calendarCheck="+calendarCheck+"&month=true");
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

