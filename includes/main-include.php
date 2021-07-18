<?php
# main-include.php
require_once '/srv/isme/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable("/srv/isme/");
$dotenv->load();

// hardcoded math constants
define("TARGET_NET_PROFIT_MARGIN", 0.3);
define("SHOP_RATE", 75);
define("COST_OF_OPERATION", (SHOP_RATE*(1-TARGET_NET_PROFIT_MARGIN)));

// brand new MySQLi function
function db($sql, $multipleRows = true, $fetch = true ) {
	$connection = new mysqli($_ENV['MYSQL_HOST'], $_ENV['MYSQL_USER'], $_ENV['MYSQL_PASS'], $_ENV['MYSQL_SCHEMA']);
		if ($connection->connect_errno) {
			ISLog("<div class=\"warning\">Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error . "<p>" . $mysqli->host_info . "</p></div>");
		}
	$result = $connection->query($sql);

	// log to file
	$log = "<b>db():</b> ".$sql."<div style=\"color:#F00;\">".$connection->error."</div>";
	ISLog($log);

	$connection->close();
	if ($fetch == true) {
		
		if ($multipleRows == true) {
			$rows = array();
			while ($row = $result->fetch_assoc()) {
				$rows[] = $row;
			}
		} elseif ($multipleRows == false) {
			$rows = $result->fetch_assoc();
		}
		return($rows);
	} else {
		return true;
	}
}

# interverse function that queries Neo4j server using Cypher (CQL)
function interverse_neo4j($cypher, $dry_run = true) {
    # log the query to file
    $cypher_log = "log/cypher@isme_".date("Y-m-d").".log";
    interverse_log($cypher, $cypher_log);

    # execute the query if it's not a dry run, which it defaults to
    if ($dry_run == false) {
        # Using https://github.com/neo4j-php/Bolt
	$conn = new \Bolt\connection\Socket('isdtdb0.interversal.systems', 7687, 3);
	$bolt = new \Bolt\Bolt($conn);
        $bolt->init('MyClient/1.0', $_ENV['NEO4J_USER'], $_ENV['NEO4J_PASS'], []);

        # Execute query
        $res = $bolt->run($cypher);

        # Pull records from last query
        $rows = $bolt->pull();

        # the Bolt driver gives us a nasty array full of garbage so we have to sift through it.
        # if it returns an array with one result, it's nothing.
        if (count($rows) > 1) {
            return $rows;
        } else {
            return 0;
        }
    }
}

function quickTable($array, $passedColumns = false) {
	echo "<table class=\"quicktable\">";
	echo "<tr>";
	if ($passedColumns) {
		foreach ($passedColumns as $name) {
			echo "<th>".$name."</th>";
		}
	}
	echo "</tr>";
	foreach ($array as $rows) {
		echo "<tr>";
		if (is_array($passedColumns)) {
			foreach ($passedColumns as $column) {
				echo "<td>".$rows[$column]."</td>";
			}
		} else {
			foreach ($rows as $column) {
				echo "<td>".$column."</td>";
			}
		}

		echo "</tr>";
	}
	echo "</table>";
}

function ISLog($writeto, $target = "log/isme_log.html" ) {
	$writeto = "<p style=\"font-size:1em; border-bottom:1px #CCC solid; margin:0;\">".date('l F j Y h:i:s A')." ".$writeto."</p>";
	$writeto .= file_get_contents($target);
	file_put_contents($target, $writeto);
}

function interverse_log($writeto, $target = "log/main.log") {
	$writeto = date('H:i:s')." ___ ".$writeto;
	$writeto = file_get_contents($target)."\n".$writeto;
	file_put_contents($target, $writeto);
}

function interverse_csv_to_array($file) {
	interverse_log("Processing \"".$file."\" ...");
  if (($handle = fopen($file, 'r')) !== FALSE) { // Check the resource is valid
    $headers = fgetcsv($handle, 1000, ",");
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) { // Check opening the file is OK!
      $i = 0;
      foreach ($headers as $column) {
        $new_row[$column] = $data[$i];
        $i++;
      }
      $rows[] = $new_row;
    }
    fclose($handle);
  }
  return $rows;
}
