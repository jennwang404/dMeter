
var height, width, padding;

var prev = 0;

function calculateDimensions(){
	height = $(".card").height()/1.7; 
	width = $(".card").width()*.9;
	paddingH = Math.abs(Math.min(height, width)/10 - 10);
	paddingW = Math.abs(Math.min(height, width)/10 + 5);
	console.log($(".card").width());
}

var xScale, yScale, xExtent, yExtent;

var parseLine;
var parseLineTemp;

calculateDimensions();

var svg = d3.select("#graph");
svg.attr("height", height)
	.attr("width", width);
	
var plot = svg.append("g");

function parseYear(data){
	data.forEach(function(d){
			d.Time = new Date(Number(d.Year),0);
			d.Usage = Number(d.EnergyUse);
		});
}

function parseMonth(data){
	data.forEach(function(d){
			d.Time = new Date(Number(d.Year), Number(d.Month)-1);
			d.Usage = Number(d.EnergyUse);
		});
}

function parseDay(data){
	data.forEach(function(d){
			d.Time = new Date(Number(d.Year), Number(d.Month)-1, Number(d.Day));
			console.log(d.Time);
			d.Usage = Number(d.EnergyUse);
		});
}

function parseDayTemp(data){
	data.forEach(function(d){
			d.Time = new Date(Number(d.Year), Number(d.Month)-1, Number(d.Day));
			console.log(d.Time);
			d.Temp = Number(d.Temp)
	});
}

function parseMonthTemp(data){
	data.forEach(function(d){
			d.Time = new Date(Number(d.Year), Number(d.Month)-1);
			console.log(d.Time);
			d.Temp = Number(d.Temp)
	});
}

function parseYearTemp(data){
	data.forEach(function(d){
			d.Time = new Date(Number(d.Year),0);
			console.log(d.Time);
			d.Temp = Number(d.Temp)
	});
}

function changeGraph(path, time){
	
	d3.select("#button"+prev).style("color", "#AEAEAE");
	d3.select("#button"+time).style("color", "#1BBC9B");
	prev = time;
	
	svg.remove();
	console.log(path);
	
	calculateDimensions();
	
	svg = d3.select("#svg").append("svg");
	svg.attr("height", height)
	.attr("width", width);
	
	plot = svg.append("g");
	
	if (time == 1) parseLine = parseMonth;
	else if (time == 0) parseLine = parseYear;
	else parseLine = parseDay;
	
	d3.json(path, function(error, d){
		var data = d;
		console.log(d);
		
		parseLine(data);
		
		xExtent = d3.extent(data, function(d){return d.Time});
		console.log(xExtent[1].getFullYear());
		yExtent = d3.extent(data, function(d){return d.Usage});
		yExtent[0] = 0;
		xScale = d3.scaleLinear().domain(xExtent).range([paddingW, width - paddingH]);
		yScale = d3.scaleLinear().domain(yExtent).range([height - paddingH, paddingH]);
		var xAxis = d3.axisBottom(xScale);
		if (time == 1) xAxis.tickFormat(d3.timeFormat("%b"));
		else if (time == 0)xAxis.tickFormat(d3.timeFormat("%y"));
		else xAxis.tickFormat(d3.timeFormat("%m-%d"))
		plot.append("g").call(xAxis).attr("transform", "translate(0," + (height - paddingH) + ")");
		plot.append("g").call(d3.axisLeft(yScale)).attr("transform", "translate(" + paddingW + ", 0)");
		
		graph(data, xScale, yScale);
	});
}

function graph(data, xScale, yScale){
	var pathGenerator = d3.line()
		.x(function(d){console.log((d.Time));return xScale(d.Time)})
		.y(function(d){return yScale(d.Usage)});
	
	plot.append("path")
	.datum(data)
	.attr("class", "lineGraph")
	.attr("d", function(d){return pathGenerator(d)})
	.style("stroke", "#E64C66")
	.style("fill", "none");
	
	var tmp = data;
	tmp.push({Time: xExtent[1], Usage: yExtent[0]});
	tmp.unshift({Time: xExtent[0], Usage: yExtent[0]});
	console.log(tmp);
	plot.append("path")
	.datum(tmp)
	.attr("class", "lineGraph")
	.attr("d", function(d){return pathGenerator(d)})
	.style("stroke", "none")
	.style("fill", "#E64C66")
	.style("fill-opacity", .5);
	
	
	
};

function changeGraphTemp(path, time){
	
	svg.remove();
	console.log(path);
	
	calculateDimensions();
	
	svg = d3.select("#svg").append("svg");
	svg.attr("height", height)
	.attr("width", width);
	
	plot = svg.append("g");
	
	if (time == 1) parseLineTemp = parseMonthTemp;
	else if (time == 0) parseLineTemp = parseYearTemp;
	else parseLineTemp = parseDayTemp;
	
	d3.json(path, function(error, d){
		var temp = d;
		console.log(d);
		
		parseLineTemp(temp);
		
		xExtent = d3.extent(temp, function(d){return d.Time});
		console.log(xExtent[1].getFullYear());
		yExtent = d3.extent(temp, function(d){return d.Temp});
		yExtent[0] = 0;
		xScale = d3.scaleLinear().domain(xExtent).range([paddingW, width - paddingH]);
		yScale = d3.scaleLinear().domain(yExtent).range([height - paddingH, paddingH]);
		var xAxis = d3.axisBottom(xScale);
		if (time == 1) xAxis.tickFormat(d3.timeFormat("%b"));
		else if (time == 0)xAxis.tickFormat(d3.timeFormat("%y"));
		else xAxis.tickFormat(d3.timeFormat("%m-%d"))
		plot.append("g").call(xAxis).attr("transform", "translate(0," + (height - paddingH) + ")");
		plot.append("g").call(d3.axisRight(yScale)).attr("transform", "translate(" + (width - paddingH) + ", 0)");
		
		graphTemp(temp, xScale, yScale);
	});
}

function graphTemp(data, xScale, yScale){
	var pathGeneratorTemp = d3.line()
		.x(function(d){console.log((d.Time));return xScale(d.Time)})
		.y(function(d){return yScale(d.Temp)});
	
	plot.append("path")
	.datum(data)
	.attr("class", "lineGraph")
	.attr("d", function(d){return pathGeneratorTemp(d)})
	.style("stroke", "#1BBC9B")
	.style("stroke-width", 3)
	.style("fill", "none");
	
	
	
};

function plotGraph(path, time){
	changeGraph(path, time);
	changeGraphTemp(path,time);
}