<?php
# Connect to database
$conn = new PDO('pgsql:host=localhost;dbname=postgis_22_sample','postgres','root');
# Build SQL SELECT statement and return the geometry as a GeoJSON element
$sql = 'SELECT *, public.ST_AsGeoJSON(public.ST_Transform((geom),4326),6) AS geojson FROM main.parcels WHERE land_owner islike 'Leonard'';
/*
* If bbox variable is set, only return records that are within the bounding box
* bbox should be a string in the form of 'southwest_lng,southwest_lat,northeast_lng,northeast_lat'
* Leaflet: map.getBounds().toBBoxString()
*/
if (isset($_GET['bbox'])) {
    $bbox = explode(',', $_GET['bbox']);
    $sql = $sql . ' WHERE main.ST_Transform(geom, 4326) && main.ST_SetSRID(main.ST_MakeBox2D(main.ST_Point('.$bbox[0].', '.$bbox[1].'), main.ST_Point('.$bbox[2].', '.$bbox[3].')),4326);';
}
# Try query or error
$rs = $conn->query($sql);
if (!$rs) {
    echo 'An SQL error occured.\n';
    exit;
}
# Build GeoJSON feature collection array
$geojson = array(
   'type'      => 'FeatureCollection',
   'features'  => array()
);
# Loop through rows to build feature arrays
while ($row = $rs->fetch(PDO::FETCH_ASSOC)) {
    $properties = $row;
    # Remove geojson and geometry fields from properties
    unset($properties['geojson']);
    unset($properties['geom']);
    $feature = array(
         'type' => 'Feature',
         'geometry' => json_decode($row['geojson'], true),
         'properties' => $properties
    );
    # Add feature arrays to feature collection array
    array_push($geojson['features'], $feature);
}
header('Content-type: application/json');
echo json_encode($geojson, JSON_NUMERIC_CHECK);
$conn = NULL;
?>
