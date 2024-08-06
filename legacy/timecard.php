<?php
    $LaborTypes = db("SELECT * FROM LaborTypes");
    $ActiveJobs = db("SELECT * FROM Jobs WHERE Status > 0 AND Status < 100");

    $LaborTypeOptions = '';
    $ActiveJobsOptions = '';

    foreach ($LaborTypes as $Type) {
        $LaborTypeOptions = $LaborTypeOptions."<option value='{$Type['ID']}'>{$Type['LaborType']}</option>";
    }

    foreach ($ActiveJobs as $Job) {
        $ActiveJobsOptions = $ActiveJobsOptions."<option value='{$Job['ID']}'>{$Job['ID']}: {$Job['Title']}</option>";
    }

// evaluate the current status of the employee based on if they have an open entry or not

echo <<<EOT

<div id='console'></div>

<section class="mobile-ui">
    <h1>Adam Young's Timecard</h1>
    <input id="EmployeeID" type="hidden" value="4" />
    <div id="current-status"></div>
    <div id="change-prompt"></div>
    <div>
        <select id="JobID">
           {$ActiveJobsOptions}
        </select>
        <select id="labor-type" style="display:none;">
            {$LaborTypeOptions}
        </select>
        <select id="labor-type-current" >
            {$LaborTypeOptions}
        </select>
    </div>
    <button id="clock-in">Punch In</button>
    <button id="clock-out">Punch Out</button>
</section>

EOT;
?>

<script>

function resetView() {
    console.log("Reset the view.");
    $("#labor-type").hide();
    $("#labor-type-current").show();
    $("#job-id").show();
}

$("#labor-type-current").change(function() {

    $.post("api.php", 
		{
			request_type: "change",
            JobID:          $("#JobID").val(),
            EmployeeID: $("#EmployeeID").val(),
			LaborTypeID: $("#labor-type-current").val()
		},
		function(data) { 
            $("#console").append("Success" + data[0]["ID"]);
		}); 

    $("#console").append("<p>LaborType change for current job</p>");
    resetView();
});

$("#job-id").change(function() {
    // show the picker for the new 
    $("#console").append("<p>Job change. Now pick the labortype.</p>");
    $("#labor-type").show();
    $("#labor-type-current").hide();
    $("#job-id").hide();
    $("#labor-type").change(function() {

        $.post("api.php", 
		{
			request_type: "change",
            JobID:          $("#JobID").val(),
            EmployeeID: $("#EmployeeID").val(),
			LaborTypeID: $("#labor-type-current").val()
		},
		function(data) { 
            $("#console").append("<p>Successful job and labortype change.</p>");
		}); 
        resetView();
    });
    
});

$("#clock-out").click(function() {
    // show the picker for the new 
    $.post("api.php", 
    {
        request_type: "close",
        EmployeeID: $("#EmployeeID").val(),
    },
    function(data) { 
        $("#console").append("<p>Closed out last labor entry.</p>");
    }); 
    resetView();
});

</script>