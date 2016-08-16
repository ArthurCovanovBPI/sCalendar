function loadRespos(page)
{
	if(typeof page === "undefined") {page = 1;}
	$("#responsables").load("respos.php?espaceID=1&page="+page);
}

function deleteRespo(id, respo, page)
{
	if(typeof id === "undefined")
	{
		alert("Undefined ID");
	}
	else if(typeof respo === "undefined")
	{
		alert("Undefined responsable");
	}
	else
	{
		if(confirm("Souhaitez-vous vraiment supprimer le responsable " + respo + "?\n(Supprimera toutes les manifestations et réservations liées à ce responsable!)"))
		{
			delurl="deleteRespo.php";
			$.ajax
			({
				type: 'POST',
				url: delurl,
				data: {respoID:id},
				async: false,
				cache: false,
				timeout: 30000,
				success: function(data)
				{
					loadRespos(page);
				},
				error: function(xhr, status, error)
				{
					alert(xhr.responseText);
				}
			});
		}
	}
	
}

function addRespo(inputRespo, divpage)
{
	if(typeof inputRespo === "undefined")
	{
		alert("Undefined inputRespo");
	}
	else
	{
		name = document.getElementById(inputRespo).value;
		if(!name)
			alert("Veuillez entrer un nom pour le responsable.");
		else if(confirm("Souhaitez-vous vraiment ajouter le responsable " + name + "?"))
		{
			delurl="addRespo.php";
			$.ajax
			({
				type: 'POST',
				url: delurl,
				data: {newRespo:name},
				async: false,
				cache: false,
				timeout: 30000,
				success: function(data)
				{
					loadRespos(Math.ceil(data/divpage));
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
	loadRespos();
}
