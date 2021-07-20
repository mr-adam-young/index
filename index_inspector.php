<?php /* -------------------------------------
# index_inspector.php

Load a single node as a webpage and display its properties and relationships
---------------------------------------------*/
require_once __DIR__.'/includes/main-include.php';
require_once __DIR__.'/includes/panel-header.php';
?>

<pre>
<?php 

$result = interverse_neo4j("MATCH (n) WHERE ID(n) = {$_GET['id']} RETURN n", false); 
echo "<p>Raw result</p>";

$result = get_object_vars($result);
echo "<p>get_object_vars()</p>";
var_dump($result);
echo "<p>json encode+decode trick</p>";
echo json_decode(json_encode($result));

?>
</pre>

<?php
require_once __DIR__.'/includes/panel-footer.php';