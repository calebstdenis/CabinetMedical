<?php

require_once("DatabaseManager.php");
session_start();

$DatabaseManager = new DatabaseManager();

if(! $DatabaseManager->connect() ) {
	echo "Error : Unable to connect to the database\n";
}
else {
	$_SESSION["DatabaseManager"] = $DatabaseManager;
	$_SESSION["userID"] = $_POST["userID"];
	header('Location: /CabinetMedical/dbphp/MedecinDashboard.php');
}

?>