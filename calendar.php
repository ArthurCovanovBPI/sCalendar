<?php
	$_a = 0;
	$_0 = 1;
	$_1 = 1;
	$_2 = 1;
	$_3 = 0;
	$_4 = 0;

if(isset($_GET['calendarCheck']) && is_numeric($_GET['calendarCheck']) && strlen(is_numeric($_GET['calendarCheck'])) == 5)
{
	$_arr = str_split($_GET['calendarCheck']);

	$_0 = $_arr[0];
	$_1 = $_arr[1];
	$_2 = $_arr[2];
	$_3 = $_arr[3];
	$_4 = $_arr[4];

	if($_0 != 0 && $_1 != 0 && $_2 != 0 && $_3 != 0 && $_4 != 0)
		$_a = 1;
}

	echo '<input type="checkbox" id="checkTout" name="checkTout"' . (($_a != 0)? ' checked' : '') . '/><label for="checkTout">Tout </label>';
	echo '<input type="checkbox" id="checkManifPublique" name="checkManifPublique"' . (($_0 != 0)? ' checked' : '') . ' /><label for="checkManifPublique">Manifestation publique </label>';
	echo '<input type="checkbox" id="checkManifInterne" name="checkManifInterne"' . (($_1 != 0)? ' checked' : '') . ' /><label for="checkManifInterne">Manfestation / réunion interne </label>';
	echo '<input type="checkbox" id="checkCalendaire" name="checkCalendaire"' . (($_2 != 0)? ' checked' : '') . ' /><label for="checkCalendaire">Événement de type calendaire (vacances, jours fériés) </label>';
	echo '<input type="checkbox" id="checkAdminRH" name="checkAdminRH"' . (($_3 != 0)? ' checked' : '') . ' /><label for="checkAdminRH">Administratif et RH (pas d\'envoi à la presse) </label>';
	echo '<input type="checkbox" id="checkFinancier" name="checkFinancier"' . (($_4 != 0)? ' checked' : '') . ' /><label for="checkFinancier">Financier (pas d\'envoi à la presse)</label>';
	echo '<br />';

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

	if($timeAdvance == "year")
	{
		echo('<table class="yearTable" border="1" style="width: 100%; table-layout: fixed;">');
		echo(
			'<tr style="background-color: rgba(200, 200, 200, 0.6);">'.
				'<th class="col1" onmouseover="highlightColumn(\'col1\');monthEventDescription('.strtotime(($today[year]) . '/1/1').');" onmouseleave="lowlightColumn(\'col1\');"><a href="?timeStamp='.strtotime(($today[year]) . '/1/1').'">Janvier</a></th>
				<th class="col2" onmouseover="highlightColumn(\'col2\');monthEventDescription('.strtotime(($today[year]) . '/2/1').');" onmouseleave="lowlightColumn(\'col2\');"><a href="?timeStamp='.strtotime(($today[year]) . '/2/1').'">Février</a></th>
				<th class="col3" onmouseover="highlightColumn(\'col3\');monthEventDescription('.strtotime(($today[year]) . '/3/1').');" onmouseleave="lowlightColumn(\'col3\');"><a href="?timeStamp='.strtotime(($today[year]) . '/3/1').'">Mars</a></th>
				<th class="col4" onmouseover="highlightColumn(\'col4\');monthEventDescription('.strtotime(($today[year]) . '/4/1').');" onmouseleave="lowlightColumn(\'col4\');"><a href="?timeStamp='.strtotime(($today[year]) . '/4/1').'">Avril</a></th>
				<th class="col5" onmouseover="highlightColumn(\'col5\');monthEventDescription('.strtotime(($today[year]) . '/5/1').');" onmouseleave="lowlightColumn(\'col5\');"><a href="?timeStamp='.strtotime(($today[year]) . '/5/1').'">Mai</a></th>
				<th class="col6" onmouseover="highlightColumn(\'col6\');monthEventDescription('.strtotime(($today[year]) . '/6/1').');" onmouseleave="lowlightColumn(\'col6\');"><a href="?timeStamp='.strtotime(($today[year]) . '/6/1').'">Juin</a></th>
				<th class="col7" onmouseover="highlightColumn(\'col7\');monthEventDescription('.strtotime(($today[year]) . '/7/1').');" onmouseleave="lowlightColumn(\'col7\');"><a href="?timeStamp='.strtotime(($today[year]) . '/7/1').'">Juillet</a></th>
				<th class="col8" onmouseover="highlightColumn(\'col8\');monthEventDescription('.strtotime(($today[year]) . '/8/1').');" onmouseleave="lowlightColumn(\'col8\');"><a href="?timeStamp='.strtotime(($today[year]) . '/8/1').'">Aout</a></th>
				<th class="col9" onmouseover="highlightColumn(\'col9\');monthEventDescription('.strtotime(($today[year]) . '/9/1').');" onmouseleave="lowlightColumn(\'col9\');"><a href="?timeStamp='.strtotime(($today[year]) . '/9/1').'">Septembre</a></th>
				<th class="col10" onmouseover="highlightColumn(\'col10\');monthEventDescription('.strtotime(($today[year]) . '/10/1').');" onmouseleave="lowlightColumn(\'col10\');"><a href="?timeStamp='.strtotime(($today[year]) . '/10/1').'">Octobre</a></th>
				<th class="col11" onmouseover="highlightColumn(\'col11\');monthEventDescription('.strtotime(($today[year]) . '/11/1').');" onmouseleave="lowlightColumn(\'col11\');"><a href="?timeStamp='.strtotime(($today[year]) . '/11/1').'">Novembre</a></th>
				<th class="col12" onmouseover="highlightColumn(\'col12\');monthEventDescription('.strtotime(($today[year]) . '/12/1').');" onmouseleave="lowlightColumn(\'col12\');"><a href="?timeStamp='.strtotime(($today[year]) . '/12/1').'">Décembre</a></th>
			</tr>'
		);
		for($d = 1; $d <= 31; $d++)
		{
			echo('<tr>');

			for($m = 1; $m<=12; $m++)
			{
				$curTimeStamp=strtotime(($today[year]).'/'.$m.'/'.$d);
				$curdate=getdate($curTimeStamp);

				$sql =
					'SELECT COUNT(*) AS count
					FROM manifestation
					INNER JOIN datesManif AS dm ON dm.manifestation_ID = manifestation.ID
					WHERE (debut_manif <= '. $curdate['year'] . sprintf("%02d", $curdate['mon']) . sprintf("%02d", $curdate['mday']) . '2359  AND fin_manif >= ' . $curdate['year'] . sprintf("%02d", $curdate['mon']) . sprintf("%02d", $curdate['mday']) . '0000)';

				$req = mysql_query($sql);
				$data = mysql_fetch_assoc($req);
				echo(
					($d>cal_days_in_month(CAL_GREGORIAN,$m, $today[year])) ? ('<td class="outMonth">-</td>') : ('<td onmouseover="eventDescription('.$curTimeStamp.');" class="col'.$m.'"' . (($curdate[wday]==0) ? ' style="background-color:rgba(128, 112, 240, 0.7);"' : '') . '><a href="?timeAdvance=day&timeStamp='.$curTimeStamp . '">' . wday2letter($curdate[wday]) . ' ' . $d . ' <span style="float: right; margin-right: 4px;">' . ((!$req)? (mysql_errno($conn) . ' : ' . mysql_error($conn)) : (($data['count']>0)?($data['count'].' événement'.(($data['count']>1)?'s':'')):'')) . '</span></a></td>')
				);
			}
			echo('</tr>');
		}
		echo('</table>');
	}
	else if($timeAdvance == "day")
	{
		class eventInfos
		{
			public $id;
			public $txt;
			public $start;
			public $end;
		}

		class dayColumn
		{
			//48xfalse. One for each half hours
			public $lines = array(false, false, false, false, false, false, false, false, false, false, false, false, false, false, false, false, false, false, false, false, false, false, false, false, false, false, false, false, false, false, false, false, false, false, false, false, false, false, false, false, false, false, false, false, false, false, false, false);
			public $events = array();

			function insertEvent($eI)
			{
				for($i=$eI->start; $i<$eI->end;$i++)
				{
					if($this->lines[$i]==true)
						return false;
				}
				for($i=$eI->start; $i<$eI->end;$i++)
				{
					$this->lines[$i]=true;
				}
				array_push($this->events, $eI);
				return true;
			}
		}

		function generateEventArray($today)
		{
			$eventArray = array();
			$sql = 
				'SELECT	debut_manif,
						fin_manif,
						intitule,
						manifestation.responsable_mail,
						manifestation.ID
				FROM manifestation
				INNER JOIN type_manifestation AS tm ON manifestation.type_manifestation_id = tm.id
				INNER JOIN datesManif AS dm ON dm.manifestation_ID = manifestation.ID
				WHERE (debut_manif <= '. $today['year'] . sprintf("%02d", $today['mon']) . sprintf("%02d", $today['mday']) . '2359  AND fin_manif >= ' . $today['year'] . sprintf("%02d", $today['mon']) . sprintf("%02d", $today['mday']) . '0000)';
			$req = mysql_query($sql);
			while($data = mysql_fetch_assoc($req))
			{
				echo ((!$req)? ('ERROR: ' . (mysql_errno($conn) . ' : ' . mysql_error($conn)) . '<br />') : '');
				$obj = new eventInfos();
				$obj->id = $data['ID'];
				$obj->txt = $data['intitule'];
				if((float)$data['debut_manif'] < (float)($today['year'].sprintf('%02d', $today['mon']).sprintf('%02d', $today['mday']).'0000')
				|| (float)$data['fin_manif'] > (float)($today['year'].sprintf('%02d', $today['mon']).sprintf('%02d', $today['mday']).'2359'))
				{
					$obj->txt .= ('<br />' . substr($data['debut_manif'], 6, 2) . '/' . substr($data['debut_manif'], 4, 2) . '/' . substr($data['debut_manif'], 0, 4));
					$obj->txt .= (' - ' . substr($data['debut_manif'], 8, 2) . 'h' .  substr($data['debut_manif'], -2));
					$obj->txt .= ('<br />-');
					$obj->txt .= ('<br />' . substr($data['fin_manif'], 6, 2) . '/' . substr($data['fin_manif'], 4, 2) . '/' . substr($data['fin_manif'], 0, 4));
					$obj->txt .= (' - ' . substr($data['fin_manif'], 8, 2) . 'h' . substr($data['fin_manif'], -2));
				}
				else
					$obj->txt .= ('<br />' . substr($data['debut_manif'], 8, 2) . 'h' . substr($data['debut_manif'], -2) . ' - ' . substr($data['fin_manif'], 8, 2) . 'h' . substr($data['fin_manif'], -2));
				if((float)$data['debut_manif'] < (float)($today['year'].sprintf('%02d', $today['mon']).sprintf('%02d', $today['mday']).'0000'))
					$obj->start = 0;
				else
					$obj->start = substr($data['debut_manif'], 8, 2)*2+((substr($data['debut_manif'], -2)>=30)?1:0);
				if((float)$data['fin_manif'] > (float)($today['year'].sprintf('%02d', $today['mon']).sprintf('%02d', $today['mday']).'2359'))
					$obj->end = 48;
				else
					$obj->end = substr($data['fin_manif'], 8, 2)*2+((substr($data['fin_manif'], -2)>=30)?1:0);
				$eventArray[]=$obj;
			}
			
			return $eventArray;
		}

		function insertEventInDayColums($dayColumns, $event)
		{
			foreach($dayColumns as $dayCol)
			{
				if($dayCol->insertEvent($event)==true)
					return true;
			}
			return false;
		}

		function createDayColumns($eventsArray)
		{
			$dayColumns = array();
			foreach($eventsArray as $ev)
			{
				if(insertEventInDayColums($dayColumns, $ev)==false)
				{
					$newDayColumn = new dayColumn();
					$newDayColumn->insertEvent($ev);
					array_push($dayColumns, $newDayColumn);
				}
			}
			return $dayColumns;
		}

		function printDayColumns($dC)
		{
			for($i=0; $i<count($dC); $i++)
			{
				$dayColumn = $dC[$i];
				foreach($dayColumn->events as $ev)
				{
					$b = mt_rand(0x000000, 0xFFFFFF);
					$t = (~$b)&0xFFFFFF;

					if((($b&0xFF0000)<=0xA00000)&&(($b&0xFF00)<=0xA000))
						$t=$t|0xF0F0F0;
					else
						$t=$t&0x3F3F3F;

					echo('<a class="eventCase" href="?menu=evenement&eventID='.$ev->id.'" onmouseover="eventDescription('.$ev->id.');" style="background-color:'.sprintf('#%06X', $b).'; position: absolute; left: '.(80+150*$i).'px; top: '.(30+$ev->start*15).'px; width: 147px; height: '.(($ev->end-$ev->start)*15-3).'px; overflow:hidden; text-overflow: ellipsis; color: '.sprintf('#%06X', $t).';">'.$ev->txt.'</a>');
				}
			}
		}

		echo('<div style="position: relative; width:100%; height: 770px; overflow: auto; overflow-y:hidden;">');
		$eventArray = generateEventArray($today);
		$ret = createDayColumns($eventArray);
		echo('<table class="dayTable" border="1" style="position: absolute; min-width: 100%; width:'.(count($ret)*150+81).'px;">');
		echo('<tr style="">
			<th style="width: 79px; height: 29px;">Heure</th>
			<th style="height: 29px;">Événements</th>
		</tr>');
		for($h = 0; $h < 24; $h++)
		{
			echo('<tr>'
				.'<th style="width: 79px; height: 29px;">' . $h . " - " . ($h+1) . '</th>'
				.'<td style="height: 29px;"></td>'
			.'</tr>');
		}
		echo('</table>');
		printDayColumns($ret);
		echo('</div>');
	}
	else
	{
		echo('<table class="monthTable" border="1" style="width:100%;">');

		echo
		(
				'<tr>
					<th>Lundi</th>
					<th>Mardi</th>
					<th>Mercredi</th>
					<th>Jeudi</th>
					<th>Vendredi</th>
					<th>Samedi</th>
					<th>Dimanche</th>
				</tr>'
		);
		$today_mday = $today[mday];
		$first_mday = $today[mday] % 7;
		$today_wday = $today[wday];
		$daysCursor = $first_mday - $today_wday;
		if($first_mday > $today_wday)
		{
			$daysCursor = $daysCursor-7;
		}
		for($w = 0; $w < 6; $w++)
		{
			echo('<tr>');
			for($d = 0; $d < 7; $d++, $daysCursor++)
			{
				$curDayTimeStamp = $today[0]-(($today[mday]-1)*86400)+($daysCursor*86400);
				$curDayDate = getdate($curDayTimeStamp);

				$sql =
					'SELECT COUNT(*) AS count
					FROM manifestation
					INNER JOIN datesManif AS dm ON dm.manifestation_ID = manifestation.ID
					WHERE (debut_manif <= '. $curDayDate['year'] . sprintf("%02d", $curDayDate['mon']) . sprintf("%02d", $curDayDate['mday']) . '2359  AND fin_manif >= ' . $curDayDate['year'] . sprintf("%02d", $curDayDate['mon']) . sprintf("%02d", $curDayDate['mday']) . '0000)';

				$req = mysql_query($sql);
				$data = mysql_fetch_assoc($req);
				$count = $data[count];

				$sql =
					'SELECT	intitule,
							debut_manif,
							fin_manif
					FROM manifestation
					INNER JOIN datesManif AS dm ON dm.manifestation_ID = manifestation.ID
					WHERE (debut_manif <= '. $curDayDate['year'] . sprintf("%02d", $curDayDate['mon']) . sprintf("%02d", $curDayDate['mday']) . '2359  AND fin_manif >= ' . $curDayDate['year'] . sprintf("%02d", $curDayDate['mon']) . sprintf("%02d", $curDayDate['mday']) . '0000)';

				$req = mysql_query($sql);

				echo('<td' . ((($curDayDate[yday] == $realToday[yday])&&($curDayDate[year] == $realToday[year])) ? ' id="today"' : '') . (($curDayDate[mon] != $today[mon]) ? ' class="outMonth"' : '') . '>');

				echo('<a onmouseover="eventDescription('.$curDayTimeStamp.');" href="?timeAdvance=day&timeStamp='.$curDayTimeStamp.'" style="padding:5px;">');

				echo(wday2tritter($curDayDate[wday]).' '.$curDayDate[mday].' '.mon2mois($curDayDate[mon]).' '.$curDayDate[year]);
				echo('<br /><br />');
				if($count <= 5)
				{
					while($data = mysql_fetch_assoc($req))
					{
						if((float)$data['debut_manif'] < (float)($curDayDate['year'].sprintf('%02d', $curDayDate['mon']).sprintf('%02d', $curDayDate['mday']).'0000'))
						{
							echo(substr($data['debut_manif'], 6, 2) . '/' . substr($data['debut_manif'], 4, 2) . '/' . substr($data['debut_manif'], 0, 4));
						}
						else
						{
							echo(substr($data['debut_manif'], 8, 2) . 'h' .  substr($data['debut_manif'], -2));
						}

						echo(' - ');
						echo($data['intitule']);
						echo('<br />');
					}
				}
				else
				{
					$i = 0;
					while($i < 4)
					{
						$data = mysql_fetch_assoc($req);

						if((float)$data['debut_manif'] < (float)($curDayDate['year'].sprintf('%02d', $curDayDate['mon']).sprintf('%02d', $curDayDate['mday']).'0000'))
						{
							echo(substr($data['debut_manif'], 6, 2) . '/' . substr($data['debut_manif'], 4, 2) . '/' . substr($data['debut_manif'], 0, 4));
						}
						else
						{
							echo(substr($data['debut_manif'], 8, 2) . 'h' .  substr($data['debut_manif'], -2));
						}

						echo(' - ');
						echo($data['intitule']);

						echo '<br />';
						$i++;
					}
					echo '+ ' . ($count-$i) . ' autres';
				}
				echo('</a>');
				echo('</td>');
			}
			echo('</tr>');
		}
		echo('</table>');
	}
?>
