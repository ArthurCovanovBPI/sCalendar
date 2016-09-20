function displayHeadSelection(d)
{
	var headButtons = document.getElementsByClassName("headButton");
	var headSelections = document.getElementsByClassName("headSelections");
	var i;
	var l = (headSelections.length < headButtons.length)? headSelections.length : headButtons.length ;
	for(i = 0; i < l; i++)
	{
		if(i == d)
		{
			headButtons[i].classList.add("toogled");
			headSelections[i].style.display = "table";
		}
		else
		{
			headButtons[i].classList.remove("toogled");
			headSelections[i].style.display = "none";
		}
	}
}

function disconnect()
{
	var xhr = new XMLHttpRequest();
	xhr.open("GET", "http://portailtest-ldap.bpi.fr/index.pl?logout=1");
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr.send(null);

	xhr.addEventListener('readystatechange', function()
	{
		if(xhr.readyState === XMLHttpRequest.DONE)
		{ // La constante DONE appartient à l'objet XMLHttpRequest, elle n'est pas globale
        		alert();
			var response = JSON.parse(xhr.responseText);
			alert(response);
		}
	});




	/*//var xhttp = new XMLHttpRequest();
	//xhttp.open("GET", "http://portailtest-ldap.bpi.fr/index.pl?logout=1", true);
	//xhttp.send();
	var o = Object.create(null);
	var cartDiv = document.createElement('div');
	cartDiv.id = "unique_id";
	alert();
	document.body.appendChild(cartDiv);
	alert();
	$("#unique_id").load("http://portailtest-ldap.bpi.fr/index.pl?logout=1");
	//mywindow = window.open("http://portailtest-ldap.bpi.fr/index.pl?logout=1", '_blank');
	//mywindow.close();
	alert();
	window.location.reload();*/

	/*disconnecturl="http://portailtest-ldap.bpi.fr/index.pl";
	alert("Disconnection");
	$.ajax
	({
		type: 'POST',
		url: disconnecturl,
		data: {logout:1},
		async: false,
		success: function(data)
		{
			alert("Vous avez été déconnecté.");
			window.location.reload();
		},
		error: function(xhr, status, error)
		{
			alert(xhr.responseText + " " + status + " " + error);
		}
	});*/
}
