<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<?php

		function wday2letter($wday)
		{
			switch($wday)
			{
				case 1:
				return "L";
				case 2:
				case 3:
				return "M";
				case 4:
				return "J";
				case 5:
				return "V";
				case 6:
				return "S";
				case 0:
				return "D";
				default:
				return "";
			}
		}

		function wday2tritter($wday)
		{
			switch($wday)
			{
				case 1:
				return "Lun";
				case 2:
				return "Mar";
				case 3:
				return "Mer";
				case 4:
				return "Jeu";
				case 5:
				return "Ven";
				case 6:
				return "Sam";
				case 0:
				return "Dim";
				default:
				return "";
			}
		}

		function wday2jour($wday)
		{
			switch($wday)
			{
				case 1:
				return "Lundi";
				case 2:
				return "Mardi";
				case 3:
				return "Mercredi";
				case 4:
				return "Jeudi";
				case 5:
				return "Vendredi";
				case 6:
				return "Samedi";
				case 0:
				return "Dimanche";
				default:
				return "";
			}
		}

		function mon2mois($mon)
		{
			switch($mon)
			{
				case 1:
				return "Janvier";
				case 2:
				return "Février";
				case 3:
				return "Mars";
				case 4:
				return "Avril";
				case 5:
				return "Mai";
				case 6:
				return "Juin";
				case 7:
				return "Juillet";
				case 8:
				return "Août";
				case 9:
				return "Septembre";
				case 10:
				return "Octobre";
				case 11:
				return "Novembre";
				case 12:
				return "Décembre";
				default:
				return "";
			}
		}

		$menu = 'ErreurMenu';
		$section = 'ErreurSection';
		switch($_GET['menu'])
		{
			case 'responsables':
				$menu = 'Responsables';
			break;
			case 'lieux':
				$menu = 'Lieux';
			break;
			case 'evenements':
				$menu = 'Evenements';
			break;
			case 'newevenement':
				$menu = 'NewEvenement';
			break;
			case 'evenement':
				$menu = 'Evenement';
				switch($_GET['section'])
				{
					case 'edition':
						$section = 'Edition';
					break;
					default:
						$section = 'Details';
					break;
				}
			break;
			case 'espaces':
				$menu = 'Espaces';
				switch($_GET['section'])
				{
					case 'exterieur':
						$section = 'Exterieur';
					break;
					case 'atelier':
						$section = 'Atelier';
					break;
					case 'centre':
						$section = 'Centre';
					break;
					default:
						$section = 'BPI';
					break;
				}
			break;
			default:
				$menu = 'Calendrier';
				switch($_GET['section'])
				{
					case 'section1':
						$section = 'Section1';
					break;
					default:
						$section = 'Calendrier';
					break;
				}
			break;
		}

		$today = ((empty($_GET['timeStamp']) || !is_numeric($_GET['timeStamp'])) ? getdate() : getdate($_GET['timeStamp']));
		switch($_GET['timeAdvance'])
		{
			case 'day':
				$timeAdvance =  "day";
			break;
			case 'year':
				$timeAdvance =  "year";
			break;
			default:
				$timeAdvance =  "month";
			break;
		}
		$realToday = getdate();
	?>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>S-Calendar</title>
		<link rel="stylesheet" type="text/css" href="css/body.css" />
		<link rel="stylesheet" type="text/css" href="css/head.css" />
		<link rel="stylesheet" type="text/css" href="css/table.css" />
		<link rel="stylesheet" type="text/css" href="css/middle.css" />
		<link rel="stylesheet" type="text/css" href="css/foot.css" />
		<link rel="stylesheet" type="text/css" href="css/accessories.css" /><!---->
		<style type="text/css" media="screen">
		</style>

		<script src="js/head.js" type="text/javascript"></script>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js" type="text/javascript" language="javascript"></script>
		<?php
			switch($menu)
			{
				case 'Espaces':
					switch($section)
					{
						case 'Exterieur':
						break;
						case 'Atelier':
						break;
						case 'Centre':
						break;
						case 'BPI':
						break;
						default:
						break;
					}
				break;
				case 'Calendrier':
					switch($section)
					{
						case 'Calendrier':
							switch($timeAdvance)
							{
								case 'day':
									echo('<script src="js/Calendrier/Day.js" type="text/javascript"></script>');
								break;
								case 'year':
									echo('<script src="js/Calendrier/Year.js" type="text/javascript"></script>');
								break;
								case 'month':
									echo('<script src="js/Calendrier/Month.js" type="text/javascript"></script>');
								break;
								default:
								break;
							}
						break;
						default:
						break;
					}
				break;
				case 'Lieux':
					echo('<script src="js/Lieux.js" type="text/javascript"></script>');
				break;
				case 'Responsables':
					echo('<script src="js/Responsables.js" type="text/javascript"></script>');
				break;
				case 'NewEvenement':
					echo('<script src="js/Evenements/New.js" type="text/javascript"></script>');
				break;
				case 'Evenement':
					switch($_GET['section'])
					{
						case 'edition':
							echo('<script src="js/Evenements/Edition.js" type="text/javascript"></script>');
						break;
						default:
						break;
					}
				break;
				default:
				break;
			}
		?>
	</head>
	<body>
		<div class="pageHead">
			<div class="headTitles">
				<div class="headTitle" id="title">
					<p>S-Calendar</p>
				</div>
				<?php
					$allHeaders = getallheaders();
					if(array_key_exists("AuthUser", $allHeaders))
					{
						echo
							'<div class="headTitle headButton ' . (($menu == 'Lieux' || $menu == 'Responsables') ? ' toogled' : '') .'" onclick="displayHeadSelection(0);">
								<p>Admin</p>
							</div>'
						;
					}
				?>
				<!--<div class="headTitle headButton <?php if($menu == 'Calendrier' || $menu == 'NewEvenement') echo ' toogled'; ?>" onclick="displayHeadSelection(1);">
					<p>Calendrier</p>
				</div>-->
				<a class="headTitle headButton <?php if($menu == 'Calendrier' || $menu == 'NewEvenement') echo ' toogled'; ?>" href='/'>Calendrier</a>
				<?php
					switch($menu)
					{
						case 'Espaces':
							echo
								'<div class="headTitle headButton toogled" onclick="displayHeadSelection(2);">
									<p>Espaces</p>
								</div>'
							;
						break;
						case 'Evenement':
							echo
								'<div class="headTitle headButton toogled" onclick="displayHeadSelection(2);">
									<p>Événement</p>
								</div>'
							;
						break;
						case 'Evenements':
							echo
								'<div class="headTitle headButton toogled" onclick="displayHeadSelection(2);">
									<p>Événements</p>
								</div>'
							;
						break;
					}
				?>
				<div class="headTitle headButton" style="display:none;" onclick="displayHeadSelection(2);">
					<p>Recherche</p>
				</div>
				<?php
					$allHeaders = getallheaders();
					if(array_key_exists("AuthUser", $allHeaders))
					{
						echo('<div class="headTitle headButton">');
								echo($allHeaders[AuthUser]);
						echo("</div>");
					}
					else
					{
						echo("<a class=\"headTitle headButton\" href='/connect'>");
								echo("Se connecter");
						echo("</a>");
					}
				?>
				<!--<p>Connexion</p>-->
			</div>
			<div class="headSelections" <?php if($menu != 'Lieux' && $menu != 'Responsables') echo 'style="display:none;"'; ?>>
				<!--<a href="?menu=calendrier" <?php if($menu == 'Calendrier') echo ' class="selected"'; ?>>Calendrier</a>-->
				<!--<a href="?menu=espaces" <?php if($menu == 'Espaces') echo ' class="selected"'; ?>>Espaces</a>-->
				<!--<a href="?menu=newevenement" <?php if($menu == 'NewEvenement') echo ' class="selected"'; ?>>Nouvel événement</a>-->
				<!--<a href="?menu=evenements" <?php if($menu == 'Evenements') echo ' class="selected"'; ?>>Événements</a>-->
				<a href="?menu=lieux" <?php if($menu == 'Lieux') echo ' class="selected"'; ?>>Lieux</a>
				<a href="?menu=responsables" <?php if($menu == 'Responsables') echo ' class="selected"'; ?>>Utilisateurs</a>
			</div>
			<div class="headSelections" <?php if($menu != 'Calendrier' && $menu != 'NewEvenement') echo 'style="display:none;"'; ?>>
				<?php
					echo('<div class="headSelection">');
					/*echo
						'<a href="?menu=calendrier&timeAdvance=day"  class="radio'.(($timeAdvance == 'day') ? ' selected' : '').'">Jour</a>
						<a href="?menu=calendrier&timeAdvance=month" class="radio'.(($timeAdvance == 'month') ? ' selected' : '').'">Mois</a>
						<a href="?menu=calendrier&timeAdvance=year" class="radio'.(($timeAdvance == 'year') ? ' selected' : '').'">Année</a>'
					;*/
					echo("<input type=\"hidden\" name=\"timeStamp\" value=\"" . $today[0] . "\">");
					echo('<form name="calForm" method="get">');
					echo("<input onChange=\"this.form.submit();\" id=\"dayRadioButton\" type=\"radio\" name=\"timeAdvance\" value=\"day\"" . (($timeAdvance == "day") ? "checked" : "") . " />
					<label for=\"dayRadioButton\">Jour</label>");
					echo("<input onChange=\"this.form.submit();\" id=\"monthRadioButton\" type=\"radio\" name=\"timeAdvance\" value=\"month\"" . (($timeAdvance == "month") ? "checked" : "") . " />
					<label for=\"monthRadioButton\">Mois</label>");
					echo("<input onChange=\"this.form.submit();\" id=\"yearRadioButton\" type=\"radio\" name=\"timeAdvance\" value=\"year\"" . (($timeAdvance == "year") ? "checked" : "") . " />
					<label for=\"yearRadioButton\">Année</label>");
					echo("<input type=\"hidden\" name=\"timeStamp\" value=\"" . $today[0] . "\">");

					if($timeAdvance == "year")
					{
						$middleCalendarLegend=$today[year];
						echo("<button id=\"leftArrowButton\" name=\"timeStamp\" type=\"submit\" value=\"" . strtotime(($today[year] - 1) . "/1/1") . "\"><</button>");
						echo("<input id=\"dateSquare\" type=\"text\" value=\"" . $middleCalendarLegend . "\" readonly />");
						echo("<button id=\"rightArrowButton\" name=\"timeStamp\" type=\"submit\" value=\"" . strtotime(($today[year] + 1) . "/1/1") . "\">></button>");
					}
					else if($timeAdvance == "day")
					{
						$middleCalendarLegend=$today[mday].' '.mon2mois($today[mon]).' '.$today[year];//date("jS F Y",$today[0]);
						echo("<button id=\"leftArrowButton\" name=\"timeStamp\" type=\"submit\" value=\"" . ($today[0]-86400) . "\"><</button>");
						echo("<input id=\"dateSquare\" type=\"text\" value=\"" . $middleCalendarLegend . "\" readonly />");
						echo("<button id=\"rightArrowButton\" name=\"timeStamp\" type=\"submit\" value=\"" . ($today[0]+86400) . "\">></button>");
					}
					else
					{
						$middleCalendarLegend=mon2mois($today[mon]).' '.$today[year];//date("F Y",$today[0]);
						$prevMonth=$today[mon]-1;
						$nextMonth=$today[mon]+1;
						$prevYear=$today[year];
						$nextYear=$today[year];
						if($nextMonth>=13)
						{
							$nextMonth=1;
							$nextYear=$today[year]+1;
						}
						if($prevMonth<=0)
						{
							$prevMonth=12;
							$prevYear=$today[year]-1;
						}
						echo('<button id="leftArrowButton" name="timeStamp" type="submit" value="' . strtotime($prevYear . '-' . $prevMonth . '-1') . '"><</button>');
						echo('<input id="dateSquare" type="text" value="' . $middleCalendarLegend . '" readonly="true" />');
						echo('<button id="rightArrowButton" name="timeStamp" type="submit" value="' . strtotime($nextYear . '-' . $nextMonth . '-1') . '">></button>');
					}

					echo('<button name="timeStamp" type="submit" value="' . ($realToday[0]) . '">Aujourd\'hui</button>');
					echo
							'</form>
						</div>'
					;
					if($menu == 'NewEvenement')
						echo '<a href="?menu=newevenement&date='.date("Ymd",$today[0]).'" class="selected">Nouvel événement</a>';
					else
						echo '<a href="?menu=newevenement&date='.date("Ymd",$today[0]).'">Nouvel événement</a>';
				?>
			</div>
			<div class="headSelections" <?php if($menu != 'Espaces' && $menu != 'Evenement') echo 'style="display:none;"'; ?>>
				<?php
					switch($menu)
					{
						case 'Espaces':
							echo
								'<a href="?menu=espaces"'.(($section == 'BPI')? ' class="selected"' : '').'>Espaces BPI</a>
								<a href="?menu=espaces&section=centre"'.(($section == 'Centre')? ' class="selected"' : '').'>Espaces Centre</a>
								<a href="?menu=espaces&section=atelier"'.(($section == 'Atelier')? ' class="selected"' : '').'>Atelier</a>
								<a href="?menu=espaces&section=exterieur"'.(($section == 'Exterieur')? ' class="selected"' : '').'>Hors les murs</a>'
							;
						break;
						case 'Evenement':
							echo('<a href="?menu=evenement&eventID='.$_GET[eventID].'"'.(($section == 'Details')? ' class="selected"' : '').'>Détails</a>');
							echo('<a href="?menu=evenement&section=edition&eventID='.$_GET[eventID].'"'.(($section == 'Edition')? ' class="selected"' : '').'>Édition</a>');
						break;
					}
				?>
			</div>
		</div>
		<div class="pageMid">
			<!--<div class="middleParts" style="display: table;">
				<div class="middlePart">
					<fieldset class="middleWarningMessage">
						<legend>Warning!</legend>
						Site en construction
					</fieldset>
				</div>
			</div>
			<div class="middleParts" style="display: table;">
				<div class="middlePart">
					<fieldset class="middleWarningMessage">
						<legend>Warning!</legend>
						<?php
							print_r($today);
						?>
					</fieldset>
				</div>
			</div>-->
			<?php
				switch($menu)
				{
					case 'Espaces':
						switch($section)
						{
							case 'Exterieur':
								$txtError='DefinedError';
								include('errorFieldSet.php');
							break;
							case 'Atelier':
								include('errorFieldSet.php');
							break;
							case 'Centre':
							break;
							case 'BPI':
							break;
							default:
							break;
						}
					break;
					case 'Calendrier':
						switch($section)
						{
							case 'Calendrier':
								echo
									'<div id="eventDescription">
										<div class="middleParts">
											<div class="middlePart">
												<fieldset style="height: 135px;">
													<legend>Description</legend>
												</fieldset>
											</div>
										</div>
									</div>'
								;
								echo
									'<div class="middleParts">
										<div class="middlePart">
											<fieldset>
												<legend>' . $middleCalendarLegend . '</legend>'
								;
								include('calendar.php');
								echo
									'</fieldset>
										</div>
									</div>'
								;
							break;
							default:
							break;
						}
					break;
					case 'Evenement':
						switch($section)
						{
							case 'Edition':
								include('eventEdition.php');
							break;
							default:
								include('eventDetail.php');
							break;
						}
					break;
					case 'NewEvenement':
						include('newEvent.php');
					break;
					case 'Lieux':
						include('lieux.php');
					break;
					case 'Responsables':
						include('responsables.php');
					break;
					default:
					break;
				}
			?>
		</div>
		<div class="pageFoot">
			<div class="footParts">
				£
				<!--<a class="footPart" class="footOption" id="facebookOption" href="https://fr-fr.facebook.com/bpi.pompidou"></a>
				<a class="footPart" class="footOption" id="twitterOption" href="https://twitter.com/bpi_pompidou"></a>-->
				<!--<a class="footPart" class="footOption" id="googlePlusOption" href=""></footPart>-->
				<!--<footPart class="footOption">
					<p>Opt3</p>
				</footPart>-->
			</div>
		</div>
	</body>
</html>
