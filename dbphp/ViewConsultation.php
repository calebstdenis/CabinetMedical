<?php include("Header.php"); ?>
<?php include("nav.php"); ?>
<body>
<?php
$pid = $_GET['con'][0]. $_GET['con'][1]. $_GET['con'][2]. $_GET['con'][3];
$mid = $_GET['con'][4]. $_GET['con'][5]. $_GET['con'][6]. $_GET['con'][7];
$dt = $_GET['con'][8]. $_GET['con'][9]. $_GET['con'][10]. $_GET['con'][11]. $_GET['con'][12]. $_GET['con'][13]. $_GET['con'][14]. $_GET['con'][15]. $_GET['con'][16]. $_GET['con'][17];

if(isset($_GET['con']))
{
 $query_GetConsult="SELECT patid, medid, cdate, heure, duree, objet FROM consultation WHERE patid='$pid' AND medid='$mid' AND cdate='$dt'";
 $appointments = runQuery($query_GetConsult);
 $row = pg_fetch_row($appointments);
}
?>

<div class="col-md-6 col-md-offset-3">
	<h2><span>Details de la consulation</span></h2>
	<div class="panel panel-default">
		<div class="panel-body">
		    <form class="form-horizontal">
		    	<div class="form-group">
		    		<label class="col-md-2 control-label">Patient:</label>
		    		<div class="col-md-3">
		    			<select class="form-control" name="pat_id" readonly>
		    				<?php 
		    				$query_GetPatients = "SELECT patid, prenom, nom FROM patient WHERE patid='$pid' ORDER BY nom;";
							$patients = runQuery($query_GetPatients);
							$pnames = pg_fetch_row($patients);
							do {
							?>
		    					<option value="<?php echo $pnames[0];?>"><?php echo $pnames[1]. ' ' . $pnames[2];?></option>
		    				<?php } while ($pnames = pg_fetch_row($patients));  ?>
		    			</select>
		    		</div>
		    		<label class="col-md-2 control-label">Medecin:</label>
		    		<div class="col-md-3">
		    			<select class="form-control" name="med_id" readonly>
		    				<?php 
		    				$query_GetMedecins = "SELECT medid, prenom, nom FROM medecin WHERE medid='$mid' ORDER BY nom;";
							$medecins = runQuery($query_GetMedecins);
							$mnames = pg_fetch_row($medecins);
							do {
							?>
		    					<option value="<?php echo $mnames[0];?>"><?php echo $mnames[1]. ' ' . $mnames[2];?></option>
		    				<?php } while ($mnames = pg_fetch_row($medecins));  ?>
		    			</select>
		    		</div>
		    	</div>
		    	<div class="form-group">
		    		<label class="col-md-2 control-label">Date:</label>
		    		<div class="col-md-3">
		    			<input type="date" class="form-control" name="first_name" value="<?php echo $row[2];?>" readonly />
		    		</div>
		    		<label class="col-md-2 control-label">Heure:</label>
		    		<div class="col-md-3">
		    			<input type="time" class="form-control" name="first_name" value="<?php echo $row[3];?>" readonly />
		    		</div>
		    	</div>
		    	<div class="form-group">
		    		<label class="col-md-2 control-label">Duree:</label>
		    		<div class="col-md-3">
		    			<input type="text" class="form-control" name="first_name" value="<?php echo $row[4];?>" readonly />
		    		</div>
		    	</div>
		    	<div class="form-group">
		    		<label class="col-md-2 control-label">Object:</label>
		    		<div class="col-md-8">
		    			<input type="text" class="form-control" name="first_name" value="<?php echo $row[5];?>" readonly />
		    		</div>
		    	</div>
		    </form>
		</div>
	    <div class="panel-footer" align="center">
	    	<a href="MedecinDashboard.php"><button class="btn btn-default">Retour</button></a>
	    </div>
	</div>
</div>
</body>
</html>