<?php
	if(isset($_POST['mID']) && is_numeric($_POST['mID']))
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
					WHERE m.ID = ' . $_POST['mID']
			;
			$req = mysql_query($sql);
			if(!$req)
			{
				header('HTTP/1.1 500 Internal Server Error');
				print(mysql_errno($conn) . ' : ' . mysql_error($conn));
			}
			else
			{
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
				else
				{

					$sql = 'DELETE manifestation FROM manifestation WHERE ID = ' . $_POST['mID'];
					$req = mysql_query($sql);
					if(!$req)
					{
						header('HTTP/1.1 500 Internal Server Error');
						print(mysql_errno($conn) . ' : ' . mysql_error($conn));
					}
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
