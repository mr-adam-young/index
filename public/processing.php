<?php
header('Content-type: application/json');
include '/srv/www/isme.interversal.systems/includes/main-include.php';

ob_start();

$dbResult = "";

// echo "<hr><p>".date('l jS \of F Y h:i:s A')."</p>";

$fromClient = json_decode(urldecode($_SERVER['QUERY_STRING']), true);

if ($fromClient['data'] == "accounts") {
	$dbResult = json_encode(hessdbq("SELECT ID, Title FROM Jobs"));
}

if ($fromClient['data'] == "job") {
	$dbResult = json_encode(db("SELECT * FROM Jobs WHERE ID='".$fromClient['query']."'"));
}

if($fromClient['data'] == "active_jobs") {
	// recalculate labor data
	$connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	$sql = "CALL ProjectSummary();";
	ISLog($sql);
	$connection->query($sql);
	$connection->close();
	
	$dbResult = json_encode(db("SELECT * FROM Jobs INNER JOIN StatusCodes ON Jobs.Status=StatusCodes.Value WHERE Status<100 AND Status>0"));
}

// Delete a job from the main page
if ($fromClient['data'] == "delete") {
	$sql = "DELETE FROM Jobs WHERE ID='".$fromClient['query']."'";

	$connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	$result = $connection->query($sql);
	$connection->close();
	$arr = array(
		'status' => 'success'
	);

	$dbResult = json_encode($arr);
}


if ($fromClient['data'] == "picketSpacing") {

	// Derived
	$openings = ceil(($gap + $picket)/4);
	$picketsPerSection = $openings - 1;
	$picketGap = ($gap - ($picketsPerSection * $picket))/$openings;
	if ($picketGap > 4 && $commercial == true) {
		die ("picket spacing violates code!!");
	} elseif ($picketGap > 5) {
	}
	$rise; $rise2; $run; $nose;
	$calcNose = sqrt( ( $rise ** 2 ) + ( $run ** 2 ) );

	$dbResult = json_encode(hessdbq("SELECT * FROM Jobs WHERE ID='".$fromClient['query']."'"));
} 

if ($fromClient['data'] == "statusUpdate") {

	ISLog("<p>RECEIVED AJAX REQUEST</p>");

	// add an entry to the status updates table
	$sql = "INSERT INTO JobStatus (StatusJobID, StatusCode, StatusDate) VALUES ('".$fromClient['job']."', ".$fromClient['code'].", NOW() )";
	ISLog($sql);
	// update the actual job
	

	$sql2 = "UPDATE Jobs SET Status=".$fromClient['code'].", lastUpdated=NOW() WHERE ID='".$fromClient['job']."'";
	ISLog($sql2);

	$connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	$result = $connection->query($sql);
	$result = $connection->query($sql2);
	$connection->close();

	$response = array (
		'status' => $fromClient['code']
	);

	$dbResult = json_encode($response);
}

if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
	ISLog("detected a DELETE method");
	if (isset($_GET['entry'])) {
		$connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		$sql = "DELETE FROM LaborNew WHERE LaborID=".$_GET['entry'];
		ISLog($sql);
		$connection->query($sql);
    $dbResult = json_encode(array("code => 200"));
	} elseif (isset($_GET['invoice'])) {
   		$connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		$sql = "DELETE FROM Costing WHERE ID=".$_GET['invoice'];
		ISLog($sql);
		$connection->query($sql);
    $dbResult = json_encode(array("code => 200"));
   } elseif (isset($_GET['estimate'])) {
		$connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		$sql = "DELETE FROM LaborEstimates WHERE LaborEstimateID=".$_GET['estimate'];
		ISLog($sql);
		$connection->query($sql);
		$dbResult = json_encode(array("code => 200"));
	} elseif (isset($_GET['costing_estimate'])) {
			$connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
			$sql = "DELETE FROM CostingEstimates WHERE ID=".$_GET['costing_estimate'];
			ISLog($sql);
			$connection->query($sql);
			$dbResult = json_encode(array("code => 200"));
	}
}

if (!empty($_POST)) {
	switch ($_POST['request_type']) {
		case 'labor':
			// mysqli->prepare
			$connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
			$statement = $connection->prepare("INSERT INTO LaborNew (EmployeeID, LaborTypeID, JobID, Hours, Date) VALUES (?,?,?,?,FROM_UNIXTIME(?))");
			$statement->bind_param("iisdi", $_POST['employee_id'], $_POST['work_type'], $_POST['job_id'], $_POST['work_hours'], $_POST['work_date']);

			$statement->execute();
			ISLog("posted data via mysql".$_POST['employee_id']." - ".$_POST['work_type']." - ".$_POST['job_id']." - ".$_POST['work_hours']." - ".$_POST['work_date']);
      
      // get what was just inserted
      $inserted = db("SELECT * FROM LaborNew LEFT JOIN (SELECT Title, ID FROM Jobs) AS JobTitle ON LaborNew.JobID=JobTitle.ID WHERE JobID='".$_POST['job_id']."' ORDER BY LaborID DESC LIMIT 1");
      
      $dbResult = json_encode($inserted);
      break;
 		case 'invoice':
			// mysqli->prepare
			$connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
			$statement = $connection->prepare("INSERT INTO Costing (JobID, Cost, Description, Vendor) VALUES (?,?,?,?)");
			$statement->bind_param("sdss", $_POST['job_id'], $_POST['cost'], $_POST['description'], $_POST['vendor']);

			$statement->execute();
			ISLog("posted invoice via mysql".$_POST['job_id']." - ".$_POST['cost']." - ".$_POST['description']." - ".$_POST['vendor']);
      
      // get what was just inserted
      $inserted = db("SELECT * FROM Costing WHERE JobID='".$_POST['job_id']."' ORDER BY ID DESC LIMIT 1");
      
      $dbResult = json_encode($inserted);
			break;
		case 'estimate':
			// mysqli->prepare
			$connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
			$statement = $connection->prepare("INSERT INTO LaborEstimates (JobID, LaborTypeID, Hours) VALUES (?,?,?)");
			$statement->bind_param("sid", $_POST['job_id'], $_POST['estimate_labor_type'], $_POST['estimate_hours']);

			$statement->execute();
			ISLog("posted estimate via mysql: ".$_POST['job_id']." - ".$_POST['estimate_labor_type']." - ".$_POST['estimate_hours']."");
      
      // get what was just inserted
      $inserted = db("SELECT * FROM LaborEstimates INNER JOIN LaborTypes ON LaborEstimates.LaborTypeID=LaborTypes.ID WHERE LaborEstimates.JobID='".$_POST['job_id']."' ORDER BY LaborEstimateID DESC LIMIT 1");
      
      $dbResult = json_encode($inserted);
			break;
 		case 'CostingEstimate':
			// mysqli->prepare
			$connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
			$statement = $connection->prepare("INSERT INTO CostingEstimates (JobID, Cost, Description, Vendor) VALUES (?,?,?,?)");
			$statement->bind_param("sdss", $_POST['costing_estimates_job_id'], $_POST['costing_estimates_cost'], $_POST['costing_estimates_description'], $_POST['costing_estimates_vendor']);

			$statement->execute();
			ISLog("posted estimated cost item via mysql".$_POST['costing_estimates_job_id']." - ".$_POST['costing_estimates_cost']." - ".$_POST['costing_estimates_description']." - ".$_POST['costing_estimates_vendor']);
      
      // get what was just inserted
      $inserted = db("SELECT * FROM CostingEstimates WHERE JobID='".$_POST['costing_estimates_job_id']."' ORDER BY ID DESC LIMIT 1");
      
      $dbResult = json_encode($inserted);
			break;
		default:
			echo "malformed POST data";
	}
}

// ISLog(ob_get_clean());

echo $dbResult;
?>
