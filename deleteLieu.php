<?php
	if(isset($_POST['lieuID']) && is_numeric($_POST['lieuID']))
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

			$sql =	'DELETE
				FROM reservation
				WHERE lieu_ID = ' . $_POST['lieuID']
			;
			$req = mysql_query($sql);
			if(!$req)
			{
				header('HTTP/1.1 500 Internal Server Error');
				print(mysql_errno($conn) . ' : ' . mysql_error($conn));
				exit();
			}

			$sql =	'DELETE
				FROM lieu
				WHERE ID = ' . $_POST['lieuID']
			;
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
		print('&#x26a0 No correct ID sent: ' . $_POST['lieuID'] . ' &#x26a0');
	}
?>
