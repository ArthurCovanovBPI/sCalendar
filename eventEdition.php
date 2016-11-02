<?php
	$allHeaders = getallheaders();
	if(!isset($_GET['eventID']) || !is_numeric($_GET['eventID']))
	{
		$txtError='Undefined Event ID';
		include('errorFieldSet.php');
	}
	else if(!array_key_exists("AuthUser", $allHeaders))
	{
		$txtError='Authentification Error';
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
					responsable_mail,
					observations,
					evenement
				FROM manifestation
				INNER JOIN datesManif AS dm ON dm.manifestation_ID = manifestation.ID
				INNER JOIN status_manifestation AS sm ON manifestation.status_manifestation_ID = sm.ID
				INNER JOIN type_manifestation AS tm ON manifestation.type_manifestation_ID = tm.ID
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
				else if($data['responsable_mail'] != $allHeaders[AuthUser])
				{
					$txtError='Access denied!';
					include('errorFieldSet.php');
				}
				else
				{

					$sql ='SELECT * FROM responsable WHERE email = "' . $allHeaders[AuthUser] . '"';
					$req = mysql_query($sql);
					if($req)
					{
						$respo = mysql_fetch_assoc($req);

						echo
							'<div class="middleParts">
								<div class="middlePart" style="text-align: right;">
									<fieldset>
										<legend>Commandes</legend>
										<table style="width: 100%; border: none; background-color: inherit; border-collapse: collapse;">
											<tr style="border: none; background-color: inherit;">
												<td style="width: 100%; border: none; background-color: inherit;"><span id="manifEditMessg" style="width: 100%; text-align: left; display: inline-block;"></span></td>
												<td style="border: none; background-color: inherit;""><button id="savebutton" type="button" style="margin-left: 2px; margin-right: 2px;" onclick="updateManif(' . $_GET['eventID'] . ')">Enregistrer</button></td>
												<td style="border: none; background-color: inherit;""><button id="resetbutton" class="danger" style="white-space: nowrap;" type="button" onclick="deleteManif(' . $_GET['eventID'] . ')">&#x26a0 Supprimer la manifestation &#x26A0</button></td>
											</tr>
										</table>
									</fieldset>
								</div>
							</div>'
						;
						$intitule = str_replace('"', '&#34', $data['intitule']);
						echo
							'<div class="middleParts">
								<div class="middlePart">
									<fieldset>
										<legend>Manifestation</legend>'.
										'<label for="intituleEntry">Intitué: </label>'.
										'<input id="intituleEntry" type="text" name="nom" size="40" maxlength="255"  value="' . $intitule . '" /><br />'
						;



						$sql ='SELECT * FROM type_manifestation';

						$req = mysql_query($sql);
						if(!$req)
						{
							echo 'No status found :' . (mysql_errno($conn) . ' : ' . mysql_error($conn));
						}
						else
						{
							echo
										'<label for="typeSelection">Type: </label>'.
										'<select name="typeSelection" id="typeSelection">'
							;
				
							//Manifestation publique	
							$type = mysql_fetch_assoc($req);
							if($respo['contributeur_manif_publique']==true)
								echo		'<option value="' . $type['ID'] . '">' . $type['type'] . '</option>';

							//Manfestation / réunion interne
							$type = mysql_fetch_assoc($req);
							if($respo['contributeur_manif_interne']==true)
								echo		'<option value="' . $type['ID'] . '">' . $type['type'] . '</option>';

							//Administratif (pas d''envoi à la presse)
							$type = mysql_fetch_assoc($req);
							if($respo['contributeur_manif_admin']==true)
								echo		'<option value="' . $type['ID'] . '">' . $type['type'] . '</option>';

							//RH (pas d''envoi à la presse)
							$type = mysql_fetch_assoc($req);
							if($respo['contributeur_manif_rh']==true)
								echo		'<option value="' . $type['ID'] . '">' . $type['type'] . '</option>';

							//Financier (pas d''envoi à la presse)
							$type = mysql_fetch_assoc($req);
							if($respo['contributeur_manif_financier']==true)
								echo		'<option value="' . $type['ID'] . '">' . $type['type'] . '</option>';

							//Évènement de type calendaire (vacances, jours fériés)
							$type = mysql_fetch_assoc($req);
							if($respo['contributeur_manif_calendar']==true)
								echo		'<option value="' . $type['ID'] . '">' . $type['type'] . '</option>';

							echo
										'</select><br />'
							;
						}

						$sql ='SELECT * FROM status_manifestation';

						$req = mysql_query($sql);
						if(!$req)
						{
							echo 'No status found :' . (mysql_errno($conn) . ' : ' . mysql_error($conn));
						}
						else
						{
							echo
										'<label for="statusSelection">Status: </label>'.
										'<select onchange="testStatus(this)" name="statusSelection" id="statusSelection">'
							;

							while($status = mysql_fetch_assoc($req))
							{
								echo
											'<option value="'.$status['ID'].'" ' . ((strcmp($status['status'], $data['status'])==0)? 'selected' : '') . '>' . $status['status'] . '</option>'
								;

						
							}

							echo
										'</select>'.
										'<span id="statusAnnule" style="color: #FF0000; ' . ((strcmp('Annulée', $data['status'])!=0)? 'visibility: hidden;' : '') . '"> Attention: Supprimera toutes les réservations!</span>'
							;
						}

						echo
										(
											($data['recurrence']==null)
											?
											('')
											:
											('Récurrence: ' . $data['recurrence'] . ' jusqu\'au ' . $data['fin_recurence_day'].'/'.$data['fin_recurence_month'].'/'.$data['fin_recurence_year'] )
										)
									.'</fieldset>
								</div>'
						;
						echo
								'<div class="middlePart">
									<fieldset class="middlePart">
										<legend>Reponsable</legend>
										<label for="intituleEntry">Email: </label>
										<input id="responsaBlesSelection" type="text" name="email" value="'.$data['responsable_mail'].'" disabled /><br />
									</fieldset>
								</div>'
						;
						echo
							'</div>'
						;

						echo
							'<div class="middleParts">
								<div class="middlePart">
									<fieldset>
										<legend>Horaires</legend>'
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
								'<div class="middlePart">
									<fieldset id="reservationFieldSet" class="middlePart' . ((strcmp('Annulée', $data['status'])!=0)? '' : ' middleErrorMessage') . '">
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

						$curDate = getdate();
						$curDay = $curDate[mday];
						if($curDay < 10)
							$curDay = '0'.$curDay;
						$curMonth = $curDate[mon];
						if($curMonth < 10)
							$curMonth = '0'.$curMonth;
						$curYear = $curDate[year];
						echo
							'<div class="middleParts">'
						;
						echo
								'<div class="middlePart">
									<fieldset>
										<legend>Nouveaux Horaires et Reservations</legend>
										<input onclick="newTimes();" type="checkbox" id="remplacerHoraires" name="remplacerHoraires" />
										<label for="remplacerHoraires">Définir de nouveaux horaires pour la manifestation</label>
										<div id="warnRemplacement" style="display: none;">
											<span style="color: #FF0000;">Attention: Remplacera les Horaires et les Réservations actuelles!</span>
											<div>'
						;

						echo
												'<label for="manifDate">Le: </label>'.
												'<input id="manifDate" onkeydown="return false;" type="date" name="manifDate" value="'.$curYear.'-'.$curMonth.'-'.$curDay.'" />'
						;

						echo
												' De: <span class="spinsIn"><input id="manifStartTime" type="time" onkeydown="return false;" name="manifStart" min="08:00" max="21:30" value="08:00" step="1800" required="required" /><!--<input onclick="upManifStart();" type="button" value="UP" /><input onclick="downManifStart();" type="button" value="DOWN" />--><span class="spins"><span onclick="upManifStart();" class="spinBoxUp"><span></span></span><span onclick="downManifStart();" class="spinBoxDown"><span></span></span></span></span>'.
												' à: <span class="spinsIn"><input id="manifEndTime" type="time" onkeydown="return false;" name="manifEnd" min="08:30" max="22:00" value="08:30" step="1800" required="required" /><!--<input onclick="upManifEnd();" type="button" value="UP" /><input onclick="downManifEnd()" type="button" value="DOWN" />--><span class="spins"><span onclick="upManifEnd();" class="spinBoxUp"><span></span></span><span onclick="downManifEnd();" class="spinBoxDown"><span></span></span></span></span>'
						;

						echo					'<br />';

						if($respo[contributeur_centre]==true || $respo[contributeur_bpi]==true || $respo[contributeur_externe]==true || $respo[contributeur_atelier]==true)
						{
							echo
													'<input onclick="newReservation(this);" type="checkbox" id="reserverLieu" name="reserverLieu" />
													<label for="reserverLieu">Ajouter une reservation.</label>'
							;
							echo
													'<div id="reservationLieu" style="display: none;">'
							;
							$sql ='SELECT * FROM espace';

							$req = mysql_query($sql);
							if(!$req)
							{
								echo 'No espace found :' . (mysql_errno($conn) . ' : ' . mysql_error($conn));
							}
							else
							{
								echo
														'<label for="espaceSelection"> Dans l\'espace: </label>'.
														'<select onchange="updateLieux()" name="espaceSelection" id="espaceSelection">'
								;

								//Espaces Centre	
								$espace = mysql_fetch_assoc($req);
								if($respo['contributeur_centre']==true)
									echo				'<option value="'.$espace['ID'].'">' . $espace['espace'] . '</option>';

								//Espaces BPI
								$espace = mysql_fetch_assoc($req);
								if($respo['contributeur_bpi']==true)
									echo				'<option value="'.$espace['ID'].'">' . $espace['espace'] . '</option>';

								//Hors les murs
								$espace = mysql_fetch_assoc($req);
								if($respo['contributeur_externe']==true)
									echo				'<option value="'.$espace['ID'].'">' . $espace['espace'] . '</option>';

								//Atelier
								$espace = mysql_fetch_assoc($req);
								if($respo['contributeur_atelier']==true)
									echo				'<option value="'.$espace['ID'].'">' . $espace['espace'] . '</option>';

								echo
														'</select>'
								;

								echo
														'<datalist id="lieuSelection">'
								;
								echo 					'<span id="lieuxSpan">';
								$eID=1;
								include('lieuDataList.php');
								echo 					'</span>';
								echo
														'</datalist>'.
														'<label for="lieuSelection"> Dans le lieu: </label>'.
														'<input id="inputLieuSelection" onchange="getLieuValue();" list="lieuSelection" />'
								;

								echo
												' De: <span class="spinsIn"><input id="reservStartTime" type="time" onkeydown="return false;" name="manifStart" min="08:00" max="21:30" value="08:00" step="1800" required="required" /><!--<input onclick="upReservStart();" type="button" value="UP" /><input onclick="downReservStart();" type="button" value="DOWN" />--><span class="spins"><span onclick="upReservStart();" class="spinBoxUp"><span></span></span><span onclick="downReservStart();" class="spinBoxDown"><span></span></span></span></span>'.
												' à: <span class="spinsIn"><input id="reservEndTime" type="time" onkeydown="return false;" name="manifEnd" min="08:30" max="22:00" value="08:30" step="1800" required="required" /><!--input onclick="upReservEnd();" type="button" value="UP" /><input onclick="downReservEnd()" type="button" value="DOWN" />--><span class="spins"><span onclick="upReservEnd();" class="spinBoxUp"><span></span></span><span onclick="downReservEnd();" class="spinBoxDown"><span></span></span></span></span>'
								;
					
							}
							echo
													'</div>'
							;
						}

						echo					'<div>';

						$sql ='SELECT * FROM recurrence_manifestation';

						$req = mysql_query($sql);
						if(!$req)
						{
							echo 'No recurrence found :' . (mysql_errno($conn) . ' : ' . mysql_error($conn));
						}
						else
						{
							echo
													'<label for="statusSelection">Recurrence: </label>'.
													'<select onchange="testRecurrence(this)" name="recurrenceSelection" id="recurrenceSelection">'
							;

							while($recurrence = mysql_fetch_assoc($req))
							{
								echo
														'<option value="'.$recurrence['ID'].'">' . $recurrence['recurrence'] . '</option>'
								;

						
							}

							echo
													'</select>'.
													'<span id="recurrenceEnd" style="visibility:hidden;">'
							;
							echo
														'<label for="recurDaySelection"> Jusqu\'au: </label>'.
														'<select name="recurDaySelection" id="recurDaySelection">'
							;

							for($i=1; $i<=31; $i++)
							{
								echo
															'<option value="'.$i.'"'. (($i==$curDay)? ' selected' : '') .'>' . $i . '</option>'
								;
							}

							echo
														'</select>'
							;
							echo
														'<label for="recurMonthSelection"> - </label>'.
														'<select onchange="updateDayRecurrence()" name="recurMonthSelection" id="recurMonthSelection">'
							;

							for($i=1; $i<=12; $i++)
							{
								echo
															'<option value="'.$i.'"'. (($i==$curMonth)? ' selected' : '') .'>' . $i . '</option>'
								;
							}

							echo
														'</select>'
							;
							echo
														'<label for="recurYearSelection"> - </label>'.
														'<select onchange="updateDayRecurrence()" name="recurYearSelection" id="recurYearSelection">'
							;

							for($i=(date("Y")-10); $i<=(date("Y")+20)&&$i<=2037; $i++)
							{
								echo
															'<option value="'.$i.'"'. (($i==$curYear)? ' selected' : '') .'>' . $i . '</option>'
								;
							}

							echo
														'</select>'
							;
							echo
													'</span>'
							;
						}
						echo					'</div>';
	
						echo
											'</div>
										</div>
									</fieldset>
								</div>'
						;
						echo
							'</div>'
						;

						echo
							'<div class="middleParts">'
						;
						$description = str_replace('"', '&#34', $data['evenement']);
						echo
								'<div class="middlePart" style="width:50%;">
									<fieldset>
										<legend>Description</legend>
										<textarea name="description" id="descriptionText" rows="5" cols="40" style="width:100%; min-height: 120px; resize: vertical;">'.
											(($description!=null)?$description:'')
										.'</textarea>
									</fieldset>
								</div>'
						;
						$observations = str_replace('"', '&#34', $data['observations']);
						echo
								'<div class="middlePart" style="width:50%;">
									<fieldset>
										<legend>Observations</legend>
										<textarea name="observations" id="observationsText" rows="5" cols="40" style="width:100%; min-height: 120px; resize: vertical;">'.
											(($observations!=null)?$observations:'')
										.'</textarea>
									</fieldset>
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
