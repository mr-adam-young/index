<?php
/* 

# index_inspector.php
For loading a single node as a webpage

*/
require_once __DIR__.'/includes/main-include.php';
require_once __DIR__.'/includes/panel-header.php';
?>

<pre>
<?php print_r(interverse_neo4j("MATCH (n) WHERE ID(n) = {$_GET['id']} RETURN n", false)); ?>
</pre>

<?php
require_once __DIR__.'/includes/panel-footer.php';