<div class="middleParts">
	<div class="middlePart">
	<?php
		if(isset($_GET['eventID']) && is_numeric($_GET['eventID']))
		{
			$servername = "127.0.0.1";
			$username = "root";
			$password = "password";
			$dbname = "bpi_calendar";

			$conn = mysql_connect($servername, $username, $password, $dbname);
			if ($conn->connect_error)
			{
				echo
					'<fieldset class="middlePart middleErrorMessage" style="height: 120px;">
						<legend>logs ERROR!</legend>'.
						'Connection failed: ' . $conn->connect_error
					.'</fieldset>'
				;
			}
			else
			{
				mysql_select_db($dbname, $conn);
				mysql_query('SET character_set_results = "UTF8", character_set_client = "UTF8", character_set_connection = "UTF8", character_set_database = "UTF8", character_set_server = "UTF8"');
				$sql = 
					'SELECT
					debut_manif,
					fin_manif,
					intitule,
					observations,
					evenement,
					respo.nom,
					l.lieu,
					manifestation.ID
					FROM manifestation
					INNER JOIN datesManif AS dm ON dm.manifestation_ID = manifestation.ID
					LEFT JOIN reservation AS r ON r.dates_manifestation_ID = dm.ID
					LEFT JOIN lieu AS l ON r.lieu_ID = l.ID
					INNER JOIN responsable AS respo ON manifestation.responsable_ID = respo.ID
					INNER JOIN type_manifestation AS tm ON manifestation.type_manifestation_ID = tm.ID
					WHERE manifestation.ID = ' . $_GET['eventID']
				;
				$req = mysql_query($sql);
				if(!$req)
				{
					echo
						'<fieldset class="middlePart middleErrorMessage" style="height: 120px;">
							<legend>SQL ERROR!</legend>'.
							mysql_error()
						.'</fieldset>'
					;
				}
				else
				{
					$data = mysql_fetch_assoc($req);
					echo
						'<fieldset style="height: 135px;">
							<legend>'.$data['intitule'].'</legend>'.
							(
								(
									(strcmp(substr($data['debut_manif'], 6, 2), substr($data['fin_manif'], 6, 2)) != 0 || strcmp(substr($data['debut_manif'], 4, 2), substr($data['fin_manif'], 4, 2)) != 0 || strcmp(substr($data['debut_manif'], 0, 4), substr($data['fin_manif'], 0, 4)) != 0)
									?
										('Du '.substr($data['debut_manif'], 6, 2).'/'.substr($data['debut_manif'], 4, 2).'/'.substr($data['debut_manif'], 0, 4).' à '.substr($data['debut_manif'], 8, 2) . 'h' . substr($data['debut_manif'], -2).'<br />'.
										'Au '.substr($data['fin_manif'], 6, 2).'/'.substr($data['fin_manif'], 4, 2).'/'.substr($data['fin_manif'], 0, 4).' à '.substr($data['fin_manif'], 8, 2) . 'h' . substr($data['fin_manif'], -2).'<br />')
									:
										('Le '.substr($data['debut_manif'], 6, 2).'/'.substr($data['debut_manif'], 4, 2).'/'.substr($data['debut_manif'], 0, 4).' de '.substr($data['debut_manif'], 8, 2) . 'h' . substr($data['debut_manif'], -2) . ' à ' . substr($data['fin_manif'], 8, 2) . 'h' . substr($data['fin_manif'], -2).'<br />')
								)
							).
							(($data['lieu'] != null)?'Lieu: '.$data['lieu'].'<br />' : '').
							'Responsable: '.$data['nom'].'<br />'.
							'Observations: '.$data['observations'].'<br />'.
							'Description: '.$data['evenement']
						.'</fieldset>'
					;
				}
			}
		}
		else
		{
			echo
				'<fieldset class="middlePart middleErrorMessage" style="height: 120px;">
					<legend>ERROR!</legend>'.
					'eventID error: ' . $_GET['eventID']
				.'</fieldset>'
			;
		}
	?>
	</div>
</div>
