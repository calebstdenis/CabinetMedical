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

$ret = $DBManager->getDoctorFullName($userID);

$row = pg_fetch_row($ret);

echo "Bonjour, Dr. " . $row[1] . " " . $row[0];
?>
</body>
</html>