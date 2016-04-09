<?php setlocale(LC_ALL, "fr_CA.UTF-8","fra");?>
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
$tableHeaders;
$tableData;

require_once("DatabaseManager.php");
session_start ();
$userID = $_SESSION["userID"];

$ret = runQuery("SELECT nom,prenom from Medecin WHERE medID='$userID';");
$row = pg_fetch_row($ret);
?>
<ul>
<li> <?php echo "Bonjour Dr. " . $row[1] . " " . $row[0]; ?>
<li> Le <?php echo strftime("%A %d %B %Y"); ?>
</ul>
<h2>Consultations d'ajourd'hui</h2>
<?php 
$sql = "SELECT heure, concat(' ', prenom, nom), duree FROM consultation NATURAL JOIN Patient WHERE medID='$userID' AND cdate =current_date;";
$appointmentsToday = runQuery($sql);


if(pg_num_rows($appointmentsToday) == 0) {
	echo "Vous n'avez aucune consultation ajourd'hui.";
}
else {
	
	$tableData = $appointmentsToday;
	include("TableTemplate.php");
}
?>
<h2>Consultations prochaines</h2>
<?php
$sql = "SELECT cdate, heure, concat(' ', prenom, nom), duree FROM consultation NATURAL JOIN Patient WHERE medID='$userID' AND cdate > current_date ORDER BY cdate;";
$appointmentsNext = runQuery($sql);

if(pg_num_rows($appointmentsNext) == 0) {
	echo "Vous n'avez aucunes consultations prochaines.";
}
else {
	$tableHeaders = array("Date", "Heure", "Patient", "Duree");
	$tableData = $appointmentsNext;
	include("TableTemplate.php");
}
?>
</body>
</html>