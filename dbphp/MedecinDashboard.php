<?php include("Header.php"); ?>
<?php include("nav.php"); ?>
<body>
<?php
$userID = $_SESSION["userID"];

$ret = runQuery("SELECT nom,prenom from Medecin WHERE medID='$userID';");
$row = pg_fetch_row($ret);
?>
<div class="col-md-6 col-md-offset-3">
<h2><span>Vos consultations ajourd'hui</span></h2>
<div class="panel panel-default">
<table class="table table-striped">
	<thead>
		<tr>
<?php
if ($userID[0] == 'M') {	
$query_GetConsultList = "SELECT c.patid, c.medid, c.cdate, heure, prenom, nom, duree FROM Consultation as c, Patient as p WHERE c.patid = p.patid AND c.medID='$userID' AND c.cdate = current_date ORDER BY c.cdate;";
} else {
$query_GetConsultList = "SELECT c.patid, c.medid, c.cdate, heure, prenom, nom, duree FROM Consultation as c, Patient as p WHERE c.patid = p.patid AND c.medID IN (SELECT m.medid FROM medecin as m WHERE m.secid ='$userID') AND c.cdate = current_date ORDER BY c.cdate;";
}
$appointmentsToday = runQuery($query_GetConsultList);
$row = pg_fetch_row($appointmentsToday);
if (pg_num_rows($appointmentsToday) > 0){
?>
			<th>Heure</th>
			<th>Patient</th>
			<th>Duree</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
		    <?php do { ?>
        	    <tr>
        			<td><?php echo $row[3];?></td>
        			<td><?php echo $row[4] . ' ' . $row[5];?></td>
        			<td><?php echo $row[6];?></td>
        			<td><a href="ViewConsultation.php?con=<?php echo $row[0]. $row[1]. $row[2];?>"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></a> | <a href="EditConsultation.php?cond=<?php echo $row[0]. $row[1]. $row[2];?>"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a> <?php if ($userID[0] == 'S') {?> | <a href="DeleteConsultation.php?cond=<?php echo $row[0]. $row[1]. $row[2];?>"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a><?php }?></td>
        		</tr>
        	<?php } while ($row = pg_fetch_row($appointmentsToday));  ?>
	</tbody>
<?php } else { ?>	
			<th>Auncun rendez-vous aujourd'hui</th>
		</tr>
	</thead>
<?php }?>
</table>
</div>
<br>
<h2><span>Vos consultations futures</span></h2>
<div class="panel panel-default">
<table class="table table-striped">
	<thead>
		<tr>
<?php
if ($userID[0] == 'M') {
$query_GetConsultList = "SELECT c.patid, c.medid, c.cdate, heure, prenom, nom, duree FROM Consultation as c, Patient as p WHERE c.patid = p.patid AND c.medID='$userID' AND c.cdate > current_date ORDER BY c.cdate;";
} else {
$query_GetConsultList = "SELECT c.patid, c.medid, c.cdate, heure, prenom, nom, duree FROM Consultation as c, Patient as p WHERE c.patid = p.patid AND c.medID IN (SELECT m.medid FROM medecin as m WHERE m.secid ='$userID') AND c.cdate > current_date ORDER BY c.cdate;";
}
$appointmentsToday = runQuery($query_GetConsultList);
$row = pg_fetch_row($appointmentsToday);
if (pg_num_rows($appointmentsToday) > 0){
?>
			<th>Heure</th>
			<th>Patient</th>
			<th>Duree</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
	    <?php do { ?>
     	    <tr>
       			<td><?php echo $row[3];?></td>
       			<td><?php echo $row[4] . ' ' . $row[5];?></td>
       			<td><?php echo $row[6];?></td>
       			<td><a href="ViewConsultation.php?con=<?php echo $row[0]. $row[1]. $row[2];?>"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></a> | <a href="EditConsultation.php?cond=<?php echo $row[0]. $row[1]. $row[2];?>"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a> <?php if ($userID[0] == 'S') {?> | <a href="DeleteConsultation.php?cond=<?php echo $row[0]. $row[1]. $row[2];?>"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a><?php }?></td>
       		</tr>
   		<?php } while ($row = pg_fetch_row($appointmentsToday));  ?>
	</tbody>
<?php } else { ?>		
			<th>Auncun futur rendez-vous</th>
		</tr>
	</thead>
<?php }?>
</table>
</div>
<tr><td align="center"><button class="btn btn-default" href="CreateConsultation.php" <?php if ($userID[0] != 'S') {?>disabled="disabled"<?php }?>><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>  Nouveau</button></tr>
</div>
</body>
</html>