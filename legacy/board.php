<?php require 'legacy_include.php'; ?>
<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Production Board</title>
    <link rel="stylesheet" href="css/board.css">
    <script src="https://code.jquery.com/jquery-latest.min.js"></script>

    <style>
        .orange { background-color:#F60; color:#000; }

h1 { margin:0; font-size:50px; }
.job { font-size: 50px; font-weight:bold; }
.labor { height:40px; float:left; }
.install { height:10px; }

.container, .container-inactive { border: #CCC 8px solid; margin-bottom:26px; box-shadow: 0 10px 5px #333; }
.container-inactive { border: #666 8px solid; color:#666; }

.quotebar { height:40px; background-color:#444; position:relative; }
.progress {
	color:#000;
	font-size:20px;
	height: 100%;
	position: absolute;
	left: 0;
	z-index: 10;
	background: rgba(255, 255, 255, 1);
}

.job-id { color:#999;}

/* .blink { animation: doubleflash 4s linear infinite; } */

.fabhr { float: right; margin-right:10px; }

.description {
  font-size:20px; padding:0 10px 10px 10px; font-family:"Arial";
}

@keyframes doubleflash {
    0%   { opacity: 1; }
    5%   { opacity: 0; }
	6%   { opacity: 1; }
	10%   { opacity: 0; }
	11%   { opacity: 1; }
    100% { opacity: 1; }
}
table { margin-left:50px; font-size:27px; }
td { text-align:center; width:300px; padding:10px; }
.tag { color:#000; background-color:#FFF; padding:5px; font-size:18px; vertical-align:middle;}
.currentstatus { border: #FFF 3px solid; }

td div {border:#000 1px solid;}

.mono { font-family:"Courier";}
.timeandmaterial .quotebar { background-color: #000;}
</style>

</head>
<body>

<div id="dynamic">
    <!-- drawn by javascript -->
</div>

<script type="text/javascript">
let data;
let cache;
var perPage = 4;
var position = 0;
var HTMLColorArr = [0, 0, 0];
var i = 0;

function WarningColor(ratio) {
    if (ratio > 0 && ratio < 0.70) {
        var Red = parseInt((ratio / 0.70) * 256);
        HTMLColorArr = [Red, 256, 0];
    } else if (ratio > 0.70 && ratio < 1) {
        var Green = parseInt((1 - ((ratio - 0.70) / 0.30)) * 256);
        HTMLColorArr = [256, Green, 0];
    } else if (ratio > 1) {
        HTMLColorArr = [138, 7, 7];
    }
}

// new function to fetch active jobs
async function fetchData() {
    try {
        const response = await fetch('processing.php?data=active_jobs');
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        data = await response.json();
    } catch (error) {
        console.error('Error fetching data:', error);
    }
}

// advance the page
async function turnPage() {
    await fetchData();
    const $dynamic = $("#dynamic");
    $dynamic.empty();

    // start over if we reach the end
    if (position >= data.length) {
        position = 0;
    }

    const TargetProfitMargin = <?php echo TARGET_NET_PROFIT_MARGIN; ?>;
    const BreakEvenRatio = 1 + (TargetProfitMargin / (1 - TargetProfitMargin));

    for (i = 0; i < perPage; i++) {
        console.log(data[i + position]);
        cursor = i + position;

        val = data[cursor];
        const Appearance = val['Status'] > 22 ? 'container' : 'container-inactive';
        const Progress = val['ActualHours'] / (val['EstimatedHours'] * BreakEvenRatio);
        let HoursDifference = val['EstimatedHours'] - val['ActualHours'];
        let HoursDifferenceText = '';

        if (val['EstimatedHours'] === 0) {
            HoursDifferenceText = `Time and Material`;
        } else {
            HoursDifferenceText = HoursDifference < 0 ? 
                `${-HoursDifference} hr. over target` : 
                `${HoursDifference} hr. remain`;
        }

        WarningColor(Progress);

        const template = `
            <div class="${Appearance}">
                <div class="job">
                    <span class="job-id">${val['ID']}</span> ${val['Title']}
                    <div class="fabhr">${HoursDifferenceText}</div>
                </div>
                <div>
                    <div class="description">
                        <span class="orange">${val['StatusName']} at ${val['lastUpdated']}</span>
                        <br>${val['Description']}
                    </div>
                </div>
                <div class="quotebar" style="position:relative;">
                    <div class="progress" style="position: absolute; top:0; left:0; z-index:10; width:${Progress * 100}%; background-color: rgb(${HTMLColorArr[0]}, ${HTMLColorArr[1]}, ${HTMLColorArr[2]})"></div>
                    <div class="target_profit" style="border-right:6px solid #000; width:70%; position: absolute; top:0; left:0; z-index:5; height:100%; background-color:#666;"></div>
                </div>
            </div>`;
            
        $dynamic.append(template);
        console.log("appended");
    }

    position += perPage;
    console.log("Page turned.");
}

$(document).ready(function() {
    turnPage();
    setInterval(turnPage, 12000);

    var blink = function(){
        $('.blink').fadeTo(0, 1).delay(1400).fadeTo(0, 0).delay(130).fadeTo(0, 1);
    };
    // setInterval(blink, 1530);

    var audio = new Audio('assets/beep.wav');
    var warning = new Audio('assets/dingding.wav');

    function playSound() {
        var date = new Date();
        var hours = date.getHours();
        var minutes = date.getMinutes();
        var seconds = date.getSeconds();

        // day begin bell
        if (hours == 6 && minutes == 55 && seconds == 0) { warning.play(); }
        if (hours == 7 && minutes == 0 && seconds == 0) { audio.play(); }

        // break time bell
        if (hours == 9 && minutes == 29 && seconds == 0) { warning.play(); }
        if (hours == 9 && minutes == 30 && seconds == 0) { audio.play(); }

        // break time end bell
        if (hours == 9 && minutes == 39 && seconds == 0) { warning.play(); }
        if (hours == 9 && minutes == 40 && seconds == 0) { audio.play(); }

        // lunch time begin bell
        if (hours == 11 && minutes == 55 && seconds == 0) { warning.play(); }
        if (hours == 12 && minutes == 0 && seconds == 0) { audio.play(); }

        // lunch time end bell
        if (hours == 12 && minutes == 28 && seconds == 0) { warning.play(); }
        if (hours == 12 && minutes == 30 && seconds == 0) { audio.play(); }

        // day end bell
        if (hours == 15 && minutes == 25 && seconds == 0) { warning.play(); }
        if (hours == 15 && minutes == 30 && seconds == 0) { audio.play(); }
    }
    // setInterval(playSound, 1000);
    console.log("Finished loading");
});
</script>

</body>
</html>