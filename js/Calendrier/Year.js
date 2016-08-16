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

function eventDescription(timeStamp)
{
	$("#eventDescription").load("eventsDesc.php?timeStamp="+timeStamp);
}

function monthEventDescription(timeStamp)
{
	$("#eventDescription").load("eventsDesc.php?timeStamp="+timeStamp+"&month=true");
}
