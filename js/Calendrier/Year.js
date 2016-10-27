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
