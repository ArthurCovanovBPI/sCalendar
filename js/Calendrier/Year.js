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
	var _a = document.getElementById("checkTout").checked;
	var _0 = document.getElementById("checkManifPublique").checked;
	var _1 = document.getElementById("checkManifInterne").checked;
	var _2 = document.getElementById("checkCalendaire").checked;
	var _3 = document.getElementById("checkAdminRH").checked;
	var _4 = document.getElementById("checkFinancier").checked;

	var newManifType = _a + _0 + _1 + _2 + _3 + _4;

	alert(newManifType);
}

