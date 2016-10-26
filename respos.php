<?php
	$servername = "127.0.0.1";
	$username = "root";
	$password = "password";
	$dbname = "bpi_calendar";

	$conn = mysql_connect($servername, $username, $password, $dbname);
	if ($conn->connect_error)
	{
		echo
			'<fieldset class="middlePart middleErrorMessage">
				<legend>logs ERROR!</legend>'.
				'Connection failed: ' . $conn->connect_error
			.'</fieldset>'
		;
		exit(1);
	}
	mysql_select_db($dbname, $conn);
	mysql_query('SET character_set_results = "UTF8", character_set_client = "UTF8", character_set_connection = "UTF8", character_set_database = "UTF8", character_set_server = "UTF8"');
	$resultPerPages=40;
?>
<fieldset style="min-height: 120px;">
	<legend>Reponsable</legend>
	<?php
		$page = (isset($_GET['page']) && is_numeric($_GET['page'])) ? (int)$_GET['page'] : 1;

		$sql =
			'SELECT
				COUNT(*) AS count
			FROM responsable'
		;
		$req = mysql_query($sql);
		if(!$req)
		{
			echo('ERROR');
		}
		else
		{
			$data = mysql_fetch_assoc($req);
			$numPages = ceil($data['count']/$resultPerPages);
			if($page>$numPages)$page=$numPages;
			if($page<=0)$page=1;
			echo '<span style="line-height: 17px;">Page ' . $page . '/' . $numPages.'</span>';
			echo '<span style="float: right;">';
				echo '<span onclick="loadRespos(1)" class="pageButton clickablePageButton">≪</span>';
				echo '<span onclick="loadRespos(' . ($page-1) . ')" class="pageButton clickablePageButton"><</span>';
				if($page>3)
				{
					echo '<span class="pageButton">...</span>';
				}
				if($page>2)
				{
					echo '<span onclick="loadRespos(' . ($page-2) . ')" class="pageButton clickablePageButton">' . ($page-2) . '</span>';
				}
				if($page>1)
				{
					echo '<span onclick="loadRespos(' . ($page-1) . ')" class="pageButton clickablePageButton">' . ($page-1) . '</span>';
				}
				echo '<span class="pageButton" style="font-size: 115%; font-weight: bold;">' . ($page) . '</span>';
				if($page<=$numPages-1)
				{
					echo '<span onclick="loadRespos(' . ($page+1) . ')" class="pageButton clickablePageButton">' . ($page+1) . '</span>';
				}
				if($page<=$numPages-2)
				{
					echo '<span onclick="loadRespos(' . ($page+2) . ')" class="pageButton clickablePageButton">' . ($page+2) . '</span>';
				}
				if($page<=$numPages-3)
				{
					echo '<span class="pageButton">...</span>';
				}
				echo '<span onclick="loadRespos(' . ($page+1) . ')" class="pageButton clickablePageButton">></span>';
				echo '<span onclick="loadRespos(' . $numPages . ')" class="pageButton clickablePageButton">≫</span>';
			echo '</span>';
		}
	?>
	<?php
		$sql =	'SELECT
					*
				FROM responsable
				ORDER BY email
				LIMIT ' . $resultPerPages .
				' OFFSET ' . (($page-1)*$resultPerPages)
		;
		$req = mysql_query($sql);
		if(!$req)
		{
			echo('SQL ERROR: ' . $sql . '<br />');
			echo(mysql_errno($conn) . ' : ' . mysql_error($conn));
		}
		else
		{
			echo '<table style="width: 100%; cursor: default; border-collapse: collapse;">';
			$i = 0;
			echo '<tr><th style="padding-left: 2px; padding-right: 2px; text-align: right; width :90%;">Email</th><th>Nom</th><th rowspan=2 style="border-left: double;" title="Admin?">a</th>th colspan=4 style="border-left: double;">Manifestations</th><th colspan=6 style="border-left: double;">Reservations</th><th style="border-left: double;">-</th></tr>';
			echo '<tr><th style="padding-left: 2px; padding-right: 2px; text-align: right; width :90%;">Email</th><th>Nom</th><th style="border-left: double;" title="Contributeur centre?">c</th><th title="Contributeur BPI?">b</th><th title="Contributeur espace externe?">e</th><th title="Contributeur atelier?">a</th><th style="border-left: double;" title="Contributeur manifestations publiques?">mp</th><th title="Contributeur manifestations/reunions internes?">mi</th><th title="Contributeur administratif?">ma</th><th title="Contributeur ressources humaines?">rh</th><th title="Contributeur financier?">f</th><th title="Contributeur événements de type calendaire?">ec</th><th style="border-left: double;">-</th></tr>';
			while($data = mysql_fetch_assoc($req))
			{
				echo '<tr>';
					echo '<td style="padding-left: 2px; padding-right: 2px; white-space: nowrap; text-align: right; width: 100%;">'.$data['email'].'</td>';
					echo '<td style="padding-left: 2px; padding-right: 2px; white-space: nowrap; text-align: right;">'.$data['nom'].'</td>';
					echo '<td style="padding-left: 2px; padding-right: 2px; white-space: nowrap; text-align: center; border-left: double;">'.(($data['admin']==true)? '✓' : '✕').'</td>';
					echo '<td style="padding-left: 2px; padding-right: 2px; white-space: nowrap; text-align: center; border-left: double;">'.(($data['contributeur_centre']==true)? '✓' : '✕').'</td>';
					echo '<td style="padding-left: 2px; padding-right: 2px; white-space: nowrap; text-align: center;">'.(($data['contributeur_bpi']==true)? '✓' : '✕').'</td>';
					echo '<td style="padding-left: 2px; padding-right: 2px; white-space: nowrap; text-align: center;">'.(($data['contributeur_externe']==true)? '✓' : '✕').'</td>';
					echo '<td style="padding-left: 2px; padding-right: 2px; white-space: nowrap; text-align: center;">'.(($data['contributeur_atelier']==true)? '✓' : '✕').'</td>';
					echo '<td style="padding-left: 2px; padding-right: 2px; white-space: nowrap; text-align: center; border-left: double;">'.(($data['contributeur_manif_publique']==true)? '✓' : '✕').'</td>';
					echo '<td style="padding-left: 2px; padding-right: 2px; white-space: nowrap; text-align: center;">'.(($data['contributeur_manif_interne']==true)? '✓' : '✕').'</td>';
					echo '<td style="padding-left: 2px; padding-right: 2px; white-space: nowrap; text-align: center;">'.(($data['contributeur_manif_admin']==true)? '✓' : '✕').'</td>';
					echo '<td style="padding-left: 2px; padding-right: 2px; white-space: nowrap; text-align: center;">'.(($data['contributeur_manif_rh']==true)? '✓' : '✕').'</td>';
					echo '<td style="padding-left: 2px; padding-right: 2px; white-space: nowrap; text-align: center;">'.(($data['contributeur_manif_financier']==true)? '✓' : '✕').'</td>';
					echo '<td style="padding-left: 2px; padding-right: 2px; white-space: nowrap; text-align: center;">'.(($data['contributeur_manif_calendar']==true)? '✓' : '✕').'</td>';
					echo '<td onclick="deleteRespo(\'' . $data['ID'] . '\', \'' . $data['email'] . '\', \'' . $page . '\')" style="padding-left: 2px; padding-right: 2px; white-space: nowrap; text-align: center; font-weight: bold; cursor:pointer; border-left: double;">×</td>';
				echo '</tr>';
			}
			echo '<tr>';
				echo '<td colspan=14 style="padding-left: 2px; padding-right: 2px; border: 1px solid #A0A0A0; white-space: nowrap; text-align: center;">Ajouter un Responsable:</td>';
			echo '</tr>';
			echo '<tr>';
				echo '<td style="white-space: nowrap; text-align: center;"><input id="inputRespoMail" type="text" maxlength="255" style="width: 100%; box-sizing: border-box;" /></td>';
				echo '<td style="white-space: nowrap; text-align: center;"><input id="inputRespoName" type="text" maxlength="255" style="width: 100%; box-sizing: border-box;" /></td>';
				echo '<td style="white-space: nowrap; text-align: center; border-left: double;"><input type="checkbox" id="adminCheck" name="adminCheck" /><label for="adminCheck" /></td>';
				echo '<td style="white-space: nowrap; text-align: center; border-left: double;"><input type="checkbox" id="contribCentreCheck" name="contribCentreCheck" /><label for="contribCentreCheck" /></td>';
				echo '<td style="white-space: nowrap; text-align: center;"><input type="checkbox" id="contribBPICheck" name="contribBPICheck" /><label for="contribBPICheck" /></td>';
				echo '<td style="white-space: nowrap; text-align: center;"><input type="checkbox" id="contribExterneCheck" name="contribExterneCheck" /><label for="contribExterneCheck" /></td>';
				echo '<td style="white-space: nowrap; text-align: center;"><input type="checkbox" id="contribAtelierCheck" name="contribAtelierCheck" /><label for="contribAtelierCheck" /></td>';
				echo '<td style="white-space: nowrap; text-align: center; border-left: double;"><input type="checkbox" id="contribManifPubliqueCheck" name="contribManifPubliqueCheck" /><label for="contribManifPubliqueCheck" /></td>';
				echo '<td style="white-space: nowrap; text-align: center;"><input type="checkbox" id="contribManifInterneCheck" name="contribManifInterneCheck" /><label for="contribManifInterneCheck" /></td>';
				echo '<td style="white-space: nowrap; text-align: center;"><input type="checkbox" id="contribManifAdminCheck" name="contribManifAdminCheck" /><label for="contribManifAdminCheck" /></td>';
				echo '<td style="white-space: nowrap; text-align: center;"><input type="checkbox" id="contribManifRHCheck" name="contribManifRHCheck" /><label for="contribManifRHCheck" /></td>';
				echo '<td style="white-space: nowrap; text-align: center;"><input type="checkbox" id="contribManifFinancierCheck" name="contribManifFinancierCheck" /><label for="contribManifFinancierCheck" /></td>';
				echo '<td style="white-space: nowrap; text-align: center;"><input type="checkbox" id="contribManifCalendarCheck" name="contribManifCalendarCheck" /><label for="contribManifCalendarCheck" /></td>';
				echo '<td onclick="addRespo(\'inputRespoMail\', \'' . $resultPerPages . '\')" style="padding-left: 2px; padding-right: 2px; white-space: nowrap; text-align: center; font-weight: bold; cursor:pointer; border-left: double;">+</td>';
			echo '</tr>';
			echo '</table>';
		}
	?>
</fieldset>
