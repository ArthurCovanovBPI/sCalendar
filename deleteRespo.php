<?php
	if(isset($_POST['respoID']) && is_numeric($_POST['respoID']))
	{
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

			$sql =	'DELETE reservation
					FROM reservation
					INNER JOIN datesManif AS dm ON dm.ID = reservation.dates_manifestation_ID
					INNER JOIN manifestation AS m ON m.ID = dm.manifestation_ID
					WHERE m.responsable_mail = ' . $_POST['respoID']
			;
			$req = mysql_query($sql);
			if(!$req)
			{
				header('HTTP/1.1 500 Internal Server Error');
				print(mysql_errno($conn) . ' : ' . mysql_error($conn));
				exit();
			}

			$sql =	'DELETE datesManif
					FROM datesManif
					INNER JOIN manifestation AS m ON m.ID = datesManif.manifestation_ID
					WHERE m.responsable_mail = ' . $_POST['respoID']
			;
			$req = mysql_query($sql);
			if(!$req)
			{
				header('HTTP/1.1 500 Internal Server Error');
				print(mysql_errno($conn) . ' : ' . mysql_error($conn));
				exit();
			}

			$sql =	'DELETE FROM manifestation WHERE responsable_mail = ' . $_POST['respoID'];
			$req = mysql_query($sql);
			if(!$req)
			{
				header('HTTP/1.1 500 Internal Server Error');
				print(mysql_errno($conn) . ' : ' . mysql_error($conn));
				exit();
			}

			$sql =	'DELETE FROM responsable WHERE ID = ' . $_POST['respoID'];
			$req = mysql_query($sql);
			if(!$req)
			{
				header('HTTP/1.1 500 Internal Server Error');
				print(mysql_errno($conn) . ' : ' . mysql_error($conn));
			}
		}
	}
	else
	{
		header('HTTP/1.1 500 Internal Server Error');
		print('No correct ID sent: ' . $_POST['respoID']);
	}
?>
