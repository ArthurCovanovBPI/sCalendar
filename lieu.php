<?php
	if(isset($_GET['espaceID']) && is_numeric($_GET['espaceID']))
	{
		$servername = "127.0.0.1";
		$username = "root";
		$password = "password";
		$dbname = "bpi_calendar";

		$conn = mysqli_connect($servername, $username, $password, $dbname);
		if (!$conn)
		{
			echo
				'<fieldset class="middlePart middleErrorMessage">
					<legend>logs ERROR!</legend>'.
					'Connection failed: ' . mysqli_connect_errno() . ' : ' . mysqli_connect_error()
				.'</fieldset>'
			;
			exit(1);
		}
		mysqli_select_db($dbname, $conn);
		mysqli_query('SET character_set_results = "UTF8", character_set_client = "UTF8", character_set_connection = "UTF8", character_set_database = "UTF8", character_set_server = "UTF8"');
	}
	else
	{
		echo
			'<fieldset class="middlePart middleErrorMessage">
				<legend>espaceID ERROR!</legend>'.
				'Unrecognized espaceID: ' . $_GET['espaceID']
			.'</fieldset>'
		;
		exit(1);/**/
	}
	$resultPerPages=40;
?>
<fieldset style="min-height: 120px;">
	<legend>
	<?php
		$sql = 
			'SELECT
				espace
			FROM espace
			WHERE ID = ' . $_GET['espaceID']
		;
		$req = mysqli_query($conn, $sql);
		if(!$req)
		{
			echo('ERROR');
		}
		else
		{
			$data = mysqli_fetch_assoc($req);
			$espaceName = $data['espace'];
			echo $espaceName;
		}
	?>
	</legend>
	<?php
		$page = (isset($_GET['page']) && is_numeric($_GET['page'])) ? (int)$_GET['page'] : 1;

		$sql =
			'SELECT
				COUNT(*) AS count
			FROM lieu
			WHERE espace_ID = ' . $_GET['espaceID']
		;
		$req = mysqli_query($conn, $sql);
		if(!$req)
		{
			echo('SQL ERROR: ' . $sql . '<br />');
			echo(mysqli_errno($conn) . ' : ' . mysqli_error($conn) . '<br />');
		}
		else
		{
			$data = mysqli_fetch_assoc($req);
			$numPages = ceil($data['count']/$resultPerPages);
			if($page>$numPages)$page=$numPages;
			if($page<=0)$page=1;
			echo '<span style="line-height: 17px;">Page ' . $page . '/' . $numPages.'</span>';
			echo '<span style="float: right;">';
				echo '<span onclick="loadLieu(' . $_GET['espaceID'] . ', 1)" class="pageButton clickablePageButton">≪</span>';
				echo '<span onclick="loadLieu(' . $_GET['espaceID'] . ', ' . ($page-1) . ')" class="pageButton clickablePageButton"><</span>';
				if($page>3)
				{
					echo '<span class="pageButton">...</span>';
				}
				if($page>2)
				{
					echo '<span onclick="loadLieu(' . $_GET['espaceID'] . ', ' . ($page-2) . ')" class="pageButton clickablePageButton">' . ($page-2) . '</span>';
				}
				if($page>1)
				{
					echo '<span onclick="loadLieu(' . $_GET['espaceID'] . ', ' . ($page-1) . ')" class="pageButton clickablePageButton">' . ($page-1) . '</span>';
				}
				echo '<span class="pageButton" style="font-size: 115%; font-weight: bold;">' . ($page) . '</span>';
				if($page<=$numPages-1)
				{
					echo '<span onclick="loadLieu(' . $_GET['espaceID'] . ', ' . ($page+1) . ')" class="pageButton clickablePageButton">' . ($page+1) . '</span>';
				}
				if($page<=$numPages-2)
				{
					echo '<span onclick="loadLieu(' . $_GET['espaceID'] . ', ' . ($page+2) . ')" class="pageButton clickablePageButton">' . ($page+2) . '</span>';
				}
				if($page<=$numPages-3)
				{
					echo '<span class="pageButton">...</span>';
				}
				echo '<span onclick="loadLieu(' . $_GET['espaceID'] . ', ' . ($page+1) . ')" class="pageButton clickablePageButton">></span>';
				echo '<span onclick="loadLieu(' . $_GET['espaceID'] . ', ' . $numPages . ')" class="pageButton clickablePageButton">≫</span>';
			echo '</span>';
		}

		$sql =
			/*'SELECT
				lieu.ID AS ID,
				lieu,
				e.espace
			FROM lieu
			INNER JOIN espace AS e ON lieu.espace_ID = e.ID';*/
			'SELECT
				lieu.ID AS ID,
				lieu
			FROM lieu
			WHERE espace_ID = ' . $_GET['espaceID'] .
			' LIMIT ' . $resultPerPages .
			' OFFSET ' . (($page-1)*$resultPerPages)
		;
		$req = mysqli_query($conn, $sql);
		if(!$req)
		{
			echo('SQL ERROR: ' . $sql . '<br />');
			echo(mysqli_errno($conn) . ' : ' . mysqli_error($conn) . '<br />');
		}
		else
		{
			echo '<table style="width: 100%; cursor: default; border-collapse: collapse;">';
			$i = 0;
			//echo '<tr><th>ID</th><th style="padding-left: 2px; padding-right: 2px; text-align: right; width :90%;">Lieu</th><th>-</th></tr>';
			echo '<tr><th style="padding-left: 2px; padding-right: 2px; text-align: right; width :100%;">Lieu</th><th>✎</th><th>-</th></tr>';
			while($data = mysqli_fetch_assoc($req))
			{
				echo '<tr id=\'seeLieu' . $data['ID'] . '\' style=\'display:table-row;\'>';
					//echo '<td style="padding-left: 2px; padding-right: 2px; white-space: nowrap; text-align: center;">'.$data['ID'].'</td>';
					echo '<td style="padding-left: 2px; padding-right: 2px; white-space: nowrap; text-align: right;">'.$data['lieu'].'</td>';
					echo '<td onclick="editLieu(\'' . $data['ID'] . '\')" style="padding-left: 2px; padding-right: 2px; white-space: nowrap; text-align: center; font-weight: bold; cursor:pointer;">✎</td>';
					echo '<td onclick="deleteLieu(\'' . $data['ID'] . '\', \'' . $data['lieu'] . '\', \'' . $_GET['espaceID'] . '\', \'' . $espaceName . '\', \'' . $page . '\')" style="padding-left: 2px; padding-right: 2px; white-space: nowrap; text-align: center; font-weight: bold; cursor:pointer;">×</td>';
				echo '</tr>';
				echo '<tr id=\'editLieu' . $data['ID'] . '\' style=\'display:none;\'>';
					echo '<td style="white-space: nowrap; text-align: center;"><input id="editionlieu'.$data['ID'].'" type="text" maxlength="255" style="width: 100%; box-sizing: border-box;" value="' . $data['lieu'] . '" /></td>';
					echo '<td onclick="uploadLieu(\''.$data['lieu'].'\', \'' . $data['ID'] . '\', \'' . $_GET['espaceID'] . '\', \'' . $espaceName . '\', \'' . $numPages . '\')" style="padding-left: 2px; padding-right: 2px; white-space: nowrap; text-align: center; font-weight: bold; cursor:pointer;">↘</td>';
					echo '<td onclick="cancelEditLieu(\'' . $data['ID'] . '\')" style="padding-left: 2px; padding-right: 2px; white-space: nowrap; text-align: center; font-weight: bold; cursor:pointer;">×</td>';
				echo '</tr>';
			}
			echo '<tr>';
				echo '<td colspan=3 style="padding-left: 2px; padding-right: 2px; border: 1px solid #A0A0A0; white-space: nowrap; text-align: center;">Ajouter un lieu:</td>';
			echo '</tr>';
			echo '<tr>';
				echo '<td colspan=2 style="white-space: nowrap; text-align: center;"><input id="inputlieu'.$_GET['espaceID'].'" type="text" maxlength="255" style="width: 100%; box-sizing: border-box;" /></td>';
				echo '<td onclick="addLieu(\'' . 'inputlieu'.$_GET['espaceID'] . '\', \'' . $_GET['espaceID'] . '\', \'' . $espaceName . '\', \'' . $numPages . '\')" style="padding-left: 2px; padding-right: 2px; white-space: nowrap; text-align: center; font-weight: bold; cursor:pointer;">+</td>';
			echo '</tr>';
			echo '</table>';
		}
		mysqli_close($conn);
	?>
</fieldset>
