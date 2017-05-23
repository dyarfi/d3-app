jQuery(window).load( function(){

	var radarChartData = {
		labels : ["A","B","C","D","E","F","G"],
		datasets : [
			{
				fillColor : "rgba(220,220,220,0.5)",
				strokeColor : "rgba(220,220,220,1)",
				pointColor : "rgba(220,220,220,1)",
				pointStrokeColor : "#fff",
				data : [65,59,90,81,56,55,40]
			},
			{
				fillColor : "rgba(151,187,205,0.5)",
				strokeColor : "rgba(151,187,205,1)",
				pointColor : "rgba(151,187,205,1)",
				pointStrokeColor : "#fff",
				data : [28,48,40,19,96,27,100]
			}
		]

	};

	var doughnutChartData = [
		{
			value: 30,
			color:"#F7464A"
		},
		{
			value : 50,
			color : "#46BFBD"
		},
		{
			value : 100,
			color : "#FDB45C"
		},
		{
			value : 40,
			color : "#949FB1"
		},
		{
			value : 120,
			color : "#4D5360"
		}
	];

	var globalGraphSettings = {animation : Modernizr.canvas};

	function showRadarChart(){
		var ctx = document.getElementById("radarChartCanvas").getContext("2d");
		new Chart(ctx).Radar(radarChartData,globalGraphSettings);
	}

	function showDoughnutChart(){
		var ctx = document.getElementById("doughnutChartCanvas").getContext("2d");
		new Chart(ctx).Doughnut(doughnutChartData,globalGraphSettings);
	}

	$('#radarChart').appear( function(){ $(this).css({ opacity: 1 }); setTimeout(showRadarChart,300); },{accX: 0, accY: -155},'easeInCubic');

	$('#doughnutChart').appear( function(){ $(this).css({ opacity: 1 }); setTimeout(showDoughnutChart,300); },{accX: 0, accY: -155},'easeInCubic');

});
