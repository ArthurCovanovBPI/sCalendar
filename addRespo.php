<?php
	if(isset($_POST['newRespo']))
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

			$sql =	'SELECT * FROM responsable WHERE nom = ("' . (str_replace('\\', '\\\\', (str_replace('"', '""', $_POST['newRespo'])))) . '") LIMIT 1';
			$req = mysql_query($sql);
			if(!$req)
			{
				header('HTTP/1.1 500 Internal Server Error');
				print(mysql_errno($conn) . ' : ' . mysql_error($conn) . '<br />' . $sql);
				exit();
			}
			if(mysql_num_rows($req) > 0)
			{
				header('HTTP/1.1 500 Internal Server Error');
				print('L\'utilisateur ' . (str_replace('\\', '\\\\', (str_replace('"', '""', $_POST['newRespo'])))) . ' existe déjà.');
				exit();
			}


			$sql =	'INSERT
					 INTO responsable(nom)
					 VALUES ("' . (str_replace('\\', '\\\\', (str_replace('"', '""', $_POST['newRespo'])))) . '")'
			;
			$req = mysql_query($sql);
			if(!$req)
			{
				header('HTTP/1.1 500 Internal Server Error');
				print(mysql_errno($conn) . ' : ' . mysql_error($conn) . '<br />' . $sql);
				exit();
			}

			$sql =	'SELECT COUNT(*) AS count FROM responsable WHERE nom <= ("' . (str_replace('\\', '\\\\', (str_replace('"', '""', $_POST['newRespo'])))) . '")';
			$req = mysql_query($sql);
			if(!$req)
			{
				header('HTTP/1.1 500 Internal Server Error');
				print(mysql_errno($conn) . ' : ' . mysql_error($conn) . '<br />' . $sql);
			}
			else
			{
				$data = mysql_fetch_assoc($req);
				print($data['count']);
			}
		}
	}
	else
	{
		header('HTTP/1.1 500 Internal Server Error');
		print('No correct name sent: ' . $_POST['newRespo']);
	}
?>
