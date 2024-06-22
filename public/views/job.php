<?php

$required = array("ID", "Title", "EstMaterialCost", "EstMaterialDesc", "CustomerName", "CustomerPhone", "CustomerEmail", "Description",
			"Street", "City", "State", "ZipCode", "Length", "Material", "Color", "FinishType", "PostSize", "PicketSize", "ChannelSize", "CapSize");

foreach ($required as $attribute) {
	$job[$attribute] = '';
}

// if there is some data being sent in $_POST
if (!empty($_POST))
{

	$good = false;

	// iterate through fields in array, set if post data is there, blank if there isn't
	foreach ($required as $field) {
		$job[$field] = isset($_POST[$field]) ? htmlspecialchars($_POST[$field], ENT_QUOTES) : 0;
	}

	// analyze data
	$regex = '/[0-9]{2}-[0-9]{3}/';
	if (preg_match($regex, $job['ID'])) {
		if ($job['Title']) {
			$good = true;
		}
	} else {
		echo "Malformed purchase order number. Make sure it is in the format <i>YY-NNN</i>. You entered ".$job['ID']."<hr>";
		echo "<hr>";
	}

	if ($good){
		// good, send via sql

		$connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

		if ($_GET['action'] == 'new') {
			// adding a new job

			if (!file_exists("data/".$job['ID'])) {
				mkdir("data/".$job['ID']);
			}

			copy("data/drawing_template.dwg", "data/".$job['ID']."/[".$job['ID']."] ".$job['Title'].".dwg");

			$sql = "INSERT INTO Jobs SET ";

			$job['Status']=1;

			 foreach ($job as $key => $value) {
				 if (empty($value)) {
					$resultstr[] = "{$key} = NULL";
				 } else {
					$resultstr[] = "{$key} = '{$value}'";
				 }
			 }
			$sql .= implode(",", $resultstr);
		} else {
			$sql = "UPDATE Jobs SET ";

			foreach ($job as $key => $value) {
				if (empty($value)) {
					$resultstr[] = "{$key} = NULL";
				 } else {
					$resultstr[] = "{$key} = '{$value}'";
				 }
			 }

			 $sql .= implode(", ", $resultstr);
			 $sql .= " WHERE ID='{$job['ID']}'";
		}

		$connection->query($sql);
		$result = "<h3>SQL Query, ".date('l jS \of F Y h:i:s A')."</h3><p>".$sql."</p><p>".$connection->error."</p><hr>";
		$result .= var_export($resultstr, true);	
		ISLog($result);
		$connection->close();
   
   // completed SQL request, now notify Microsoft Flow via HTTP Post
   

   
   //API Url
        $url = 'https://prod-41.westus.logic.azure.com:443/workflows/b930cc83965842858e5d66af83e7b5fb/triggers/manual/paths/invoke?api-version=2016-06-01&sp=%2Ftriggers%2Fmanual%2Frun&sv=1.0&sig=4CqoZtIb5S8jaXK3lOjnKtIfHAr3IiCrG1jWLYhKz5Q';
         
        //Initiate cURL.
        $ch = curl_init($url);
           
       // the JSON data
       $jsonData = array(
         'job-id' => $job['ID'],
         'job-title' => $job['Title']
       );
         
        //Encode the array into JSON.
        $jsonDataEncoded = json_encode($jsonData);
         
        //Tell cURL that we want to send a POST request.
        curl_setopt($ch, CURLOPT_POST, 1);
         
        //Attach our encoded JSON string to the POST fields.
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
         
        //Set the content type to application/json
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 
         
        //Execute the request
        $result = curl_exec($ch);

	} else {
		echo "Failed.";
	}
}

// check for job ID in GET
if (!empty($_GET['job'])) {

	if ($_GET['job'] == 'new') {
		// if the PO doesn't exist, we're good. calculate a new PO number from existing jobs
		$sql = "SELECT * FROM Jobs WHERE ID LIKE '".date("y")."%' ORDER BY ID DESC LIMIT 1";
		$latest = db($sql, false);
		if (!empty($latest)) {
			$effective = preg_replace("/^([0-9]{2,4})\-([0-9]{1,})$/","$2",$latest['ID']);
			$effective = intval($effective);
			$effective++;
			$job['ID'] = date("y")."-".sprintf("%03d", $effective);
		} else {
			$job['ID'] = date("y")."-001";
		}
	
	} else {

	$THIS = $_GET['job'];

	// if editing an entry, pull values from DB and print them onto the page
	$result = db("SELECT * FROM Jobs WHERE ID='".$_GET['job']."'");

	// if the results receidved from the SQL DB aren't empty
	if (!empty($result)) {
		$result = $result[0];
		
		foreach ($required as $value) {
			$job[$value] = $result[$value];
		}
		$job["Status"] = $result["Status"];

	} else {
		die("Invalid PO#");
	}
}
}

?> 

<!-- Main content -->
<section class="content">

<section class="major">


<h1>
<?php	
if ($job['Title']=='') {
		echo "Creating New Job";
	} else {
		echo "<span style=\"color:#999;\">".$job['ID']."</span> ".$job['Title'];
	}
?>
</h1>

<?php
if ($_GET['job'] == 'new') {
	echo '<form action="'.SITE_ROOT.'/?job='.$job['ID'].'&action=new" method="post">';
} else {
	echo '<form action="'.SITE_ROOT.'/?job='.$job['ID'].'&action=edit" method="post">';
}


if ($_GET['job'] != 'new') {

// query database to get job statuses
$JobStatuses = db("SELECT * FROM StatusCodes ORDER BY Value ASC");
?>

<script>

var codeKey = {
	<?php 
		foreach ($JobStatuses as $status) {
			echo $status['Value'].' : "'.$status['StatusName'].'", ';
		}
	?>	
};

function decipherCode(number) {
	return codeKey[number];
}

$(document).ready(function(){

	$( "#status" ).text( decipherCode($( "#status" ).text()) );

	$("#status-drop").change(function() {
		var requestData = {
			data : "statusUpdate",
			code : $("#status-drop").find(":selected").val(),
			job : "<?php echo $THIS; ?>"	
		};

		$.ajax({
			dataType: "json",
			url: "processing.php",
			data: JSON.stringify(requestData),
			success: (function (data) {
				// $('#status-menu').animate({color:'red'}, 400).delay(400).animate({color:'black'}, 1000);
				$( "#status" ).text( decipherCode(data['status']) );
				console.log("sdasdaasd");
			})
		});
	});
});
</script>

<div id="status-menu" class="new-switch fancy-form">
	<label>Status 
	<select id="status-drop" style="font-size:1.5em;">
		<?php foreach ($JobStatuses as $status) {
			if ($job['Status'] == $status['Value']) {
				$selected = " selected";
			} else {
				$selected = "";
			}
			echo '<option'.$selected.' value="'.$status['Value'].'">'.$status['StatusName'].'</option>';
		} ?>
	</select>
	</label>
</div>
<?php 
}


echo <<<EOT

	<ul>
		<li><label>Job Title <input type="text" name="Title" maxlength="50" value="{$job['Title']}"/></label></li>
		<li><label>Job Number <input type="text" name="ID" maxlength="50" value="{$job['ID']}" /></label></li>
	</ul>
<h3>Customer Contact Information</h3>
	<ul>
		<li><label>Name <input type="text" name="CustomerName" maxlength="50" value="{$job['CustomerName']}" /></label></li>
		<li><label>Email <input type="text" name="CustomerEmail" maxlength="50" value="{$job['CustomerEmail']}" /></label></li>
		<li><label>Phone Number <input type="text" name="CustomerPhone" maxlength="50" value="{$job['CustomerPhone']}" /></label></li>
	</ul>
	<ul>
		<li><label>Street <input type="text" name="Street" maxlength="50" value="{$job['Street']}" /></label></li>
		<li><label>City <input type="text" name="City" maxlength="50" value="{$job['City']}" /></label></li>
		<li><label>State <input type="text" name="State" maxlength="2" value="{$job['State']}" /></label></li>
		<li><label>ZipCode <input type="text" name="ZipCode" maxlength="50" value="{$job['ZipCode']}" /></label></li>
	</ul>
	
<h3>Project Details</h3>

	<ul>
		<li><label>Total Length (ft.) <input type="number" name="Length" maxlength="5" value="{$job['Length']}" /></label></li>
		<li><label>Material <input type="text" name="Material" maxlength="20" value="{$job['Material']}" /></label></li>
		<li><label>Color <input type="text" name="Color" maxlength="20" value="{$job['Color']}" /></label></li>
		<li><label>Finish Type <input type="text" name="FinishType" maxlength="30" value="{$job['FinishType']}" /></label></li>
	</ul>

<h3>Structure</h3>

	<ul>
		<li><label>Posts (in.) <input type="number" name="PostSize" maxlength="5" value="{$job['PostSize']}" step="0.01" /></label></li>
		<li><label>Pickets (in.) <input type="number" name="PicketSize" maxlength="5" value="{$job['PicketSize']}" step="0.01" /></label></ll1>
		<li><label>Horizontals (in.) <input type="number" name="ChannelSize" maxlength="5" value="{$job['ChannelSize']}" step="0.01" /></label></li>
		<li><label>Estimated Material Cost
			<input type="text" name="EstMaterialCost">
				{$job['EstMaterialCost']}
			</input>	
		</li>
	</ul>
	<ul>
		<li><label for="Description">Project Description <textarea name="Description">{$job['Description']}</textarea>	</li>
	  	<li><label for="EstMaterialDesc">Parts List <textarea name="EstMaterialDesc">{$job['EstMaterialDesc']}</textarea></li>
	</ul>

<button type="submit">Apply</button>

</section>
EOT;

if ($_GET['job'] != 'new') {

?>
<section class="major">

<h1>Estimate</h1>

<h3>Labor Estimate</h3>
<?php
$sql = "SELECT LaborEstimateID, LaborType, Hours FROM LaborEstimates INNER JOIN LaborTypes ON LaborEstimates.LaborTypeID=LaborTypes.ID WHERE JobID='{$_GET['job']}'";

$invoices = db($sql);

echo "<table id='estimate_table' class='quicktable'>
  <tr>
  <th>Type</th>
    <th>Hours</th>
    <th></th>
  </tr>";

foreach ($invoices as $invoice) {
 echo "<tr id='{$invoice['LaborEstimateID']}'>
    <td>{$invoice['LaborType']}</td>
    <td>{$invoice['Hours']}</td>
   <td><button type=\"button\" class=\"remove_estimate\">Remove</button></td>
 </tr>";
}

$LaborTypes = db("SELECT * FROM LaborTypes");
$LaborOptions = '';
foreach ($LaborTypes as $type) { 
	$LaborOptions = $LaborOptions."<option value='{$type['ID']}'>{$type['LaborType']}</option>";
} 

echo "<tr>
	<input type='hidden' id='estimate_job_id' value='{$_GET['job']}'>
	<th><input id='estimate_hours' type='number' step='0.25' min='0'></th>
	<th>
		<select id='estimate_labor_type'>{$LaborOptions}</select>	
	</th>
	<th><button type='button' class='estimate_submit'>Post</button></th>
</tr>
</table>

<h3>Estimated Cost Sources</h3>";

$sql = "SELECT * FROM CostingEstimates WHERE JobID='{$_GET['job']}'";

$invoices = db($sql);

echo "<table id='costing_estimates_table' class='quicktable'>
  <tr>
    <th>Cost</th>
    <th>Description</th>
    <th>Vendor</th>
    <th></th>
  </tr>";

$estimated_purchases = 0;

foreach ($invoices as $invoice) {
 echo "<tr id='{$invoice['ID']}'>
    <td>{$invoice['Cost']}</td>
   <td>{$invoice['Description']}</td>
    <td>{$invoice['Vendor']}</td>
   <td><button type=\"button\" class=\"costing_estimates_remove\">Remove</button></td>
 </tr>";
 $estimated_purchases += $invoice['Cost'];
}
echo "<tr>
		<th>".money_format('$%i', $estimated_purchases)."</th>
		<th>Total</th>
		<th>All Sources</th>
		<th></th>
	</tr>
	<input type='hidden' id='costing_estimates_job_id' value='{$_GET['job']}'>
	<tr>
		<th><input id='costing_estimates_cost' type='number' step='0.25' min='0' style='width:50px;'></th>
		<th><input id='costing_estimates_description' type='text'></th>
		<th><input id='costing_estimates_vendor' type='text'></th>
		<th><button type='button' class='costing_estimates_submit'>Post</button></th>
	</tr>
</table>";
?>

</section>

<section class="major">

<h1>REPORT</h1>
<h3>Labor Summary</h3>

<?php

$LaborSummary = db("SELECT LaborType, EstimatedHours, ActualHours FROM 
(SELECT COALESCE(ELaborTypeID, ALaborTypeID) AS Coalesced, EstimatedHours, ActualHours FROM
(SELECT LaborTypeID AS ELaborTypeID, Hours AS EstimatedHours FROM LaborEstimates WHERE JobID='{$_GET['job']}') as EstimateTable
LEFT JOIN
(SELECT LaborTypeID AS ALaborTypeID, IFNULL(SUM(Hours), 0) AS ActualHours FROM LaborNew WHERE JobID='{$_GET['job']}' GROUP BY LaborTypeID) as ActualTable
ON EstimateTable.ELaborTypeID=ActualTable.ALaborTypeID
UNION
SELECT COALESCE(ELaborTypeID, ALaborTypeID) AS Coalesced, EstimatedHours, ActualHours FROM
(SELECT LaborTypeID AS ELaborTypeID, Hours AS EstimatedHours FROM LaborEstimates WHERE JobID='{$_GET['job']}') as EstimateTable 
RIGHT JOIN
(SELECT LaborTypeID AS ALaborTypeID, IFNULL(SUM(Hours), 0) AS ActualHours FROM LaborNew WHERE JobID='{$_GET['job']}' GROUP BY LaborTypeID) as ActualTable
ON EstimateTable.ELaborTypeID=ActualTable.ALaborTypeID) as Alias INNER JOIN LaborTypes ON Alias.Coalesced=LaborTypes.ID");

echo "<table class='quicktable'>
		<tr>
			<th>Type</th>
			<th>Estimated Hours</th>
			<th>Estimated Cost</th>
			<th>Actual Hours</th>
			<th>Actual Cost</th>
		</tr>";

	$TotalEstimatedHours = 0;
	$TotalActualHours = 0;

foreach ($LaborSummary as $LaborType) {

	$TotalEstimatedHours += $LaborType['EstimatedHours'];
	$TotalActualHours += $LaborType['ActualHours'];
 echo "<tr>
			<td>{$LaborType['LaborType']}</td>
			<td>{$LaborType['EstimatedHours']}</td>
			<td>".($LaborType['EstimatedHours']*COST_OF_OPERATION)."</td>
			<td>{$LaborType['ActualHours']}</td>
			<td>".($LaborType['ActualHours']*COST_OF_OPERATION)."</td>
 		</tr>";
}

echo "<tr>
		<th>Total</th>
		<th>{$TotalEstimatedHours}</th>
		<th>".money_format('$%i', ($TotalEstimatedHours * 75))."</th>
		<th>{$TotalActualHours}</th>
		<th>".money_format('$%i', ($TotalActualHours * 75))."</th>
	</tr>
</table>";

echo "<h3>Costing and Invoices</h3>";

$sql = "SELECT * FROM Costing WHERE JobID='{$_GET['job']}'";

$invoices = db($sql);

echo "<table id='invoice_table' class='quicktable'>
  <tr>
    <th>Cost</th>
    <th>Description</th>
    <th>Vendor</th>
    <th></th>
  </tr>";

$amount_spent = 0;

foreach ($invoices as $invoice) {
 echo "<tr id='{$invoice['ID']}'>
    <td>{$invoice['Cost']}</td>
   <td>{$invoice['Description']}</td>
    <td>{$invoice['Vendor']}</td>
   <td><button type=\"button\" class=\"remove_invoice\">Remove</button></td>
 </tr>";
 $amount_spent += $invoice['Cost'];
}

echo "<tr>
		<th>".money_format('$%i', $amount_spent)."</th>
		<th>Total</th>
		<th>All Sources</th>
	</tr>
	<tr>
		<input type='hidden' id='job_id' value='{$_GET['job']}'>
		<th><input id='cost' type='number' step='0.25' min='0' style='width:50px;'></th>
		<th><input id='description' type='text'></th>
		<th><input id='vendor' type='text'></th>
		<th><button type='button' class='invoice_submit'>Post</button></th>
	</tr>
</table>";
?>

</section>

<?php
/* 888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888 */

// only show insights if install completed
if ($job['Status'] >= 55) {
?>

<section class="major">

<h1>Insights</h1>
<?php

$TotalLaborCharge 	= $TotalEstimatedHours * SHOP_RATE;
$EstimatedOperationCost = (1 - TARGET_NET_PROFIT_MARGIN) * $TotalLaborCharge;
$ActualOperationCost = (1 - TARGET_NET_PROFIT_MARGIN) * ($TotalActualHours * SHOP_RATE);
$Billed 			= $TotalLaborCharge + $estimated_purchases;
$NetProfit			= $Billed - ($ActualOperationCost + $amount_spent);
$NetProfitMargin	= ($NetProfit / $Billed) * 100;

echo "<h3>Billed: ".money_format('$%i', $Billed)."</h3>";
echo "<h3>Net Profit: ".money_format('$%i', $NetProfit)."</h3>";
echo "<h3>Net Profit Margin: {$NetProfitMargin}%</h3>";
echo "<h3>Cost Per Foot: ".money_format('$%i', ($Billed/$job['Length']))."</h3>";

// commit calculations to the database

$connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$sql = "UPDATE Jobs SET ProfitMargin={$NetProfitMargin}, Billed=".$Billed." WHERE ID={$job['ID']}";
$connection->query($sql);
$result = "<h3>SQL Query, ".date('l jS \of F Y h:i:s A')."</h3><p>".$sql."</p><p>".$connection->error."</p><hr>";
ISLog($result);
$connection->close();

?>

</section>

<?php } ?>
<?php } ?>

<script language="javascript">
	$(".invoice_submit").click(function(){
     var localTarget = $(this);
		$.post("processing.php?action=invoice", 
		{
			request_type: "invoice",
			job_id: $("#job_id").val(),
			cost: $("#cost").val(),
			description: $("#description").val(),
			vendor: $("#vendor").val(),
		},
		function(data) { 
      $("#invoice_table").append("<tr id=\"" + data[0]["ID"] + "\"><td>" + $("#cost").val() + "</td><td>" + $("#description").val() + "</td><td>" + $("#vendor").val() + "</td><td><button type=\"button\" class=\"remove_invoice\">Remove</button></td></tr>");
      $("#cost").val("");
      $("#job_id").val("");
      $("#description").val("");
      $("#vendor").val("");
		}); 
	});

	$("body").on("click", ".remove_invoice", function(){
     var localTarget = $(this);
		$.ajax({
		url: 'processing.php?invoice=' + $(this).parent().parent().attr('id'), 
		type: 'DELETE',
		success: function(result) {
       localTarget.parent().parent().remove();
		}
		});
	});

	$(".estimate_submit").click(function(){
     var localTarget = $(this);
		$.post("processing.php?action=estimate", 
		{
			request_type: "estimate",
			job_id: $("#estimate_job_id").val(),
			estimate_hours: $("#estimate_hours").val(),
			estimate_labor_type: $("#estimate_labor_type").val()
		},
		function(data) { 
      $("#estimate_table").append("<tr id=\"" + data[0]["LaborEstimateID"] + "\"><td>" + data[0]["LaborType"] + "</td><td>" + data[0]["Hours"] + "</td><td><button type=\"button\" class=\"remove_estimate\">Remove</button></td></tr>");
      $("#estimate_hours").val("");
		}); 
	});

	$("body").on("click", ".remove_estimate", function(){
     var localTarget = $(this);
		$.ajax({
		url: 'processing.php?estimate=' + $(this).parent().parent().attr('id'), 
		type: 'DELETE',
		success: function(result) {
       localTarget.parent().parent().remove();
		}
		});
	});

	/* Costing Estimates View Functions */

	$(".costing_estimates_submit").click(function(){
     var localTarget = $(this);
		$.post("processing.php", 
		{
			request_type: "CostingEstimate",
			costing_estimates_job_id: $("#costing_estimates_job_id").val(),
			costing_estimates_cost: $("#costing_estimates_cost").val(),
			costing_estimates_description: $("#costing_estimates_description").val(),
			costing_estimates_vendor: $("#costing_estimates_vendor").val(),
		},
		function(data) { 
      $("#costing_estimates_table").append("<tr id=\"" + data[0]["ID"] + "\"><td>" + $("#costing_estimates_cost").val() + "</td><td>" + $("#costing_estimates_description").val() + "</td><td>" + $("#costing_estimates_vendor").val() + "</td><td><button type=\"button\" class=\"remove_invoice\">Remove</button></td></tr>");
      $("#costing_estimates_cost").val("");
      $("#costing_estimates_description").val("");
      $("#costing_estimates_vendor").val("");
		}); 
	});

	$("body").on("click", ".costing_estimates_remove", function(){
     var localTarget = $(this);
		$.ajax({
		url: 'processing.php?costing_estimate=' + $(this).parent().parent().attr('id'), 
		type: 'DELETE',
		success: function(result) {
       localTarget.parent().parent().remove();
		}
		});
	});
	</script>

</form>
</section>
