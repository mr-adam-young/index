<?php
# http://isme.interversal.systems/csv-to-neo4j.php
require_once __DIR__.'/includes/main-include.php';
require_once __DIR__.'/includes/panel-header.php';

# get info from .csv file with headers, convert to PHP array
# pass a .csv file to this script via POST
$csv = interverse_csv_to_array('data/branded_food.csv');

# loop through the array, for each row do the following
foreach ($csv as $row) {
    $properties = array();
    foreach ($row as $property => $value) {
        $properties[] = " {$property} : '{$value}'";
    }
    $joined = implode(",", $properties);

    # insert new objects into the graph individually, then form the relationship
    interverse_neo4j("MERGE (n:Product {{$joined}}) ON CREATE SET n.created = timestamp()", !false);
    interverse_neo4j("MERGE (n:Organization { name:'{$row['brand_owner']}'}) ON CREATE SET n.created = timestamp()", !false);
    interverse_neo4j("MATCH (m:Organization { name: '{$row['brand_owner']}' }), (n:Product { fdc_id: '{$row['fdc_id']}' }) MERGE (n)<-[r:OWNS]-(m)", !false);

    echo "Line";
    ob_flush();
}
