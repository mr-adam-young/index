<?php
require 'includes/main-include.php';
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Hess Ornamental Iron Daily Production Board</title>
<style type="text/css">
.orange { background-color:#F60; color:#000; }

body { background-color:#000; color:#FFF; margin:0;}
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

<div id="dynamic"></div>

<script src="https://code.jquery.com/jquery-latest.min.js"></script>
<script>

	var theJobs = new Array();
	var perPage = 4;

	var results = 0;
	var position = 0;
	var pages = 0;

	var HTMLColorArr = [0,0,0];

	function WarningColor(ratio) {
		if ((ratio > 0) && (ratio < 0.70)) {
			Red = parseInt((ratio / 0.70) * 256);
			HTMLColorArr = [Red, 256, 0];
		} else if ((ratio > 0.70) && (ratio < 1)) {
			Green = parseInt((1-((ratio - 0.70)/0.30)) * 256)
			HTMLColorArr = [256, Green, 0];
		} else if (ratio > 1 ) {
			HTMLColorArr = [138, 7, 7];
		}
	}

	function download() {
		var requestData = {
			data : "active_jobs",	
		};

		$.ajax({
			dataType: "json",
			url: "processing.php",
			data: JSON.stringify(requestData),
			success: (function (data) {
				theJobs = data;
			})
		});
	}

	function turnPage() {
		$("#dynamic").empty();
		if (position >= theJobs.length) {
			position = 0;
		}
		for ( var i = 0; i < 4; i++ ) {
			
			var val = theJobs[i+position];


			if (typeof val != 'undefined') {
			/* here comes the job block */

			/* appearance */
			if (val['Status'] > 22) {
				var Appearance = 'container';
			} else {
				var Appearance = 'container-inactive';
			}
			
			var TargetProfitMargin = <?php echo TARGET_NET_PROFIT_MARGIN; ?>;
			var BreakEvenRatio = 1 + (TargetProfitMargin/(1-TargetProfitMargin));
			var Progress = val['ActualHours'] / (val['EstimatedHours'] * BreakEvenRatio);
			
			var HoursDifference = val['EstimatedHours'] - val['ActualHours'];
			var DaysRemain = HoursDifference / 8;

			if (val['EstimatedHours'] == 0) {
				HoursDifference = `Time and Material`;
			} else {
				if (HoursDifference < 0) {
					HoursDifference = `${-HoursDifference} hr. over target`;
				} else {
					HoursDifference = `${HoursDifference} hr. remain`;
				}
			}


			WarningColor(Progress);

			var template = 
				`<div class="${Appearance}">
					<div class="job"><span class="job-id">${val['ID']}</span> ${val['Title']}
					<div class="fabhr">${HoursDifference}</div></div>
					<div>
				<div class="description"><span class="orange">${val['StatusName']} at ${val['lastUpdated']}</span>
				<br>${val['Description']}</div>
					</div>
					<div class="quotebar" style="position:relative;">
						<div class="progress" style="position: absolute; top:0; left:0; z-index:10; width:${Progress * 100}%; background-color: rgb(${HTMLColorArr[0]}, ${HTMLColorArr[1]}, ${HTMLColorArr[2]})"></div>
						<div class="target_profit" style="border-right:6px solid #000;  width:70%; position: absolute; top:0; left:0; z-index:5; height:100%; background-color:#666; "></div>
					</div>	
				</div>`;
			$("#dynamic").append(template);
			} else {
				console.log("empty");
			}
			console.log(position);
		}
		position += 4;
	}

	download();
	setInterval(download, 1000000);
	setInterval(turnPage, 12000);

	// <!---->

    var blink = function(){
		$('.blink').fadeTo(0, 1).delay(1400).fadeTo(0,0).delay(130).fadeTo(0, 1);
    };
    // setInterval(blink, 1530);
    
    var audio =  new Audio('https://isme.interversal.systems/assets/beep.wav');
    var warning =  new Audio('https://isme.interversal.systems/assets/dingding.wav');
    
    function playSound() {
      
      var date = new Date();
      
      var hours = date.getHours();
      var minutes = date.getMinutes();
      var seconds = date.getSeconds();

        // day begin bell
        if (hours == 6 && minutes == 55 && seconds == 00) { warning.play(); }
        if (hours == 7 && minutes == 00 && seconds == 00) { audio.play(); }

        // break time bell
        if (hours == 9 && minutes == 29 && seconds == 00) { warning.play(); }
        if (hours == 9 && minutes == 30 && seconds == 00) { audio.play(); }
      
        // break time end bell
        if (hours == 9 && minutes == 39 && seconds == 00) { warning.play(); }
        if (hours == 9 && minutes == 40 && seconds == 00) { audio.play(); }
        
        // lunch time begin bell
        if (hours == 11 && minutes == 55 && seconds == 00) { warning.play(); }
        if (hours == 12 && minutes == 00 && seconds == 00) { audio.play(); }
        
        // lunch time end bell
        if (hours == 12 && minutes == 28 && seconds == 00) { warning.play(); }
        if (hours == 12 && minutes == 30 && seconds == 00) { audio.play(); }
        
        // day end bell
        if (hours == 15 && minutes == 25 && seconds == 00) { warning.play(); }
        if (hours == 15 && minutes == 30 && seconds == 00) { audio.play(); }
      
    }
    
    setInterval(playSound, 10);
    $("#testbutton").click(function() {
      audio.play();
    });

</script>

</body>
</html>
