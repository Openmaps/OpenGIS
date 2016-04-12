<?php
header("Content-Type: text/xml");
echo '<?xml version="1.0" encoding="utf-8" standalone="yes" ?><response>';
   $connstr = "host=localhost port=5432 dbname=postgis_22_sample user=postgres password=root";
   $pdo = pg_connect($connstr);
  // Check if the form has been submitted:
	$error = false;
	if (!empty($_POST['geom'])) {
	  $geo = pg_escape_string($pdo, strip_tags($_POST['geom']));
	} else {
	  $error = true;
	  echo '<error>geom</error>';
	}
	
	if (!empty($_POST['name'])) {
	  $nam = pg_escape_string($pdo, strip_tags($_POST['name']));
	} else {
	  $error = true;
	  echo '<error>name</error>';
	}
	if (!$error) {
	  $sql = "INSERT INTO newparcels (name, geom)
				VALUES ('$nam',ST_SetSRID(ST_MakePolygon(ST_GeomFromText('LINESTRING($geo)')),4326))";
	  $r = pg_exec($pdo,$sql);
	  if ($r) {
			echo '<result>'.$nam.' added.</result>';
	  } else { // Query failure.
			echo '<result>The parcel could not be added due to a system error.'. pg_last_error($pdo) . '</result>';
	  }
	} else { // Errors!
		echo '<result>Please check marked field(s) below.</result>';
	}
echo '</response>';
?>
