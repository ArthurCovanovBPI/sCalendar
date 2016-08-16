<?php
	if(!isset($_GET['eventID']) || !is_numeric($_GET['eventID']))
	{
		$txtError='Undefined Event ID';
		include('errorFieldSet.php');
	}
	else
	{
		$servername = "127.0.0.1";
		$username = "root";
		$password = "password";
		$dbname = "bpi_calendar";

		$conn = mysql_connect($servername, $username, $password, $dbname);
		if ($conn->connect_error)
		{
			echo
				'<div class="middleParts">
					<div class="middlePart">
						<fieldset class="middlePart middleErrorMessage" style="height: 120px;">
							<legend>logs ERROR!</legend>'.
							'Connection failed: ' . $conn->connect_error
						.'</fieldset>
					</div>
				</div>'
			;
		}
		else
		{
			mysql_select_db($dbname, $conn);
			mysql_query('SET character_set_results = "UTF8", character_set_client = "UTF8", character_set_connection = "UTF8", character_set_database = "UTF8", character_set_server = "UTF8"');
			$sql =
				'SELECT
					intitule,
					tm.type,
					sm.status,
					respo.*,
					observations,
					evenement
				FROM manifestation
				INNER JOIN datesManif AS dm ON dm.manifestation_ID = manifestation.ID
				INNER JOIN status_manifestation AS sm ON manifestation.status_manifestation_ID = sm.ID
				INNER JOIN type_manifestation AS tm ON manifestation.type_manifestation_ID = tm.ID
				INNER JOIN responsable AS respo ON manifestation.responsable_ID = respo.ID
				WHERE manifestation.ID = ' . $_GET['eventID']
			;
			$req = mysql_query($sql);
			if(!$req)
			{
				echo
					'<div class="middleParts">
						<div class="middlePart">
							<fieldset class="middlePart middleErrorMessage" style="height: 120px;">
								<legend>SQL ERROR!</legend>'.
								(mysql_errno($conn) . ' : ' . mysql_error($conn))
							.'</fieldset>
						</div>
					</div>'
				;
			}
			else
			{
				$data = mysql_fetch_assoc($req);
				$numRows=mysql_num_rows($req);
				if($numRows<1)
				{
					echo
						'<div class="middleParts">
							<div class="middlePart">
								<fieldset class="middlePart middleErrorMessage" style="height: 120px;">
									<legend>EventID ERROR</legend>
									Missing event with ID=='.$_GET['eventID'].
								'</fieldset>
							</div>
						</div>'
					;
				}
				else
				{
					echo
						'<div class="middleParts">
							<div class="middlePart">
								<fieldset>
									<legend>Manifestation</legend>'.
									'Intitulé: ' . $data['intitule'] . '<br />'.
									$data['type'].'<br />'.
									'Status: ' . $data['status'].'<br />'
								.'</fieldset>
							</div>
							<div class="middlePart">
								<fieldset class="middlePart">
									<legend>Reponsable</legend>'.
									$data['nom']
								.'</fieldset>
							</div>
						</div>'
					;

					echo
						'<div class="middleParts">
							<div class="middlePart" style="width:50%;">
								<fieldset>
									<legend>Horaires</legend>'/*.
									(
										($data['recurrence']==null)
										?
										('')
										:
										('Récurrence: ' . $data['recurrence'] . ' jusqu\'au ' . $data['fin_recurence_day'].'/'.$data['fin_recurence_month'].'/'.$data['fin_recurence_year'] )
									).'<br />'*/
					;
					$sql = 
						'SELECT
							debut_manif,
							fin_manif,
							manifestation.ID
						FROM manifestation
						INNER JOIN datesManif AS dm ON dm.manifestation_ID = manifestation.ID
						WHERE manifestation.ID = ' . $_GET['eventID']
					;
					$req = mysql_query($sql);
					if(!$req)
					{
						echo
							'<fieldset class="middlePart middleErrorMessage" style="height: 120px;">
								<legend>SQL ERROR!</legend>'.
								(mysql_errno($conn) . ' : ' . mysql_error($conn))
							.'</fieldset>'
						;
					}
					else
					{
						while($datesManif = mysql_fetch_assoc($req))
							echo
								(
									(
										(strcmp(substr($datesManif['debut_manif'], 6, 2), substr($datesManif['fin_manif'], 6, 2)) != 0 || strcmp(substr($datesManif['debut_manif'], 4, 2), substr($datesManif['fin_manif'], 4, 2)) != 0 || strcmp(substr($datesManif['debut_manif'], 0, 4), substr($datesManif['fin_manif'], 0, 4)) != 0)
										?
											('Du '.substr($datesManif['debut_manif'], 6, 2).'/'.substr($datesManif['debut_manif'], 4, 2).'/'.substr($datesManif['debut_manif'], 0, 4).' à '.substr($datesManif['debut_manif'], 8, 2) . 'h' . substr($datesManif['debut_manif'], -2).
											' au '.substr($datesManif['fin_manif'], 6, 2).'/'.substr($datesManif['fin_manif'], 4, 2).'/'.substr($datesManif['fin_manif'], 0, 4).' à '.substr($datesManif['fin_manif'], 8, 2) . 'h' . substr($datesManif['fin_manif'], -2).'<br />')
										:
											('Le '.substr($datesManif['debut_manif'], 6, 2).'/'.substr($datesManif['debut_manif'], 4, 2).'/'.substr($datesManif['debut_manif'], 0, 4).' de '.substr($datesManif['debut_manif'], 8, 2) . 'h' . substr($datesManif['debut_manif'], -2) . ' à ' . substr($datesManif['fin_manif'], 8, 2) . 'h' . substr($datesManif['fin_manif'], -2).'<br />')
									)
								)
							;
					}
					echo
								'</fieldset>
							</div>'
					;
					echo
							'<div class="middlePart" style="width:50%;">
								<fieldset class="middlePart">
									<legend>Reservations</legend>'
					;
					$sql = 
						'SELECT
							l.lieu,
							dates_manifestation_ID,
							debut_reservation,
							fin_reservation
						FROM reservation
						INNER JOIN datesManif AS dm ON reservation.dates_manifestation_ID = dm.ID
						INNER JOIN manifestation AS manif ON dm.manifestation_ID = manif.ID
						INNER JOIN lieu AS l ON reservation.lieu_ID = l.ID
						WHERE manif.ID = ' . $_GET['eventID']
					;
					$req = mysql_query($sql);
					//echo $sql;
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
						while($reservations = mysql_fetch_assoc($req))
							echo
								$reservations['lieu'].' '.
								(
									(
										(strcmp(substr($reservations['debut_reservation'], 6, 2), substr($reservations['fin_reservation'], 6, 2)) != 0 || strcmp(substr($reservations['debut_reservation'], 4, 2), substr($reservations['fin_reservation'], 4, 2)) != 0 || strcmp(substr($reservations['debut_reservation'], 0, 4), substr($reservations['fin_reservation'], 0, 4)) != 0)
										?
											('Du '.substr($reservations['debut_reservation'], 6, 2).'/'.substr($reservations['debut_reservation'], 4, 2).'/'.substr($reservations['debut_reservation'], 0, 4).' à '.substr($reservations['debut_reservation'], 8, 2) . 'h' . substr($reservations['debut_reservation'], -2).
											' au '.substr($reservations['fin_reservation'], 6, 2).'/'.substr($reservations['fin_reservation'], 4, 2).'/'.substr($reservations['fin_reservation'], 0, 4).' à '.substr($reservations['fin_reservation'], 8, 2) . 'h' . substr($reservations['fin_reservation'], -2).'<br />')
										:
											('Le '.substr($reservations['debut_reservation'], 6, 2).'/'.substr($reservations['debut_reservation'], 4, 2).'/'.substr($reservations['debut_reservation'], 0, 4).' de '.substr($reservations['debut_reservation'], 8, 2) . 'h' . substr($reservations['debut_reservation'], -2) . ' à ' . substr($reservations['fin_reservation'], 8, 2) . 'h' . substr($reservations['fin_reservation'], -2).'<br />')
									)
								)
							;
					}
					echo
								'</fieldset>
							</div>'
					;
					echo
						'</div>'
					;

					if($data['evenement']!=null||$data['observations']!=null)
					{
						echo
							'<div class="middleParts">'
						;
						if($data['evenement']!=null)
							echo
								'<div class="middlePart">
									<fieldset style="min-height: 120px;">
										<legend>Description</legend>'.
										$data['evenement']
									.'</fieldset>
								</div>'
							;
						if($data['observations']!=null)
							echo
								'<div class="middlePart">
									<fieldset style="min-height: 120px;">
										<legend>Observations</legend>'.
										$data['observations']
									.'</fieldset>
								</div>'
							;
						echo
							'</div>'
						;
					}
				}
			}
		}
	}
?>
