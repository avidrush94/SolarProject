$(document).ready(function(){
	$.ajax({
		url : "/fetch_chart.data.php?client_id=RushitJi",
		type : "GET",
		success : function(data){
			console.log(data);

			var id = [];
			var date_log = [];
			var voltage = [];
			var current = [];

			for(var i in data) {
				id.push("id " + data[i].id);
				date_log.push(data[i].date_log);
				voltage.push(data[i].voltage);
				current.push(data[i].current);
			}

			var chartdata = {
				labels: id,
				datasets: [
					{
						label: "Date_log",
						fill: false,
						lineTension: 0.1,
						backgroundColor: "rgba(59, 89, 152, 0.75)",
						borderColor: "rgba(59, 89, 152, 1)",
						pointHoverBackgroundColor: "rgba(59, 89, 152, 1)",
						pointHoverBorderColor: "rgba(59, 89, 152, 1)",
						data: date_log
					},
					{
						label: "Voltage",
						fill: false,
						lineTension: 0.1,
						backgroundColor: "rgba(29, 202, 255, 0.75)",
						borderColor: "rgba(29, 202, 255, 1)",
						pointHoverBackgroundColor: "rgba(29, 202, 255, 1)",
						pointHoverBorderColor: "rgba(29, 202, 255, 1)",
						data: voltage
					},
					{
						label: "Current",
						fill: false,
						lineTension: 0.1,
						backgroundColor: "rgba(211, 72, 54, 0.75)",
						borderColor: "rgba(211, 72, 54, 1)",
						pointHoverBackgroundColor: "rgba(211, 72, 54, 1)",
						pointHoverBorderColor: "rgba(211, 72, 54, 1)",
						data: current
					}
				]
			};

			var ctx = $("#mycanvas");

			var LineGraph = new Chart(ctx, {
				type: 'line',
				data: chartdata
			});
		},
		error : function(data) {

		}
	});
});
