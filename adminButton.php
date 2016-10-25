<?php
	if(array_key_exists("AuthUser", $allHeaders))
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
					admin
				FROM responsable
				WHERE email = "' . $allHeaders[AuthUser] . '"'
			;
			$req = mysql_query($sql);
			if($req)
			{
				$data = mysql_fetch_assoc($req);
				$numRows=mysql_num_rows($req);

				if($data['admin'] == true)
					echo '<a class="headTitle headButton '.(($menu == 'Lieux' || $menu == 'Responsables')? ' toogled' : '') .'" href="/?menu=lieux">Admin</a>';
			}
		}
	}
?>
