<?php
#Connect to postgreSQL database
$conn = new PDO('pgsql:host=localhost;dbname=postgis_22_sample','postgres','root');
//Get parameters from URL
$x = $_GET["x"];
#Build SQL SELECT statement and return the geometry as a GeoJSON element
#ilike makes the search case insensitive
$lr = "SELECT f_r, lr_no, ST_AsGeoJSON(ST_Transform((geom),4326),6) AS geojson FROM main.parcels where f_r ilike '$x%'";

#Try query or error
$res = $conn->query($lr);
if (!$res) {
    echo 'An SQL error occured.';
    exit;
}
#Build GeoJSON feature collection array
$geojson = array(
   'type'      => 'FeatureCollection',
   'features'  => array()
);
#Loop through rows to build feature arrays
while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
    $properties = $row;
    #Remove geojson and geometry fields from properties
    unset($properties['geojson']);
    unset($properties['geom']);
    $feature = array(
         'type' => 'Feature',
         'geometry' => json_decode($row['geojson'], true),
         'properties' => $properties
    );
    #Add feature arrays to feature collection array
    array_push($geojson['features'], $feature);
}
header('Content-type: application/json');

echo json_encode($geojson, JSON_NUMERIC_CHECK);

$conn = NULL;

?>
