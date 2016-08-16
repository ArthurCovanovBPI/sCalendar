function loadLieu(numLieu, page)
{
	if(typeof page === "undefined") {page = 1;}
	$("#lieu"+numLieu).load("lieu.php?espaceID="+numLieu+"&page="+page);
}

function deleteLieu(id, lieu, espaceID, espace, page)
{
	if(typeof id === "undefined")
	{
		alert("Undefined ID");
	}
	else if(typeof lieu === "undefined")
	{
		alert("Undefined Lieu");
	}
	else if(typeof espaceID === "undefined")
	{
		alert("Undefined EspaceID");
	}
	else if(typeof espace === "undefined")
	{
		alert("Undefined Espace");
	}
	else
	{
		if(confirm("Souhaitez-vous vraiment supprimer " + lieu + " de l'espace " + espace +"?\n(Supprimera toutes les réservations liées à ce lieu!)"))
		{
			delurl="deleteLieu.php";
			$.ajax
			({
				type: 'POST',
				url: delurl,
				data: {lieuID:id},
				async: false,
				cache: false,
				timeout: 30000,
				success: function(data)
				{
					loadLieu(espaceID, page);
				},
				error: function(xhr, status, error)
				{
					alert(xhr.responseText);
				}
			});
		}
	}
	
}

function addLieu(lieu, espaceID, espace, page)
{
	if(typeof lieu === "undefined")
	{
		alert("Undefined Lieu");
	}
	else if(typeof espaceID === "undefined")
	{
		alert("Undefined EspaceID");
	}
	else if(typeof espace === "undefined")
	{
		alert("Undefined Espace");
	}
	else
	{
		newlieu = document.getElementById(lieu).value;
		if(!newlieu)
			alert("Veuillez entrer un lieu.");
		else if(confirm("Souhaitez-vous vraiment ajouter " + newlieu + " à l'espace " + espace +"?"))
		{
			delurl="addLieu.php";
			$.ajax
			({
				type: 'POST',
				url: delurl,
				data: {eID:espaceID, lieuID:newlieu},
				async: false,
				cache: false,
				timeout: 30000,
				success: function(data)
				{
					loadLieu(espaceID, page+1);
				},
				error: function(xhr, status, error)
				{
					alert(xhr.responseText);
				}
			});
		}
	}
}

function editLieu(lieu)
{
    var my = document.getElementById('seeLieu'+lieu).style.display="none";
    var my = document.getElementById('editLieu'+lieu).style.display="table-row";
}

function cancelEditLieu(lieu)
{
    var my = document.getElementById('seeLieu'+lieu).style.display="table-row";
    var my = document.getElementById('editLieu'+lieu).style.display="none";
}

function uploadLieu(oldname, lieuID, espaceID, espace, page)
{
	if(typeof lieuID === "undefined")
	{
		alert("Undefined lieuID");
	}
	else if(typeof espaceID === "undefined")
	{
		alert("Undefined EspaceID");
	}
	else if(typeof espace === "undefined")
	{
		alert("Undefined Espace");
	}
	else
	{
		newname = document.getElementById("editionlieu"+lieuID).value;
		if(newname == oldname)
		{
			cancelEditLieu(lieuID);
			return;
		}
		if(!newname)
			alert("Veuillez entrer un lieu.");
		else if(confirm("Souhaitez-vous vraiment renommer " + oldname + " en " + newname +"?"))
		{
			delurl="editLieu.php";
			$.ajax
			({
				type: 'POST',
				url: delurl,
				data: {lID:lieuID, name:newname},
				async: false,
				cache: false,
				timeout: 30000,
				success: function(data)
				{
					loadLieu(espaceID, page+1);
				},
				error: function(xhr, status, error)
				{
					alert(xhr.responseText);
				}
			});
		}
	}
}

window.onload = function()
{
	loadLieu(1);
	loadLieu(2);
	loadLieu(3);
	loadLieu(4);
}
