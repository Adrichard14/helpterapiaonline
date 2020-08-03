var previousX = null, previousY = null;
function showTooltip(x, y, contents) {
	$('<div id="tooltip">' + contents + '</div>').css({
		position: 'absolute',
		display: 'none',
		top: y - 35,
		left: x - 85,
		border: '1px solid #333',
		padding: '4px',
		color: '#fff',
		'border-radius': '3px',
		'background-color': '#333',
		opacity: 0.80
	}).appendTo("body").fadeIn(200);
}

$(document).ready(function() {
	var data = [{
		data: pageviews,
		label: "Visualizações"
	}, {
		data: visitors,
		label: "Visitantes"
	}];
	var plot = $.plot($("#statistic"), data, {
		series: {
			lines: {
				show: true,
				lineWidth: 2,
				fill: true,
				fillColor: {
					colors: [{
						opacity: 0.05
					}, {
						opacity: 0.01
					}]
				}
			},
			points: {
				show: true
			},
			shadowSize: 2
		},
		xaxis: {
			mode: "categories",
			tickLength: 0
		},
		grid: {
			backgroundColor: {
				colors: ["#fff", "#eee"]
			},
			borderWidth: {
				top: 1,
				right: 1,
				bottom: 2,
				left: 2
			},
			hoverable: true,
			clickable: true,
			borderWidth: 0
		},
        colors: ["#d12610", "#37b7f3", "#52e136"]
	});
	$("#statistic").bind("plothover", function (event, pos, item) {
		$("#x").text(pos.x.toFixed(2));
		$("#y").text(pos.y.toFixed(2));
		if (item) {
			var index = item.dataIndex;
			var label = item.series.data[index][0];
			if (previousX != item.datapoint[0] || previousY != item.datapoint[1]) {
				previousX = item.datapoint[0];
				previousY = item.datapoint[1];
				$("#tooltip").remove();
				var x = previousX.toFixed(0),
					y = previousY.toFixed(0);
				showTooltip(item.pageX, item.pageY, item.series.label + " de " + label + ": " + y);
			}
		} else {
			$("#tooltip").remove();
			previousX = null;
			previousY = null;
		}
	});
});
