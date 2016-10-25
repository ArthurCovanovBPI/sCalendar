<?php
	if(array_key_exists("AuthUser", $allHeaders) && isset($_GET['eventID']) && is_numeric($_GET['eventID']))
	{
		$servername = "127.0.0.1";
		$username = "root";
		$password = "password";
		$dbname = "bpi_calendar";

		$conn = mysql_connect($servername, $username, $password, $dbname);

		if(!$conn->connect_error)
		{
			mysql_select_db($dbname, $conn);
			mysql_query('SET character_set_results = "UTF8", character_set_client = "UTF8", character_set_connection = "UTF8", character_set_database = "UTF8", character_set_server = "UTF8"');
			$sql =
				'SELECT
					responsable_mail
				FROM manifestation
				WHERE manifestation.ID = ' . $_GET['eventID']
			;
			$req = mysql_query($sql);
			if($req)
			{
				$data = mysql_fetch_assoc($req);
				$numRows=mysql_num_rows($req);

				if($data['responsable_mail'] == $allHeaders[AuthUser])
					echo('<a href="?menu=evenement&section=edition&eventID='.$_GET[eventID].'"'.(($section == 'Edition')? ' class="selected"' : '').'>Édition</a>');
			}
		}
	}
?>
