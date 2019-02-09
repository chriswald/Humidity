<!DOCTYPE HTML>

<html>
<head>

<?php 
$filename = "values.tsv";
$dataFile = fopen($filename, "r");
$tsvString = fread($dataFile, filesize($filename));
fclose($dataFile);

$lines = explode("\n", $tsvString);
$data = "";
for ($i = 0; $i < count($lines); $i++)
{
	if (strlen($lines[$i]) > 0)
	{
		$data[$i] = explode("\t", $lines[$i]);
	}
}

$indoorString = "";
$outdoorString = "";

//{ x: new Date(2014, 00, 01), y: 1200 },
foreach ($data as $value)
{
	$dt = date_parse_from_format("m/d/y H:i:s", $value[0]);
	$dtStr = "new Date(" . $dt["year"] . "," . ($dt["month"]-1) . "," . $dt["day"] . "," . $dt["hour"] . "," . $dt["minute"] . "," . $dt["second"] . ")";
	$idValue = $value[1]/100;
	$odValue = $value[2]/100;
	$indoorString .= "{x: $dtStr, y:$idValue},";
	$outdoorString .= "{x: $dtStr, y:$odValue},";
}

?>

<script>
window.onload = function () {

var chart = new CanvasJS.Chart("chartContainer", {
	title: {
		text: "Humidity"
	},
	axisX: {
		valueFormatString: "MM/DD/YY HH:mm"
	},
	toolTip: {
		shared: true
	},
	legend: {
		cursor: "pointer",
		verticalAlign: "top",
		horizontalAlign: "center",
		dockInsidePlotArea: true,
		itemclick: toogleDataSeries
	},
	data: [{
		type:"line",
		axisYType: "secondary",
		name: "Indoor",
		showInLegend: true,
		markerSize: 0,
		yValueFormatString: "##%",
		dataPoints: [<?php echo $indoorString; ?>]
	},
	{
		type: "line",
		axisYType: "secondary",
		name: "Outdoor",
		showInLegend: true,
		markerSize: 0,
		yValueFormatString: "##%",
		dataPoints: [<?php echo $outdoorString; ?>]
	}]
});
chart.render();

function toogleDataSeries(e){
	if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
		e.dataSeries.visible = false;
	} else{
		e.dataSeries.visible = true;
	}
	chart.render();
}

}
</script>
</head>
<body>
<div id="chartContainer" style="height: 370px; width: 100%;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</body>
</html>