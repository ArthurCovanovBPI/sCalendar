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
	respoMail = document.getElementById("inputRespoMail").value;
	respoName = document.getElementById("inputRespoName").value;
	respoAdmin = document.getElementById("adminCheck").checked;
	respoCentre = document.getElementById("contribCentreCheck").checked;
	respoExterne = document.getElementById("contribBPICheck").checked;
	respoBPI = document.getElementById("contribExterneCheck").checked;
	respoAtelier = document.getElementById("contribAtelierCheck").checked;
	respoManifPublique = document.getElementById("contribManifPubliqueCheck").checked;
	respoManifInterne = document.getElementById("contribManifInterneCheck").checked;
	respoManifAdmin = document.getElementById("contribManifAdminCheck").checked;
	respoManifRH = document.getElementById("contribManifRHCheck").checked;
	respoManifFiancier = document.getElementById("contribManifFinancierCheck").checked;
	respoManifCalendaire = document.getElementById("contribManifCalendarCheck").checked;

	alert(respoMail + " - " + respoName + " - " + respoAdmin + " - " + respoCentre + " - " + respoExterne + " - " + respoBPI + " - " + respoAtelier + " - " + respoManifPublique + " - " + respoManifInterne + " - " + respoManifAdmin + " - " + respoManifRH + " - " + respoManifFiancier + " - " + respoManifCalendaire + " - ");

	if(!respoMail)
		alert("Veuillez entrer un mail pour le responsable.");
	if(!respoName)
		alert("Veuillez entrer un nom pour le responsable.");

	if(!respoCentre && !respoExterne && !respoBPI && !respoAtelier)
		alert("Veuillez autoriser au moins 1 type de manifestation.");

	else if(confirm("Souhaitez-vous vraiment ajouter le responsable " + name + "?"))
	{

		return;
		delurl="addRespo.php";
		$.ajax
		({
			type: 'POST',
			url: delurl,
			data: {name:respoName},
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

window.onload = function()
{
	loadRespos();
}
