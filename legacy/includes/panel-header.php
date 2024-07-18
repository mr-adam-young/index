<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" >
    <title><?=$title?></title>
    <link rel="stylesheet" href="css/system.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
</head>
<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
<body>
<div class="container">
    <div class="row">
        <div class="col-sm">
        <header id="main-header">
            <nav>
                <ul>
                    <li><a href="index.php">Active Projects</a></li>
                    <li><a href="index.php?all=true">All Projects</a></li>
                    <li><a href="index.php?job=new">Add New Job</a></li>
                    <li><a href="board.php">Production Board</a></li>
                    <li><a href="employee.php">Employees</a></li>
                    <li><a href="misc.php">Miscellaneous</a></li>
                    <li><a href="timecard.php">Timecard Test</a></li>
                </ul>
            </nav>
        </header>
        </div>
    </div>