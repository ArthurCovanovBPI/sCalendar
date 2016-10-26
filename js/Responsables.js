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
	respoMail = document.getElementById(inputRespoMail).value;
	respoName = document.getElementById(inputRespoName).value;
	respoAdmin = document.getElementById(adminCheck).value;
	respoCentre = document.getElementById(contribCentreCheck).value;
	respoExterne = document.getElementById(contribBPICheck).value;
	respoBPI = document.getElementById(contribExterneCheck).value;
	respoAtelier = document.getElementById(contribAtelierCheck).value;
	respoManifPublique = document.getElementById(contribManifPubliqueCheck).value;
	respoManifInterne = document.getElementById(contribManifInterneCheck).value;
	respoManifAdmin = document.getElementById(contribManifAdminCheck).value;
	respoManifRH = document.getElementById(contribManifRHCheck).value;
	respoManifFiancier = document.getElementById(contribManifFinancierCheck).value;
	respoManifCalendaire = document.getElementById(contribManifCalendarCheck).value;

	alert(respoMail + " - " + respoName + " - " + respoAdmin + " - " + respoCentre + " - " + respoExterne + " - " + respoBPI + " - " + respoAtelier + " - " + respoManifPublique + " - " + respoManifInterne + " - " + respoManifAdmin + " - " + respoManifRH + " - " + respoManifFiancier + " - " + respoManifCalendaire + " - ");

	if(!respoName)
		alert("Veuillez entrer un nom pour le responsable.");
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
