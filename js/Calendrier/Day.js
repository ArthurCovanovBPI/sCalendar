function eventDescription(eventID)
{
	$("#eventDescription").load("eventDesc.php?eventID="+eventID);
	//alert(eventID);
}

