<?php
	if(isset($eID) || (isset($_GET['eID']) && is_numeric($_GET['eID'])))
	{
		$servername = "127.0.0.1";
		$username = "root";
		$password = "password";
		$dbname = "bpi_calendar";

		$conn = mysql_connect($servername, $username, $password, $dbname);
		if ($conn->connect_error)
		{
			echo
					'Connection failed: ' . (mysql_errno($conn) . ' : ' . mysql_error($conn))
			;
			exit(1);
		}
		mysql_select_db($dbname, $conn);
		mysql_query('SET character_set_results = "UTF8", character_set_client = "UTF8", character_set_connection = "UTF8", character_set_database = "UTF8", character_set_server = "UTF8"');

		if(!isset($eID))
			$eID = $_GET['eID'];

		$sql ='SELECT * FROM lieu WHERE espace_ID = ' . $eID;

		$req = mysql_query($sql);
		if(!$req)
		{
			echo 'No lieu found :' . (mysql_errno($conn) . ' : ' . mysql_error($conn));
		}
		else
		{

			while($lieu = mysql_fetch_assoc($req))
			{
				echo
							'<option data-value="'.$lieu['ID'].'" value="'.(str_replace('"', '&#34', $lieu['lieu'])).'" label="'.(str_replace('"', '&#34', $lieu['lieu'])).'">' .  (str_replace('"', '&#34', $lieu['lieu'])) . '</option>'
				;
			}
		}
	}
	else
	{
		echo 'Wrong eID: ' . $_GET['eID'];
	}
?>
