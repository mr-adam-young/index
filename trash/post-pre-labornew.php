<?php

function CloseEntries($EmployeeID) {
    $connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $open = db("SELECT * FROM TimePunch WHERE (EmployeeID={$EmployeeID}) AND (Close IS NULL) LIMIT 1");
    if (!empty($open)) {
        // close the existing punch by inserting the current time in the Close column, and determining the total number of hours
        $statement = $connection->prepare("UPDATE TimePunch SET Close=CURRENT_TIMESTAMP WHERE (EmployeeID=?) AND (CLOSE IS NULL)");
        $statement->bind_param("i", $EmployeeID);
        $statement->execute();
        return true;
    } else {
        return false;
    }
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	ISLog("REST: detected POST method");
	switch ($_POST['request_type']) {
        case "change":

            $DefaultJob = '18-001';

            // close any open entries
            if (CloseEntries($_POST['EmployeeID'])) {
                ISLog("Open labor entries were found and closed.");
            }

            $connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            // create a new labor entry
            $statement = $connection->prepare("INSERT INTO TimePunch (EmployeeID, JobID, LaborTypeID, Open) VALUES (?,?,?,CURRENT_TIMESTAMP)");
            $statement->bind_param("isi", $_POST['EmployeeID'], $DefaultJob, $_POST['LaborTypeID']);
            $statement->execute();

            ISLog("Error: ".mysqli_error($connection));
    
            // get what was just inserted
            // $inserted = db("SELECT * FROM CostingEstimates WHERE JobID='".$_POST['costing_estimates_job_id']."' ORDER BY ID DESC LIMIT 1");
            
            // $dbResult = json_encode($inserted);
        break;
        case "close":
            if (CloseEntries($_POST['EmployeeID'])) {
                ISLog("Open labor entries were found and closed.");
            }
        break;
		default:
			echo "malformed POST data";
    }
}