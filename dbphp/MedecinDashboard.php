<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
</head>
<body>
<form method="post" action="/CabinetMedical/dbphp/main.php">
	<input style="float:right;" type="submit" name="medecin" value="Deconnexion">
</form> 
<?php
require_once("DatabaseManager.php");
session_start ();
$userID = $_SESSION["userID"];
$DBManager = $_SESSION["DatabaseManager"];

$ret = $DBManager->runQuery("SELECT nom,prenom from Medecin WHERE medID='$userID';");
$row = pg_fetch_row($ret);
echo "Bonjour Dr. " . $row[1] . " " . $row[0];

$appointment = "SELECT heure, concat(' ', prenom, nom), duree FROM consultation NATURAL JOIN Patient WHERE medID='$userID' AND cdate";
$today = $appointment . "=current_date;";
$next = $appointment . ">current_date;";
$appointmentsToday = $DBManager->runQuery($today);
$appointmentsNext = $DBManager->runQuery($next);
?>
<h2>Consultations d'ajourd'hui</h2>
<table>
<tr>
<th>Heure</th>
<th>Patient</th>
<th>Duree</th>
</tr>
<?php 
while($row = pg_fetch_row($appointmentsToday)){
	for($i=0; $i<pg_num_fields($appointmentsToday); $i++) {
		echo "<tr> \n";
		echo "<td>" . $row[$i] . "</td>";
		echo "</tr> \n";
	}
}
?>
</table>
<h2>Consultations prochaines</h2>
<table>
<tr>
<th>Heure</th>
<th>Patient</th>
<th>Duree</th>
</tr>
<?php 
while($row = pg_fetch_row($appointmentsNext)){
	echo "<tr> \n";
	for($i=0; $i<pg_num_fields($appointmentsNext); $i++) {
		echo "<td>" . $row[$i] . "</td>";
	}
	echo "</tr> \n";
}
?>
</table>
</body>
</html>