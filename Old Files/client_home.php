<?php
 // if(!isset($_SESSION["name"])){
 //        header("Location: index.php?#login");
 //    } 
?>
<!DOCTYPE html>
<html>
<head>
	<title>Solar Solutions</title>
	 <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
     <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
     <script src="charts/dist/Chart.bundle.js"></script>
    <script src="charts/samples/utils.js"></script>
	 <script src="js/bootstrap.min.js" ></script>
	   <script src="js/bootstrap.js" ></script>
	   <script type="text/javascript" src="js/jquery.js"></script>
	   <script type="text/javascript" src="js/jquery.min.js"></script>
	   <style type="text/css">
	   	.graph{
	   		/*height: 320px;*/
	   		/*background-color: yellow;*/
	   	}
	   	.cost {
	   		margin: 0px;
	   		height: 300px;
	   		background-color: #27ef23;
	   	}
	   	.dashboard {
	   		margin: 0;
	   		height: 640px;
	   		background-color: #eee;
	   	}
	   	.maploc {
	   		height: 320px;
	   		/*background-color: green;*/
	   	}
	   	.status {
	   		height: 300px;
	   		background-color: orange;
	   	}
	   	canvas {
        -moz-user-select: none;
        -webkit-user-select: none;
        -ms-user-select: none;
    }
	   </style>
</head>
<body bgcolor="#eee">
<nav class="navbar navbar-inverse">
<div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#"><?php echo $_SESSION["name"]; ?></a>
    </div>
    <ul class="nav navbar-nav navbar-right">
    <form action="client_home.php" method="post">
      <li><a href="index.php?#login"><span class="glyphicon glyphicon-log-out" name="logout"></span> Logout</a></li>
      </form>
    </ul>
    </div>
</nav>
<div class="row">
	<div class="dashboard col-md-2">
		<ul>
			<li>dashboard</li>
			<li>voltage</li>
			<li>donet</li>
			<li>gool</li>
			<li>boolh</li>
			<li>hytr</li>

		</ul>
	</div>
	<div class="col-md-10">
	<div class="row">
		<div class="graph col-md-8"><canvas id="canvas"></canvas></div>
		<div class="maploc col-md-4"><iframe width="330" height="320" src="http://solarsolutions.esy.es/map.php?city=thane&state=thane&pincode=400605"></iframe></div>
		</div>
	<div class="row">
		<div class="cost col-md-8"><h1 style="line-height:100px;font-style: bold;" align="center">Your Monthly Savings<br>56 &#8377;</h1></div>
		<div class="status col-md-4"><h1 align="center">Panel Status: </h1><br>
		<p>Temperature: 34<sup>o</sup> C</p>
		<p>Position: 45<sup>o</sup>s</p>
		<p>Wind Speed: 40 kph</p>
		<p>Efficiency: 11 % </p>
		<p>Battery Percentage: 60 %</p>
		</div>
		</div>
	</div>
	</div>
</div>
<script>
        var MONTHS = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        var config = {
            type: 'line',
            data: {
                labels: ["January", "February", "March", "April", "May", "June", "July"],
                datasets: [{
                    label: "Voltage Generated",
                    backgroundColor: window.chartColors.red,
                    borderColor: window.chartColors.red,
                    data: [
                        randomScalingFactor(), 
                        randomScalingFactor(), 
                        randomScalingFactor(), 
                        randomScalingFactor(), 
                        randomScalingFactor(), 
                        randomScalingFactor(), 
                        randomScalingFactor()
                    ],
                    fill: false,
                }, {
                    label: "Savings",
                    fill: false,
                    backgroundColor: window.chartColors.green,
                    borderColor: window.chartColors.green,
                    data: [
                        randomScalingFactor(), 
                        randomScalingFactor(), 
                        randomScalingFactor(), 
                        randomScalingFactor(), 
                        randomScalingFactor(), 
                        randomScalingFactor(), 
                        randomScalingFactor()
                    ],
                }]
            },
            options: {
                responsive: true,
                title:{
                    display:true,
                    text:'Energy Generated (GRAPH)'
                },
                tooltips: {
                    mode: 'index',
                    intersect: false,
                },
                hover: {
                    mode: 'nearest',
                    intersect: true
                },
                scales: {
                    xAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Month'
                        }
                    }],
                    yAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Value'
                        }
                    }]
                }
            }
        };

        window.onload = function() {
            var ctx = document.getElementById("canvas").getContext("2d");
            window.myLine = new Chart(ctx, config);
        };

        document.getElementById('randomizeData').addEventListener('click', function() {
            config.data.datasets.forEach(function(dataset) {
                dataset.data = dataset.data.map(function() {
                    return randomScalingFactor();
                });

            });

            window.myLine.update();
        });

        var colorNames = Object.keys(window.chartColors);
        document.getElementById('addDataset').addEventListener('click', function() {
            var colorName = colorNames[config.data.datasets.length % colorNames.length];
            var newColor = window.chartColors[colorName];
            var newDataset = {
                label: 'Dataset ' + config.data.datasets.length,
                backgroundColor: newColor,
                borderColor: newColor,
                data: [],
                fill: false
            };

            for (var index = 0; index < config.data.labels.length; ++index) {
                newDataset.data.push(randomScalingFactor());
            }

            config.data.datasets.push(newDataset);
            window.myLine.update();
        });

        document.getElementById('addData').addEventListener('click', function() {
            if (config.data.datasets.length > 0) {
                var month = MONTHS[config.data.labels.length % MONTHS.length];
                config.data.labels.push(month);

                config.data.datasets.forEach(function(dataset) {
                    dataset.data.push(randomScalingFactor());
                });

                window.myLine.update();
            }
        });

        document.getElementById('removeDataset').addEventListener('click', function() {
            config.data.datasets.splice(0, 1);
            window.myLine.update();
        });

        document.getElementById('removeData').addEventListener('click', function() {
            config.data.labels.splice(-1, 1); // remove the label first

            config.data.datasets.forEach(function(dataset, datasetIndex) {
                dataset.data.pop();
            });

            window.myLine.update();
        });
    </script>
    </body>
</html>
<?php
if(isset($_POST["logout"])){
	session_unset();
	session_destroy();
	header("Location: index.php?#login");
}
?>