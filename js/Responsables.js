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
	respoAtelier = document.getElementById("contribAtelierCheck").checked;
	respoManifPublique = document.getElementById("contribManifPubliqueCheck").checked;
	respoManifInterne = document.getElementById("contribManifInterneCheck").checked;
	respoManifAdmin = document.getElementById("contribManifAdminCheck").checked;
	respoManifRH = document.getElementById("contribManifRHCheck").checked;
	respoManifFiancier = document.getElementById("contribManifFinancierCheck").checked;
	respoManifCalendaire = document.getElementById("contribManifCalendarCheck").checked;
	respoAdmin = document.getElementById("adminCheck").checked;
	respoCentre = document.getElementById("contribCentreCheck").checked;
	respoExterne = document.getElementById("contribBPICheck").checked;
	respoBPI = document.getElementById("contribExterneCheck").checked;

	message = "";
	if(!respoMail)
		message += "Veuillez entrer un mail pour le responsable.\n";
	if(!respoName)
		message += "Veuillez entrer un nom pour le responsable.\n";

	if(!respoManifPublique && !respoManifInterne && !respoManifAdmin && !respoManifRH && !respoManifFiancier && !respoManifCalendaire)
		message += "Veuillez autoriser au moins un type de manifestation (mp/mi/ma/rh/f/ec).";
	if(message != "")
		alert(message);
	else if(confirm("Souhaitez-vous vraiment ajouter le responsable " + respoName + "?"))
	{
		addurl="addRespo.php";
		$.ajax
		({
			type: 'POST',
			url: addurl,
			data: {mail:respoMail, name:respoName, admin:respoAdmin, manifPublique:respoManifPublique, manifInterne:respoManifInterne, manifAdmin:respoManifAdmin, manifRH:respoManifRH, manifFiancier:respoManifFiancier, manifCalendaire:respoManifCalendaire, centre:respoCentre, externe:respoExterne, BPI:respoBPI, atelier:respoAtelier},
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

function editRespo(respo)
{
    var my = document.getElementById('viewRespo'+respo).style.display="none";
    var my = document.getElementById('editRespo'+respo).style.display="table-row";
}

function cancelEditRespo(respo)
{
    var my = document.getElementById('viewRespo'+respo).style.display="table-row";
    var my = document.getElementById('editRespo'+respo).style.display="none";
}

window.onload = function()
{
	loadRespos();
}
