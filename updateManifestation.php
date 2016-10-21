<?php
	if(isset($_POST['mID']) && is_numeric($_POST['mID']))
	{
		$errorText="";
		if(!isset($_POST['intitule']))
		{
			$errorText.=('&#x26a0 Missing intitule. &#x26a0<br />');
		}
		if(!isset($_POST['type']) || !is_numeric($_POST['type']))
		{
			$errorText.=('&#x26a0 Wrong type: ' . $_POST['type']. ' &#x26a0<br />');
		}
		if(!isset($_POST['status']) || !is_numeric($_POST['status']))
		{
			$errorText.=('&#x26a0 Wrong status: ' . $_POST['status']. ' &#x26a0<br />');
		}
		if(!isset($_POST['responsable']))
		{
			$errorText.=('&#x26a0 Missing responsable. &#x26a0<br />');
		}
		if(!isset($_POST['description']))
		{
			$errorText.=('&#x26a0 Missing description. &#x26a0<br />');
		}
		if(!isset($_POST['observations']))
		{
			$errorText.=('&#x26a0 Missing observations. &#x26a0<br />');
		}

		if(!isset($_POST['manifDate']) || !is_numeric($_POST['manifDate']))
		{
			$errorText.=('&#x26a0 Wrong manifDate: ' . $_POST['manifDate']. ' &#x26a0<br />');
		}
		if(!isset($_POST['manifStart']) || !is_numeric($_POST['manifStart']))
		{
			$errorText.=('&#x26a0 Wrong manifStart: ' . $_POST['manifStart']. ' &#x26a0<br />');
		}
		if(!isset($_POST['manifEnd']) || !is_numeric($_POST['manifEnd']))
		{
			$errorText.=('&#x26a0 Wrong manifEnd: ' . $_POST['manifEnd']. ' &#x26a0<br />');
		}

		if(!isset($_POST['lieuID']) || !is_numeric($_POST['lieuID']))
		{
			$errorText.=('&#x26a0 Wrong lieuID: ' . $_POST['lieuID']. ' &#x26a0<br />');
		}
		if(!isset($_POST['reservStart']) || !is_numeric($_POST['reservStart']))
		{
			$errorText.=('&#x26a0 Wrong reservStart: ' . $_POST['reservStart']. ' &#x26a0<br />');
		}
		if(!isset($_POST['reservEnd']) || !is_numeric($_POST['reservEnd']))
		{
			$errorText.=('&#x26a0 Wrong reservEnd: ' . $_POST['reservEnd']. ' &#x26a0<br />');
		}

		if(!isset($_POST['recurenceID']) || !is_numeric($_POST['recurenceID']))
		{
			$errorText.=('&#x26a0 Wrong recurenceID: ' . $_POST['recurenceID']. ' &#x26a0<br />');
		}
		if(!isset($_POST['endRecurence']) || !is_numeric($_POST['endRecurence']))
		{
			$errorText.=('&#x26a0 Wrong endRecurence: ' . $_POST['endRecurence']. ' &#x26a0<br />');
		}

		if($errorText != "")
		{
			header('HTTP/1.1 500 Internal Server Error');
			print(substr($errorText, 0,-6));
			exit();
		}

		$servername = "127.0.0.1";
		$username = "root";
		$password = "password";
		$dbname = "bpi_calendar";

		$conn = mysql_connect($servername, $username, $password, $dbname);
		if ($conn->connect_error)
		{
			header('HTTP/1.1 500 Internal Server Error');
			print('Connection failed: ' . $conn->connect_error);
		}
		else
		{
			mysql_select_db($dbname, $conn);
			mysql_query('SET character_set_results = "UTF8", character_set_client = "UTF8", character_set_connection = "UTF8", character_set_database = "UTF8", character_set_server = "UTF8"');

			$intitule = str_replace('\\', '\\\\', (str_replace('"', '""', $_POST['intitule'])));
			$sql =	'UPDATE manifestation
					SET
						status_manifestation_ID = ' . $_POST['status'] . ',
						type_manifestation_ID = ' . $_POST['type'] . ',
						responsable_ID = "' . $_POST['responsable'] . '",
						intitule = "' . $intitule . '"
					WHERE ID = ' . $_POST['mID']
			;
			$req = mysql_query($sql);
			if(!$req)
			{
				header('HTTP/1.1 500 Internal Server Error');
				print(mysql_errno($conn) . ' : ' . mysql_error($conn));
				exit();
			}

			$observations = str_replace('\\', '\\\\', (str_replace('"', '""', $_POST['observations'])));
			$sql =	'UPDATE manifestation
					SET
						observations = ' . (($observations!="")? ('"'.$observations.'"') : 'NULL') . '
					WHERE ID = ' . $_POST['mID']
			;
			$req = mysql_query($sql);
			if(!$req)
			{
				header('HTTP/1.1 500 Internal Server Error');
				print(mysql_errno($conn) . ' : ' . mysql_error($conn));
				exit();
			}

			$description = str_replace('\\', '\\\\', (str_replace('"', '""', $_POST['description'])));
			$sql =	'UPDATE manifestation
					SET
						evenement = ' . (($description!="")? ('"'.$description.'"') : 'NULL') . '
					WHERE ID = ' . $_POST['mID']
			;
			$req = mysql_query($sql);
			if(!$req)
			{
				header('HTTP/1.1 500 Internal Server Error');
				print(mysql_errno($conn) . ' : ' . mysql_error($conn));
				exit();
			}

			function addMonth($curDate, $monthsToAdd)
			{
				$Y = date('Y', $curDate);
				$M = date('m', $curDate);
				$D = date('d', $curDate);
				//print($Y.$M.$D.'+'.$monthsToAdd.'<br/>');
				$addY = floor($monthsToAdd/12);
				$addM = $monthsToAdd%12;
				$newY = $Y+$addY;
				$newM = $M+$addM;
				$newD = $D+$addD;
				//print(($newY.'-'.(($newM<10)?'0':'').$newM.'-'.(($newD<10)?'0':'').$newD).' - ' . ((checkdate($newM, $newD, $newY)!=null)?'1':'0') . '<br/>');
				if($newM>12)
				{
					$newY++;
					$newM-=12;
				}
				while((checkdate($newM, $newD, $newY)==null)&&$newD>28)
				{
					$newD--;
				}
				$date = date($newY.'-'.(($newM<10)?'0':'').$newM.'-'.(($newD<10)?'0':'').$newD);
				//print(($newY.'-'.(($newM<10)?'0':'').$newM.'-'.(($newD<10)?'0':'').$newD).' - ' . ((checkdate($newM, $newD, $newY)!=null)?'1':'0') . '<br/>');
				return strtotime($date);
			}

			function checkReservation($mID, $lieuID, $manifDate, $reservStart, $reservEnd, $recurenceID, $endRecurence)
			{
				$reservs = array();
				$mDate = date(substr($manifDate, 0, 4).'-'.substr($manifDate, 4, 2).'-'.substr($manifDate, 6, 2));
				$endR = date(substr($endRecurence, 0, 4).'-'.substr($endRecurence, 4, 2).'-'.substr($endRecurence, 6, 2));
				switch($recurenceID)
				{
					case 2:
						for($curDate=strtotime($mDate); $curDate<=strtotime($endR); $curDate=strtotime('+1 day', $curDate))
							array_push($reservs, date('Ymd', $curDate));
					break;
					case 3:
						for($curDate=strtotime($mDate); $curDate<=strtotime($endR); $curDate=strtotime('+1 week', $curDate))
							array_push($reservs, date('Ymd', $curDate));
					break;
					case 4:
						for($curDate=strtotime($mDate); $curDate<=strtotime($endR); $curDate=strtotime('+2 week', $curDate))
							array_push($reservs, date('Ymd', $curDate));
					break;
					case 5:
						for($curDate=strtotime($mDate), $firstDate=strtotime($mDate), $i=1; $curDate<=strtotime($endR); $curDate=addMonth($firstDate, $i), $i++)
							array_push($reservs, date('Ymd', $curDate));
					break;
					case 6:
						for($curDate=strtotime($mDate), $firstDate=strtotime($mDate), $i=4; $curDate<=strtotime($endR); $curDate=addMonth($firstDate, $i), $i+=4)
							array_push($reservs, date('Ymd', $curDate));
					break;
					default:
						array_push($reservs, $manifDate);
					break;
				}

				$numConflits=0;
				foreach($reservs as $reserv)
				{
					$sql =	'SELECT m.ID, intitule, m.responsable_ID, lieu, debut_reservation, fin_reservation
						FROM reservation
						INNER JOIN lieu AS l ON l.ID = reservation.lieu_ID
						INNER JOIN datesManif AS dm ON dm.ID = reservation.dates_manifestation_ID
						INNER JOIN manifestation AS m ON m.ID = dm.manifestation_ID
						WHERE m.ID != ' . $mID . ' AND l.ID = ' . $lieuID . ' AND
						(
							(debut_reservation < ' . $reserv.$reservStart . ' AND fin_reservation > ' . $reserv.$reservStart . ')
							OR
							(debut_reservation < ' . $reserv.$reservEnd . ' AND fin_reservation > ' . $reserv.$reservEnd . ')
							OR
							(debut_reservation >= ' . $reserv.$reservStart . ' AND fin_reservation <= ' . $reserv.$reservEnd . ')
						)'
					;
					$req = mysql_query($sql);
					if(!$req)
					{
						header('HTTP/1.1 500 Internal Server Error');
						print(mysql_errno($conn) . ' : ' . mysql_error($conn));
						exit();
					}
					$numRows=mysql_num_rows($req);
					if($numRows>0)
					{
						$numConflits+=$numRows;
						header('HTTP/1.1 500 Internal Server Error');
						while($reserv = mysql_fetch_assoc($req))
						{
							print('L\'évènement ' . $reserv[intitule]. ' organisé par ' . $reserv[responsable_ID] . ', a déjà réservé le lieu ' . $reserv[lieu] . ', le ' . substr($reserv['debut_reservation'], 6, 2).'/'.substr($reserv['debut_reservation'], 4, 2).'/'.substr($reserv['debut_reservation'], 0, 4) . ' entre ' . substr($reserv['debut_reservation'], 8, 2) . 'h' . substr($reserv['debut_reservation'], -2) . ' et ' . substr($reserv['fin_reservation'], 8, 2) . 'h' . substr($reserv['fin_reservation'], -2) . '<br />');
						}
					}
				}
				if($numConflits>0)
				{
					print($numConflits.' conflits<br />');
					header('HTTP/1.1 500 Internal Server Error');
					exit();
				}
			}

			function addManifestationReservation($mID, $lieuID, $manifDate, $manifStart, $manifEnd, $reservStart, $reservEnd, $recurenceID, $endRecurence)
			{
				$reservs = array();
				$mDate = date(substr($manifDate, 0, 4).'-'.substr($manifDate, 4, 2).'-'.substr($manifDate, 6, 2));
				$endR = date(substr($endRecurence, 0, 4).'-'.substr($endRecurence, 4, 2).'-'.substr($endRecurence, 6, 2));
				switch($_POST['recurenceID'])
				{
					case 2:
						for($curDate=strtotime($mDate); $curDate<=strtotime($endR); $curDate=strtotime('+1 day', $curDate))
							array_push($reservs, date('Ymd', $curDate));
					break;
					case 3:
						for($curDate=strtotime($mDate); $curDate<=strtotime($endR); $curDate=strtotime('+1 week', $curDate))
							array_push($reservs, date('Ymd', $curDate));
					break;
					case 4:
						for($curDate=strtotime($mDate); $curDate<=strtotime($endR); $curDate=strtotime('+2 week', $curDate))
							array_push($reservs, date('Ymd', $curDate));
					break;
					case 5:
						for($curDate=strtotime($mDate), $firstDate=strtotime($mDate), $i=1; $curDate<=strtotime($endR); $curDate=addMonth($firstDate, $i), $i++)
							array_push($reservs, date('Ymd', $curDate));
					break;
					case 6:
						for($curDate=strtotime($mDate), $firstDate=strtotime($mDate), $i=4; $curDate<=strtotime($endR); $curDate=addMonth($firstDate, $i), $i+=4)
							array_push($reservs, date('Ymd', $curDate));
					break;
					default:
						array_push($reservs, $manifDate);
					break;
				}

				$numConflits=0;
				foreach($reservs as $reserv)
				{
					$sql =	'INSERT INTO datesManif
							(
								manifestation_ID,
								debut_manif,
								fin_manif
							)
							VALUES
							(
								'.$mID.',
								'.$reserv.$manifStart.',
								'.$reserv.$manifEnd.'
							)'
					;
					$req = mysql_query($sql);
					if(!$req)
					{
						header('HTTP/1.1 500 Internal Server Error');
						print(mysql_errno($conn) . ' : ' . mysql_error($conn).'<br />');
						exit();
					}
					else if($lieuID!=-1)
					{
						$sql =	'INSERT INTO reservation
								(
									lieu_ID,
									dates_manifestation_ID,
									debut_reservation,
									fin_reservation
								)
								VALUES
								(
									'.$lieuID.',
									'.mysql_insert_id().',
									'.$manifDate.$reservStart.',
									'.$manifDate.$reservEnd.'
								)'
						;
						$req = mysql_query($sql);
						if(!$req)
						{
							header('HTTP/1.1 500 Internal Server Error');
							print(mysql_errno($conn) . ' : ' . mysql_error($conn).'<br />');
							exit();
						}
					}
				}
			}

			/* If Manif Date is set then delete all manifestations and reservations to replace them */
			if($_POST['manifDate']!=-1)
			{
				if($_POST['lieuID']!=-1)
				{
					checkReservation($_POST['mID'], $_POST['lieuID'], $_POST['manifDate'], $_POST['reservStart'], $_POST['reservEnd'], $_POST['recurenceID'], $_POST['endRecurence']);
				}

				$sql =	'DELETE reservation
						FROM reservation
						INNER JOIN datesManif AS dm ON dm.ID = reservation.dates_manifestation_ID
						INNER JOIN manifestation AS m ON m.ID = dm.manifestation_ID
						WHERE m.ID = ' . $_POST['mID']
				;
				$req = mysql_query($sql);
				if(!$req)
				{
					header('HTTP/1.1 500 Internal Server Error');
					print(mysql_errno($conn) . ' : ' . mysql_error($conn));
				}

				$sql =	'DELETE datesManif
						FROM datesManif
						INNER JOIN manifestation AS m ON m.ID = datesManif.manifestation_ID
						WHERE m.ID = ' . $_POST['mID']
				;
				$req = mysql_query($sql);
				if(!$req)
				{
					header('HTTP/1.1 500 Internal Server Error');
					print(mysql_errno($conn) . ' : ' . mysql_error($conn));
				}
				addManifestationReservation($_POST['mID'], $_POST['lieuID'], $_POST['manifDate'], $_POST['manifStart'], $_POST['manifEnd'], $_POST['reservStart'], $_POST['reservEnd'], $_POST['recurenceID'], $_POST['endRecurence']);
			}

			if($_POST['status']==3)
			{
				$sql =	'DELETE reservation
						FROM reservation
						INNER JOIN datesManif AS dm ON dm.ID = reservation.dates_manifestation_ID
						INNER JOIN manifestation AS m ON m.ID = dm.manifestation_ID
						WHERE m.ID = ' . $_POST['mID']
				;
				$req = mysql_query($sql);
				if(!$req)
				{
					header('HTTP/1.1 500 Internal Server Error');
					print(mysql_errno($conn) . ' : ' . mysql_error($conn));
				}
			}
		}
	}
	else
	{
		header('HTTP/1.1 500 Internal Server Error');
		print('Not correct ID sent: ' . $_POST['mID']);
	}
?>
