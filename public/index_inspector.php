<?php /* -------------------------------------
# index_inspector.php

Load a single node as a webpage and display its properties and relationships
---------------------------------------------*/
require_once __DIR__.'/includes/main-include.php';
require_once __DIR__.'/includes/panel-header.php';

$result = interverse_neo4j("MATCH (n) WHERE ID(n) = {$_GET['id']} RETURN n", false); 
echo "<p>Raw result</p>";

$result = get_object_vars($result);
echo "<p>get_object_vars()</p>";
var_dump($result);
echo "<p>json encode+decode trick</p>";
echo json_decode(json_encode($result));

echo "<pre>";
var_dump($object[0]);
$json = json_encode($object[0]->properties);
echo $json;
echo "</pre>";

require_once __DIR__.'/includes/panel-footer.php';

/*
//Object
echo $object->anotherObject->propertyArray["elementOneWithAnObject"]->property;
    //├────┘  ├───────────┘  ├───────────┘ ├──────────────────────┘   ├──────┘
    //│       │              │             │                          └── property ; 
    //│       │              │             └───────────────────────────── array element (object) ; Use -> To access the property 'property'
    //│       │              └─────────────────────────────────────────── array (property) ; Use [] To access the array element 'elementOneWithAnObject'
    //│       └────────────────────────────────────────────────────────── property (object) ; Use -> To access the property 'propertyArray'
    //└────────────────────────────────────────────────────────────────── object ; Use -> To access the property 'anotherObject'

//Array
echo $array["arrayElement"]["anotherElement"]->object->property["element"];
    //├───┘ ├────────────┘  ├──────────────┘   ├────┘  ├──────┘ ├───────┘
    //│     │               │                  │       │        └── array element ; 
    //│     │               │                  │       └─────────── property (array) ; Use [] To access the array element 'element'
    //│     │               │                  └─────────────────── property (object) ; Use -> To access the property 'property'
    //│     │               └────────────────────────────────────── array element (object) ; Use -> To access the property 'object'
    //│     └────────────────────────────────────────────────────── array element (array) ; Use [] To access the array element 'anotherElement'
    //└──────────────────────────────────────────────────────────── array ; Use [] To access the array element 'arrayElement'
*/