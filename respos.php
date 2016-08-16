<?php
	$servername = "127.0.0.1";
	$username = "root";
	$password = "password";
	$dbname = "bpi_calendar";

	$conn = mysql_connect($servername, $username, $password, $dbname);
	if ($conn->connect_error)
	{
		echo
			'<fieldset class="middlePart middleErrorMessage">
				<legend>logs ERROR!</legend>'.
				'Connection failed: ' . $conn->connect_error
			.'</fieldset>'
		;
		exit(1);
	}
	mysql_select_db($dbname, $conn);
	mysql_query('SET character_set_results = "UTF8", character_set_client = "UTF8", character_set_connection = "UTF8", character_set_database = "UTF8", character_set_server = "UTF8"');
	$resultPerPages=40;
?>
<fieldset style="min-height: 120px;">
	<legend>Reponsable</legend>
	<?php
		$page = (isset($_GET['page']) && is_numeric($_GET['page'])) ? (int)$_GET['page'] : 1;

		$sql =
			'SELECT
				COUNT(*) AS count
			FROM responsable'
		;
		$req = mysql_query($sql);
		if(!$req)
		{
			echo('ERROR');
		}
		else
		{
			$data = mysql_fetch_assoc($req);
			$numPages = ceil($data['count']/$resultPerPages);
			if($page>$numPages)$page=$numPages;
			if($page<=0)$page=1;
			echo '<span style="line-height: 17px;">Page ' . $page . '/' . $numPages.'</span>';
			echo '<span style="float: right;">';
				echo '<span onclick="loadRespos(1)" class="pageButton clickablePageButton">≪</span>';
				echo '<span onclick="loadRespos(' . ($page-1) . ')" class="pageButton clickablePageButton"><</span>';
				if($page>3)
				{
					echo '<span class="pageButton">...</span>';
				}
				if($page>2)
				{
					echo '<span onclick="loadRespos(' . ($page-2) . ')" class="pageButton clickablePageButton">' . ($page-2) . '</span>';
				}
				if($page>1)
				{
					echo '<span onclick="loadRespos(' . ($page-1) . ')" class="pageButton clickablePageButton">' . ($page-1) . '</span>';
				}
				echo '<span class="pageButton" style="font-size: 115%; font-weight: bold;">' . ($page) . '</span>';
				if($page<=$numPages-1)
				{
					echo '<span onclick="loadRespos(' . ($page+1) . ')" class="pageButton clickablePageButton">' . ($page+1) . '</span>';
				}
				if($page<=$numPages-2)
				{
					echo '<span onclick="loadRespos(' . ($page+2) . ')" class="pageButton clickablePageButton">' . ($page+2) . '</span>';
				}
				if($page<=$numPages-3)
				{
					echo '<span class="pageButton">...</span>';
				}
				echo '<span onclick="loadRespos(' . ($page+1) . ')" class="pageButton clickablePageButton">></span>';
				echo '<span onclick="loadRespos(' . $numPages . ')" class="pageButton clickablePageButton">≫</span>';
			echo '</span>';
		}
	?>
	<?php
		$sql =	'SELECT
					ID,
					nom
				FROM responsable
				ORDER BY nom
				LIMIT ' . $resultPerPages .
				' OFFSET ' . (($page-1)*$resultPerPages)
		;
		$req = mysql_query($sql);
		if(!$req)
		{
			echo('SQL ERROR: ' . $sql . '<br />');
			echo(mysql_errno($conn) . ' : ' . mysql_error($conn));
		}
		else
		{
			echo '<table style="width: 100%; cursor: default; border-collapse: collapse;">';
			$i = 0;
			echo '<tr><th>ID</th><th style="padding-left: 2px; padding-right: 2px; text-align: right; width :90%;">Lieu</th><th>-</th></tr>';
			while($data = mysql_fetch_assoc($req))
			{
				echo '<tr>';
					echo '<td style="padding-left: 2px; padding-right: 2px; white-space: nowrap; text-align: center;">'.$data['ID'].'</td>';
					echo '<td style="padding-left: 2px; padding-right: 2px; white-space: nowrap; text-align: right; width: 100%;">'.$data['nom'].'</td>';
					echo '<td onclick="deleteRespo(\'' . $data['ID'] . '\', \'' . $data['nom'] . '\', \'' . $page . '\')" style="padding-left: 2px; padding-right: 2px; white-space: nowrap; text-align: center; font-weight: bold; cursor:pointer;">×</td>';
				echo '</tr>';
			}
			echo '<tr>';
				echo '<td colspan=3 style="padding-left: 2px; padding-right: 2px; border: 1px solid #A0A0A0; white-space: nowrap; text-align: center;">Ajouter un Responsable:</td>';
			echo '</tr>';
			echo '<tr>';
				echo '<td colspan=2 style="white-space: nowrap; text-align: center;"><input id="inputRespo" type="text" maxlength="255" style="width: 100%; box-sizing: border-box;" /></td>';
				echo '<td onclick="addRespo(\'inputRespo\', \'' . $resultPerPages . '\')" style="padding-left: 2px; padding-right: 2px; white-space: nowrap; text-align: center; font-weight: bold; cursor:pointer;">+</td>';
			echo '</tr>';
			echo '</table>';
		}
	?>
</fieldset>
