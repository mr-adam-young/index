

<?php

// Set the time for the labor resultsFF
if (isset($_GET['date'])) {
	$seed = $_GET['date'];
} else {
	$seed = strtotime('now');
}

$thisWeekBegin = strtotime('last sunday', strtotime('tomorrow', $seed));
$nextWeekBegin = strtotime('this sunday', strtotime('tomorrow', $seed));

	
$sql = "SELECT * FROM Personnel WHERE Active";
$roster = db($sql);

echo "<ul class='buttons'>";	
foreach ($roster as $man) {
	echo "<li><a href=\"employee.php?id=".$man['ID']."\">".$man['FullName']."</a></li>";
}
echo "</ul>";

if (isset($_GET['id'])) {
	
$sql = "SELECT * FROM Personnel WHERE ID=".$_GET['id'];
$thisguy = db($sql);	

$sql = "SELECT * FROM LaborTypes";
$laborTypes = db($sql);
?>

<script src="https://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>

<h1><?php echo $thisguy[0]['FullName'] ?></h1>


<style type="text/css">
h4 { margin:0; }

.timesheet>tbody>tr>td { border-bottom:3px #000 solid; padding:3px; }
.entries>tbody>tr>td { border-bottom: 1px #999 solid; padding:3px; white-space:nowrap;}

.button { background-color:#309208; }

.input input, .input select { display:inline-block; }
</style>

<?php
echo "<h2>Timesheet: ".date("F jS, Y", $thisWeekBegin)."</h2>";

/*********************************************** */
// CACHE DB INFO HERE

$sql = 'SELECT * FROM LaborTypes';
$LaborTypes = db($sql);

$sql = 'SELECT * FROM Jobs WHERE Status > 0 AND Status < 100';
$currentjobs = db($sql);

/********************************************** */
?> 
<div class="input">
<select id="work_date">
<?php
		for($iDay = $thisWeekBegin; $iDay < $nextWeekBegin; $iDay = strtotime('+1 day', $iDay)) {
			echo "<option value=\"".$iDay."\">".date('D', $iDay)."</option>";
		}
	?>
</select>
<input type="hidden" id="employee_id" value="<?=$_GET['id']?>">
<input id="job" type="text" list="jobs">
<datalist id="jobs">
	<?php foreach ($currentjobs as $job) {
		echo '<option value="' . $job['ID'] . '">'.substr($job['Title'],0,20).'</option>';
	} ?>
</datalist>
<input id="work_hours" type="number" step="0.25" min="0" style="width:50px;">

<select id="work_type">
	<?php
		foreach ($LaborTypes as $type) {
			echo "<option value=\"".$type['ID']."\">".$type['LaborType']."</option>";
		}
	?>
</select>
<button class="work_submit">Post</button>
</div>
<?php

echo "<table class=\"timesheet\">";

$totalhrs = 0;

for($iDay = $thisWeekBegin; $iDay < $nextWeekBegin; $iDay = strtotime('+1 day', $iDay)) {
	
	$weekdayhrs = 0;
	$weekdayCode = date('w', $iDay);
	
	if ( $weekdayCode == 0 || $weekdayCode == 6 ){
		$weekendRow = ' class="weekend"';
		$isWeekend = true;
	} else {
		$weekendRow = '';
		$isWeekend = false;
	}
	
	// added -1 to next weekday because most entries are logged at 00:00:00 of the day in question automatically
	$nextWeekday = strtotime('+1 day', $iDay) - 1;

	
	$sql = 'SELECT L.LaborID as LaborID, L.JobID AS JobID, J.Title, L.Hours, LT.LaborType, P.FullName FROM LaborNew AS L 
	INNER JOIN Personnel AS P ON P.ID = L.EmployeeID
	LEFT JOIN Jobs AS J ON J.ID = L.JobID 
	INNER JOIN LaborTypes AS LT ON LT.ID = L.LaborTypeID
	WHERE P.ID='.$_GET['id'].' AND L.Date BETWEEN \''.date('Y-m-d H:i:s', $iDay).'\' AND \''.date('Y-m-d H:i:s',$nextWeekday).'\'';
	$result = db($sql);
	
	echo "<tr id='".$iDay."' ".$weekendRow."><td><h1>".date('D', $iDay)."</h1>".date('n/j', $iDay)."</td><td>";
	
	echo "<table class=\"entries\">";
	foreach($result as $entry) {
		echo "<tr id=\"".$entry['LaborID']."\">";
		// substr($entry['Title'],0,15)
		echo "<td style=\"text-align:left;\"><span style=\"color:#666;\">".$entry['JobID']."</span> ".$entry['Title']."</td><td>".$entry['Hours']."</td><td>".$entry['LaborType']."</td><td><button class=\"remove_labor\">Remove</button></td>";
		echo "</tr>";
		$weekdayhrs += $entry['Hours'];
		$totalhrs +=$entry['Hours'];
		/* count up the hours for the day, if a weekend, if over 8, it's not that day, hide the form.
		show the form if it's the current day
		
		provide a button to show specific forms
		provide a function to show all forms
		$totalhrs = $entry
		style="display:none;"
		
		$mysql_date_now = date("Y-m-d H:i:s");
		
		id="wd_<?=date('w', $iDay)?>"
		*/
	}
	?>
	<tr>
		<td colspan="4">
			Total: <?=$weekdayhrs?>
		</td>
	</tr>
	
	<?php
	
	echo "</table>";
	
	echo "</td></tr>\n";
}
echo "<tr><td>TOTAL</td><td>".$totalhrs."</td></tr></table>";
	
	$i = new DateTime();
	$i->setTimestamp(strtotime('last Sunday')); 
	$limit = new DateTime();
	$limit->setTimestamp(strtotime($epoch));
	$currentURL = $_SERVER['REQUEST_URI'];
	$uri_parts = explode('?', $currentURL, 2);
	while ($i > $limit) {
		$newURL = 'http://' . $_SERVER['HTTP_HOST'] . $uri_parts[0] . "?id=" . $_GET['id'] . "&date=" . $i->getTimestamp();
		echo "<a href=\"".$newURL."\">".date('F jS, Y', $i->getTimestamp())."</a><br>";
		date_modify($i, "-7 days");
	}
	?>
	
	<script language="javascript">
	$(".work_submit").click(function(){
     var localTarget = $(this);
		$.post("processing.php?action=labor", 
		{
			request_type: "labor",
			work_type: $(this).siblings("#work_type").val(),
			work_hours: $(this).siblings("#work_hours").val(),
			employee_id: $(this).siblings("#employee_id").val(),
			work_date: $(this).siblings("#work_date").val(),
			job_id: $(this).siblings("#job").val()
		},
		function(data, status) {
       console.log(data);
      $("#" + localTarget.siblings("#work_date").val()).find(".entries").prepend("<tr id=\"" + data[0]["LaborID"] + "\"><td style=\"text-align:left;\"><span style=\"color:#666;\">" + localTarget.siblings("#job").val() + "</span> " + data[0]["Title"] + "</td><td>" + localTarget.siblings("#work_hours").val() + "</td><td>" + localTarget.siblings("#work_type option:selected").text() + "</td><td><button class=\"remove_labor\">Remove</button></td></tr></tr>");
      localTarget.siblings("#job").val("");
      localTarget.siblings("#work_hours").val("");
      ;
		}); 
	});

	$("body").on("click", ".remove_labor", function(){
     var localTarget = $(this);
		$.ajax({
		url: 'processing.php?entry=' + $(this).parent().parent().attr('id'), 
		type: 'DELETE',
		success: function(result) {
       localTarget.parent().parent().remove();
		}
		});
	});
	</script>
	<?php
}	
?>
