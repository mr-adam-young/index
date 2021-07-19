<?php
/* 

# index_inspector.php
For loading a single node as a webpage

*/
require_once __DIR__.'/includes/main-include.php';
require_once __DIR__.'/includes/panel-header.php';
?>

<h1>All Nodes in Graph</h1>

<?php 
$all_nodes = interverse_neo4j("MATCH (n) RETURN *", false); 

foreach ($all_nodes as $node) {
        $node = json_decode($node[0]);
        $name = "";
        if (!isset($node->properties->name)) {
                $name = "(blank)";
                echo "<a href=\"index_inspector.php?id={$node->identity}\">{$node->identity} : {$name}</a><br>";
        } else {
                $name = $node->properties->name;
                echo "<a href=\"index_inspector.php?id={$node->identity}\">{$node->identity} : {$name}</a><br>";
        }
        
}

# commenting interface would go here :)

require_once __DIR__.'/includes/panel-footer.php';