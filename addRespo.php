<?php
	header('HTTP/1.1 500 Internal Server Error');
	print('aaa');
	if(isset($_POST['mail'])&&isset($_POST['name'])&&isset($_POST['admin'])&&isset($_POST['centre'])&&isset($_POST['externe'])&&isset($_POST['BPI'])&&isset($_POST['atelier'])&&isset($_POST['manifPublique'])&&isset($_POST['manifInterne'])&&isset($_POST['manifAdmin'])&&isset($_POST['manifRH'])&&isset($_POST['manifFiancier'])&&isset($_POST['manifCalendaire'])&&is_bool($_POST['admin'])&&is_bool($_POST['centre'])&&is_bool($_POST['externe'])&&is_bool($_POST['BPI'])&&is_bool($_POST['atelier'])&&is_bool($_POST['manifPublique'])&&is_bool($_POST['manifInterne'])&&is_bool($_POST['manifAdmin'])&&is_bool(_POST['manifRH'])&&is_bool($_POST['manifFiancier'])&&is_bool($_POST['manifCalendaire']))
	{
		print('bbb');
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

			$sql =	'SELECT * FROM responsable WHERE email = ("' . (str_replace('\\', '\\\\', (str_replace('"', '""', $_POST['mail'])))) . '") LIMIT 1';
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
				print('L\'utilisateur ' . (str_replace('\\', '\\\\', (str_replace('"', '""', $_POST['mail'])))) . ' existe déjà.');
				exit();
			}

			$sql =	'INSERT INTO responsable(email, nom, admin, contributeur_centre, contributeur_bpi, contributeur_externe, contributeur_atelier, contributeur_manif_publique, contributeur_manif_interne, contributeur_manif_admin, contributeur_manif_rh, contributeur_manif_financier, contributeur_manif_calendar)
					 VALUES ("' . (str_replace('\\', '\\\\', (str_replace('"', '""', $_POST['mail'])))) . '","' . (str_replace('\\', '\\\\', (str_replace('"', '""', $_POST['name'])))) . '",' . $_POST['admin'] . ',' . $_POST['centre'] . ',' . $_POST['externe'] . ',' . $_POST['BPI'] . ',' . $_POST['atelier'] . ',' . $_POST['manifPublique'] . ',' . $_POST['manifInterne'] . ',' . $_POST['manifAdmin'] . ',' . $_POST['manifRH'] . ',' . $_POST['manifFiancier'] . ',' . $_POST['manifCalendaire'] . ')'
			;
			$req = mysql_query($sql);
			if(!$req)
			{
				header('HTTP/1.1 500 Internal Server Error');
				print(mysql_errno($conn) . ' : ' . mysql_error($conn) . '<br />' . $sql);
				exit();
			}
			else
			{
				$sql =	'SELECT COUNT(*) AS count FROM responsable WHERE email <= ("' . (str_replace('\\', '\\\\', (str_replace('"', '""', $_POST['mail'])))) . '")';
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
	}
	else
	{
		header('HTTP/1.1 500 Internal Server Error');
		print('Error 500');
	}
?>
