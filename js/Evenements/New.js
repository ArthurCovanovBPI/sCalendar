function updateManifTimeStart()
{
	alert();
}

function updateManifTimeEnd()
{
	alert();
}

function testRecurrence(a)
{
	var x = a.selectedIndex;
	if(x!=0)
		document.getElementById("recurrenceEnd").style.visibility = "visible";
	else
		document.getElementById("recurrenceEnd").style.visibility = "hidden";
}

function daysInMonth(month, year)
{
    return new Date(year, month, 0).getDate();
}

function newReservation()
{
	var x = document.getElementById("reserverLieu");
	if(x.checked)
		document.getElementById("reservationLieu").style.display = "block";
	else
		document.getElementById("reservationLieu").style.display = "none";
}

function updateLieux()
{
	$("#lieuxSpan").load("lieuDataList.php?eID="+document.getElementById("espaceSelection").value);
	document.getElementById("inputLieuSelection").value="";
}

function updateDayManifestation()
{
	var maxD = daysInMonth(document.getElementById("manifMonthSelection").value, document.getElementById("manifYearSelection").value);
	var daysList = document.getElementById("manifDaySelection").getElementsByTagName("option");
	for (var i = 0; i < daysList.length; i++)
	{
		(daysList[i].value > maxD) 
		? daysList[i].disabled = true 
		: daysList[i].disabled = false;
	}
	if(document.getElementById("manifDaySelection").value > maxD)
		document.getElementById("manifDaySelection").value = (maxD);
}

function updateDayRecurrence()
{
	var maxD = daysInMonth(document.getElementById("recurMonthSelection").value, document.getElementById("recurYearSelection").value);
	var daysList = document.getElementById("recurDaySelection").getElementsByTagName("option");
	for (var i = 0; i < daysList.length; i++)
	{
		(daysList[i].value > maxD) 
		? daysList[i].disabled = true 
		: daysList[i].disabled = false;
	}
	if(document.getElementById("recurDaySelection").value > maxD)
		document.getElementById("recurDaySelection").value = (maxD);
}

function deleteManif(manifID)
{
	if(typeof manifID === "undefined")
	{
		alert("Undefined manifID");
	}
	else
	{
		if(confirm("Souhaitez-vous vraiment supprimer cette manifestation?\n(Supprimera tous les horaires et toutes les réservations associées.)"))
		{
			delurl="deleteManifestation.php";
			$.ajax
			({
				type: 'POST',
				url: delurl,
				data: {mID:manifID},
				async: false,
				cache: false,
				timeout: 30000,
				success: function(data)
				{
					window.location.href = "/";
				},
				error: function(xhr, status, error)
				{
					document.getElementById("manifEditMessg").innerHTML = (xhr.responseText);
					document.getElementById("manifEditMessg").style.color = "#FF0000";
					//alert(xhr.responseText);
				}
			});
		}
	}
}

function getLieuValue()
{
	for (var i=0; i<document.getElementById("lieuSelection").options.length; i++)
	{ 
		if (document.getElementById("lieuSelection").options[i].value == document.getElementById("inputLieuSelection").value)
		{
			return document.getElementById("lieuSelection").options[i].getAttribute("data-value");
		}
	}
	return null;
}

function addManif()
{
	document.getElementById("manifEditMessg").innerHTML = "";
	var respo=document.getElementById("responsaBlesSelection").value;
	if(respo==null)
	{
		document.getElementById("manifEditMessg").innerHTML = "Reponsable Manquant.";
		document.getElementById("manifEditMessg").style.color = "#FF0000";
		return;
	}

	var mD=-1;
	var rD=-1;
	var newLieuID = -1;
	if(document.getElementById("manifTimeStartSelection").value>=document.getElementById("manifTimeEndSelection").value)
	{
		document.getElementById("manifEditMessg").innerHTML = "Veuillez choisir une heure de fin de manifestation supérieur à l'heure de départ.";
		document.getElementById("manifEditMessg").style.color = "#FF0000";
		return;
	}
	if(document.getElementById("reserverLieu").checked)
	{
		newLieuID=getLieuValue();
		if(newLieuID==null)
		{
			document.getElementById("manifEditMessg").innerHTML = "Veuillez choisir un lieu réservé dans la liste.";
			document.getElementById("manifEditMessg").style.color = "#FF0000";
			return;
		}
		if(document.getElementById("reservTimeStartSelection").value>=document.getElementById("reservTimeEndSelection").value)
		{
			document.getElementById("manifEditMessg").innerHTML = "Veuillez choisir une heure de fin de réservation supérieur à l'heure de départ.";
			document.getElementById("manifEditMessg").style.color = "#FF0000";
			return;
		}
		if(document.getElementById("reservTimeStartSelection").value>document.getElementById("manifTimeStartSelection").value || document.getElementById("reservTimeEndSelection").value<document.getElementById("manifTimeEndSelection").value)
		{
			document.getElementById("manifEditMessg").innerHTML = "Les horaires de réservation doivent inclure les horaires de la manifestation.";
			document.getElementById("manifEditMessg").style.color = "#FF0000";
			return;
		}
	}
	mD=document.getElementById("manifYearSelection").value;
	if(document.getElementById("manifMonthSelection").value<10)
		mD+="0";
	mD+=document.getElementById("manifMonthSelection").value;
	if(document.getElementById("manifDaySelection").value<10)
		mD+="0";
	mD+=document.getElementById("manifDaySelection").value;

	var endRecur=document.getElementById("recurYearSelection").value;
	if(document.getElementById("recurMonthSelection").value<10)
		endRecur+="0";
	endRecur+=document.getElementById("recurMonthSelection").value;
	if(document.getElementById("recurDaySelection").value<10)
		endRecur+="0";
	endRecur+=document.getElementById("recurDaySelection").value;

	delurl="newManifestation.php";
	$.ajax
	({
		type: 'POST',
		url: delurl,
		data:
			{
				intitule:document.getElementById("intituleEntry").value,
				type:document.getElementById("typeSelection").value,
				status:document.getElementById("statusSelection").value,
				responsable: respo,
				description:document.getElementById("descriptionText").value,
				observations:document.getElementById("observationsText").value,

				manifDate:mD,
				manifStart:document.getElementById("manifTimeStartSelection").value,
				manifEnd:document.getElementById("manifTimeEndSelection").value,

				lieuID:newLieuID,
				reservStart:document.getElementById("reservTimeStartSelection").value,
				reservEnd:document.getElementById("reservTimeEndSelection").value,

				recurenceID:document.getElementById("recurrenceSelection").value,
				endRecurence:endRecur
			},
		async: false,
		cache: false,
		timeout: 30000,
		success: function(data)
		{
			window.location.href = "?menu=evenement&section=detail&eventID="+data;
		},
		error: function(xhr, status, error)
		{
			document.getElementById("manifEditMessg").innerHTML = (xhr.responseText);
			document.getElementById("manifEditMessg").style.color = "#FF0000";
		}
	});
}

