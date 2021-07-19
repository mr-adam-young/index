<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>ISME <?=$_ENV['SITE_VERSION']?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<link rel="stylesheet" href="css/interversal.css">

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>

</head>
<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
<body>

<div class="container">
<div class="row">
	<div class="col-sm"
	<header id="main-header">
		<nav>
			<ul>
				<li><a href="index.php">Active Projects</a></li>
				<li><a href="index.php?all=true">All Projects</a></li>
				<li><a href="index.php?job=new">Add New Job</a></li>
				<li><a href="employee.php">Employees</a></li>
			</ul>
		</nav>
		<div id="nav_misc">
			<b>Graph: </b>
			<a href="index_all.php" target="_blank">All Nodes</a>
			<br>

			<b>Logs: </b>
			<a href="log/main.log" target="_blank">Main Log</a>
			<a href="log/isme_log.html" target="_blank">Legacy Log</a>
			<br>

			<b>Prototypes: </b>
			<a href="timecard.php">Timecard</a>
			<br>
		</div>
	</header>
	</div class="col-sm">
</div>

