<?php
	if(isset($_POST['lieuID']) && isset($_POST['eID']) && is_numeric($_POST['eID']))
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
			$sql =	'INSERT INTO lieu(lieu, espace_ID)
				 	 VALUES ("' . (str_replace('\\', '\\\\', (str_replace('"', '""', $_POST['lieuID'])))) . '", ' . $_POST['eID'] . ')'
			;
			$req = mysql_query($sql);
			if(!$req)
			{
				header('HTTP/1.1 500 Internal Server Error');
				print(mysql_errno($conn) . ' : ' . mysql_error($conn) . '<br />' . $sql);
			}
		}
	}
	else
	{
		header('HTTP/1.1 500 Internal Server Error');
		print('No correct ID sent: ' . $_POST['lieuID']);
	}
?>
