<?php
	if(isset($_GET['timeStamp']) && is_numeric($_GET['timeStamp']))
	{
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

		$curdate=getdate($_GET['timeStamp']);
		$txt = '';
		if(!isset($_GET['month']) || $_GET['month']!="true")
		{
			switch($curdate['wday'])
			{
				case 1:
					$txt .= 'Lundi';
				break;
				case 2:
					$txt .= 'Mardi';
				break;
				case 3:
					$txt .= 'Mercredi';
				break;
				case 4:
					$txt .= 'Jeudi';
				break;
				case 5:
					$txt .= 'Vendredi';
				break;
				case 6:
					$txt .= 'Samedi';
				break;
				default:
					$txt .= 'Dimanche';
				break;
			}
			$txt .= (' ' . $curdate['mday'] . ' ');
		}
		switch($curdate['mon'])
		{
			case 1:
				$txt .= 'Janvier';
			break;
			case 2:
				$txt .= 'Fevrier';
			break;
			case 3:
				$txt .= 'Mars';
			break;
			case 4:
				$txt .= 'Avril';
			break;
			case 5:
				$txt .= 'Mai';
			break;
			case 6:
				$txt .= 'Juin';
			break;
			case 7:
				$txt .= 'Juillet';
			break;
			case 8:
				$txt .= 'Aout';
			break;
			case 9:
				$txt .= 'Septembre';
			break;
			case 10:
				$txt .= 'Octobre';
			break;
			case 11:
				$txt .= 'Novembre';
			break;
			default:
				$txt .= 'Décembre';
			break;
		}
		$txt .= (' ' . $curdate['year']);
	}
	else
	{
		$txt = 'Description';
	}
?>
<div class="middleParts">
	<div class="middlePart">
		<fieldset style="height: 135px;">
			<legend><?php echo($txt);?></legend>
			<?php
				mysql_select_db($dbname, $conn);
				mysql_query('SET character_set_results = "UTF8", character_set_client = "UTF8", character_set_connection = "UTF8", character_set_database = "UTF8", character_set_server = "UTF8"');
				//$sql = 'SELECT * FROM manifestation WHERE debut_manif_date >= FROM_UNIXTIME(' . (intval($_GET['timeStamp'])) . ') AND fin_manif_date >= FROM_UNIXTIME(' . $_GET['timeStamp'] . ')';
				//$sql = 'SELECT * FROM manifestation WHERE debut_manif_date <= FROM_UNIXTIME(' . (intval($_GET['timeStamp'])+86400) . ') AND fin_manif_date > FROM_UNIXTIME(' . $_GET['timeStamp'] . ')';
				$endDay=$curdate['mday'];
				$endMonth=$curdate['mon'];
				$endYear=$curdate['year'];
				if(isset($_GET['month']) && $_GET['month']=="true")
				{
					$endMonth++;
					if($endMonth>=13)
					{
						$endMonth=1;
						$endYear+=1;
					}
					$fDate = getdate(strtotime('-1 day', strtotime($endYear.'-'.$endMonth.'-'.$endDay)));
					$endDay=$fDate[mday];
					$endMonth=$fDate[mon];
					$endYear=$fDate[year];
					$sql =
						'SELECT COUNT(*) AS count
						FROM manifestation
						INNER JOIN datesManif AS dm ON dm.manifestation_ID = manifestation.ID
						WHERE (debut_manif <= '. $curdate['year'] . sprintf("%02d", $curdate['mon']) . '312359  AND fin_manif >= ' . $curdate['year'] . sprintf("%02d", $curdate['mon']) . '000000)';
				}
				else
					$sql =
						'SELECT COUNT(*) AS count
						FROM manifestation
						INNER JOIN datesManif AS dm ON dm.manifestation_ID = manifestation.ID
						WHERE (debut_manif <= '. $curdate['year'] . sprintf("%02d", $curdate['mon']) . sprintf("%02d", $curdate['mday']) . '2359  AND fin_manif >= ' . $endYear . sprintf("%02d", $endMonth) . sprintf("%02d", $endDay) . '0000)';
				//echo($sql);
				$req = mysql_query($sql);
				if(!$req)
				{
					echo('ERROR');
				}
				else
				{
					$data = mysql_fetch_assoc($req);
					$count = $data['count'];
					if(isset($_GET['month']) && $_GET['month']=="true")
						echo('<p>Vous avez '.$count.' événement'.(($count>1)?'s':'').' ce mois-ci:</p>');
					else
						echo('<p>Vous avez '.$count.' événement'.(($count>1)?'s':'').' ce jour là:</p>');
				}

				
				if(isset($_GET['month']) && $_GET['month']=="true")
					$sql =
						'SELECT	intitule,
							status,
							type,
							responsable_mail,
							observations,
							evenement
						FROM manifestation
						INNER JOIN datesManif AS dm ON dm.manifestation_ID = manifestation.ID
						INNER JOIN type_manifestation AS tm ON manifestation.type_manifestation_id = tm.id
						INNER JOIN status_manifestation AS stat ON manifestation.status_manifestation_id = stat.id
						WHERE (debut_manif <= '. $curdate['year'] . sprintf("%02d", $curdate['mon']) . '312359  AND fin_manif >= ' . $curdate['year'] . sprintf("%02d", $curdate['mon']) . '000000)';
				else
					$sql =
						'SELECT	intitule,
							status,
							type,
							responsable_mail,
							observations,
							evenement
						FROM manifestation
						INNER JOIN datesManif AS dm ON dm.manifestation_ID = manifestation.ID
						INNER JOIN type_manifestation AS tm ON manifestation.type_manifestation_id = tm.id
						INNER JOIN status_manifestation AS stat ON manifestation.status_manifestation_id = stat.id
						WHERE (debut_manif <= '. $curdate['year'] . sprintf("%02d", $curdate['mon']) . sprintf("%02d", $curdate['mday']) . '2359  AND fin_manif >= ' . $endYear . sprintf("%02d", $endMonth) . sprintf("%02d", $endDay) . '0000)';
				//echo($sql);
				$req = mysql_query($sql);
					//print_r(mysql_num_rows($req));
				if(!$req)
				{
					echo(mysql_errno($conn) . ' : ' . mysql_error($conn));
				}
				else
				{
					echo'<table class="eventsDescTable">';
					$i = 0;
					echo '<tr>';
					while ($i < mysql_num_fields($req))
					{
						$meta = mysql_fetch_field($req, $i);
						if($meta->name=="responsable_mail")
							echo '<th>reponsable</th>';
						else
							echo '<th>' . $meta->name . '</th>';
						$i++;
					}
					echo '</tr>';
					if($count>5)
					{
						$i = 0;
						while($i < 4)
						{
							$data = mysql_fetch_assoc($req);
							echo '<tr>';
							echo '<td style="white-space: nowrap;text-align: right; margin-left:2px; margin-right: 2px;">'.$data['intitule'].'</td>';
							echo '<td style="white-space: nowrap;text-align: right; margin-left:2px; margin-right: 2px;">'.$data['status'].'</td>';
							echo '<td style="white-space: nowrap;text-align: right; margin-left:2px; margin-right: 2px;">'.$data['type'].'</td>';
							echo '<td style="white-space: nowrap;text-align: right; margin-left:2px; margin-right: 2px;">'.$data['responsable_mail'].'</td>';
							echo '<td style="white-space: nowrap;text-align: right; margin-left:2px; margin-right: 2px;">'.$data['observations'].'</td>';
							echo '<td style="white-space: nowrap;text-align: right; margin-left:2px; margin-right: 2px;">'.$data['evenement'].'</td>';
							echo '</tr>';
							$i=$i+1;
						}
						echo '<tr>';
						echo '<td COLSPAN=7 style="border: 1px solid #A0A0A0; white-space: nowrap;text-align: left; margin-left: 5px;">+ ' . ($count-$i) . ' autres</td>';
						//echo '<td COLSPAN=7 style="border: 1px solid #A0A0A0; white-space: nowrap;text-align: left; margin-left: 5px;">+ ' . ($count-$i) . ' autre'.((($count-$i)>1)?'s':'').'</td>';
						echo '</tr>';
					}
					else
					{
						while($data = mysql_fetch_assoc($req))
						{
							echo '<tr>';
							echo '<td style="white-space: nowrap;text-align: right;">'.$data['intitule'].'</td>';
							echo '<td style="white-space: nowrap;text-align: right;">'.$data['status'].'</td>';
							echo '<td style="white-space: nowrap;text-align: right;">'.$data['type'].'</td>';
							echo '<td style="white-space: nowrap;text-align: right;">'.$data['responsable_mail'].'</td>';
							echo '<td style="white-space: nowrap;text-align: right;">'.$data['observations'].'</td>';
							echo '<td style="white-space: nowrap;text-align: right;">'.$data['evenement'].'</td>';
							echo '</tr>';
						}
					}
					echo '</table>';
				}
			?>
		</fieldset>
	</div>
</div>
