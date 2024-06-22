<!-- Main content -->
<section class="content">
<h1><?=$title?></h1>

<?php

foreach ($list as $job) {
	$warnings = '';
	$material = '';
	$length = '';
	
	if (!empty($job['Material'])) {
		$material = "<span class='".strtolower($job['Material'])."'>{$job['Material']}</span>";
	} else {
		$warnings = $warnings."<span class='tag'>Unknown material</span>";
	}

	if (!empty($job['Length'])) {
		$length = "<span>{$job['Length']} feet.</span>";
	} else {
		// $warnings = $warnings."<span class='warning'>Unknown length</span>";
	}

	if ($job['EstimatedHours'] == 0) {
		$time_remaining = "<span class='tag'>Time and Material</span>";
	} else {
		$time_remaining = "<span>{$job['ActualHours']} / {$job['EstimatedHours']} hours (".round(($job['ActualHours'] / $job['EstimatedHours']) * 100, 1)."%)</span>";
	}

	echo "<a class='job_block' id='{$job['ID']}' href='?job={$job['ID']}'>
		<div class='nameplate'>	
			<span>
				<span class='job-id'>{$job['ID']}</span>
				<span>{$job['Title']}</span>
				<span>{$material}</span>
			</span>
			<span>
				<span>{$time_remaining}</span>
			</span>
		</div>
		<div class='job_description' style='clear:both;'>
			<span class='tag-dark'>{$job['StatusName']}</span>
			{$length} 
			<span style=''>{$warnings}</span>
		</div>
	</a>";
}

?> 
</section>