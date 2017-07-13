/* Script to display either Day, Week, Month, or Year Data */

function day_function() {
	document.getElementById('day').style.display = 'block';
	document.getElementById('week').style.display = 'none';
	document.getElementById('month').style.display = 'none';
	document.getElementById('year').style.display = 'none';
}

function week_function() {
	document.getElementById('day').style.display = 'none';
	document.getElementById('week').style.display = 'block';
	document.getElementById('month').style.display = 'none';
	document.getElementById('year').style.display = 'none';
}

function month_function() {
	document.getElementById('day').style.display = 'none';
	document.getElementById('week').style.display = 'none';
	document.getElementById('month').style.display = 'block';
	document.getElementById('year').style.display = 'none';
}

function year_function() {
	document.getElementById('day').style.display = 'none';
	document.getElementById('week').style.display = 'none';
	document.getElementById('month').style.display = 'none';
	document.getElementById('year').style.display = 'block';
}



/* Day Data Viz Script */

// set the dimensions and margins of the graph
var margin = {top: 20, right: 10, bottom: 20, left: 10},
    width = 500 - margin.left - margin.right,
    height = 300 - margin.top - margin.bottom;

// parse the date / time
var parseTimeDay = d3.timeParse("%Y-%m-%d-%H:%M");

// set the ranges
var x = d3.scaleTime().range([0, width]);
var y = d3.scaleLinear().range([height, 0]);


var area = d3.area()
    .x(function(d) { return x(d.date); })
    .y0(height)
    .y1(function(d) { return y(d.usage); });

// define the line
var valueline = d3.line()
    .x(function(d) { return x(d.date); })
    .y(function(d) { return y(d.usage); });

// append the svg obgect to the body of the page
// appends a 'group' element to 'svg'
// moves the 'group' element to the top left margin
var svgDay = d3.select("#day").append("svg")
    .attr("width", width + margin.left + margin.right)
    .attr("height", height + margin.top + margin.bottom)
  	.append("g")
    .attr("transform",
          "translate(" + margin.left + "," + margin.top + ")");

// Get the data
d3.csv("daydata.csv", function(error, data) {
  if (error) throw error;
  // format the data
  data.forEach(function(d) {
      d.date = parseTimeDay(d.date);
      //console.log(d.date);
      console.log(d.date);
      d.usage = +d.usage;
  });

  // Scale the range of the data
  x.domain(d3.extent(data, function(d) { return d.date; }));
  y.domain([0, d3.max(data, function(d) { return d.usage; })]);

  // add the area
  svgDay.append("path")
       .data([data])
       .attr("class", "area")
       .attr("d", area);

  // Add the valueline path.
  svgDay.append("path")
      .data([data])
      .attr("class", "energyline")
      .attr("d", valueline);

  // Add the X Axis
  svgDay.append("g")
      .attr("transform", "translate(0," + height + ")")
      .call(d3.axisBottom(x));

  // Add the Y Axis
  svgDay.append("g")
      .call(d3.axisLeft(y));

});


/* Week Data Viz Script */


// set the dimensions and margins of the graph
var margin = {top: 20, right: 10, bottom: 20, left: 10},
    width = 500 - margin.left - margin.right,
    height = 300 - margin.top - margin.bottom;

// parse the date / time
var parseTimeWeek = d3.timeParse("%Y-%m-%d");

// set the ranges
var x = d3.scaleTime().range([0, width]);
var y = d3.scaleLinear().range([height, 0]);

var area = d3.area()
    .x(function(d) { return x(d.date); })
    .y0(height)
    .y1(function(d) { return y(d.usage); });

// define the line
var valueline = d3.line()
    .x(function(d) { return x(d.date); })
    .y(function(d) { return y(d.usage); });

// append the svg obgect to the body of the page
// appends a 'group' element to 'svg'
// moves the 'group' element to the top left margin
var svgWeek = d3.select("#week").append("svg")
    .attr("width", width + margin.left + margin.right)
    .attr("height", height + margin.top + margin.bottom)
  	.append("g")
    .attr("transform",
          "translate(" + margin.left + "," + margin.top + ")");

// Get the data
d3.csv("weekdata.csv", function(error, data) {
  if (error) throw error;

  // format the data
  data.forEach(function(d) {
      d.date = parseTimeWeek(d.date);
      console.log(d.date);
      d.usage = +d.usage;
      console.log(d.usage);
  });

  // Scale the range of the data
  x.domain(d3.extent(data, function(d) { return d.date; }));
  y.domain([0, d3.max(data, function(d) { return d.usage; })]);

  // add the area
  svgWeek.append("path")
       .data([data])
       .attr("class", "area")
       .attr("d", area);

  // Add the valueline path.
  svgWeek.append("path")
      .data([data])
      .attr("class", "energyline")
      .attr("d", valueline);

  // Add the X Axis
  svgWeek.append("g")
      .attr("transform", "translate(0," + height + ")")
      .call(d3.axisBottom(x).ticks(7));

  // Add the Y Axis
  svgWeek.append("g")
      .call(d3.axisLeft(y));

});

/* Month Data Viz Script */


// set the dimensions and margins of the graph
var margin = {top: 20, right: 10, bottom: 20, left: 10},
    width = 500 - margin.left - margin.right,
    height = 300 - margin.top - margin.bottom;

// parse the date / time
var parseTimeMonth = d3.timeParse("%Y-%m-%d");

// set the ranges
var x = d3.scaleTime().range([0, width]);
var y = d3.scaleLinear().range([height, 0]);

var area = d3.area()
    .x(function(d) { return x(d.date); })
    .y0(height)
    .y1(function(d) { return y(d.usage); });

// define the line
var valueline = d3.line()
    .x(function(d) { return x(d.date); })
    .y(function(d) { return y(d.usage); });

// append the svg obgect to the body of the page
// appends a 'group' element to 'svg'
// moves the 'group' element to the top left margin
var svgMonth = d3.select("#month").append("svg")
    .attr("width", width + margin.left + margin.right)
    .attr("height", height + margin.top + margin.bottom)
  	.append("g")
    .attr("transform",
          "translate(" + margin.left + "," + margin.top + ")");

// Get the data
d3.csv("monthdata.csv", function(error, data) {
  if (error) throw error;

  // format the data
  data.forEach(function(d) {
      d.date = parseTimeMonth(d.date);
      d.usage = +d.usage;
  });

  // Scale the range of the data
  x.domain(d3.extent(data, function(d) { return d.date; }));
  y.domain([0, d3.max(data, function(d) { return d.usage; })]);

  // add the area
  svgMonth.append("path")
       .data([data])
       .attr("class", "area")
       .attr("d", area);

  // Add the valueline path.
  svgMonth.append("path")
      .data([data])
      .attr("class", "energyline")
      .attr("d", valueline);

  // Add the X Axis
  svgMonth.append("g")
      .attr("transform", "translate(0," + height + ")")
      .call(d3.axisBottom(x).ticks(4));

  // Add the Y Axis
  svgMonth.append("g")
      .call(d3.axisLeft(y));

});


/* Year Data Viz Script */


// set the dimensions and margins of the graph
var margin = {top: 20, right: 10, bottom: 20, left: 10},
    width = 500 - margin.left - margin.right,
    height = 300 - margin.top - margin.bottom;

// parse the date / time
var parseTimeYear = d3.timeParse("%Y-%m");

// set the ranges
var x = d3.scaleTime().range([0, width]);
var y = d3.scaleLinear().range([height, 0]);

var area = d3.area()
    .x(function(d) { return x(d.date); })
    .y0(height)
    .y1(function(d) { return y(d.usage); });

// define the line
var valueline = d3.line()
    .x(function(d) { return x(d.date); })
    .y(function(d) { return y(d.usage); });

// append the svg obgect to the body of the page
// appends a 'group' element to 'svg'
// moves the 'group' element to the top left margin
var svgYear = d3.select("#year").append("svg")
    .attr("width", width + margin.left + margin.right)
    .attr("height", height + margin.top + margin.bottom)
  	.append("g")
    .attr("transform",
          "translate(" + margin.left + "," + margin.top + ")");

// Get the data
d3.csv("yeardata.csv", function(error, data) {
  if (error) throw error;

  // format the data
  data.forEach(function(d) {
      d.date = parseTimeYear(d.date);
      d.usage = +d.usage;
  });

  // Scale the range of the data
  x.domain(d3.extent(data, function(d) { return d.date; }));
  y.domain([0, d3.max(data, function(d) { return d.usage; })]);

  // add the area
  svgYear.append("path")
       .data([data])
       .attr("class", "area")
       .attr("d", area);

  // Add the valueline path.
  svgYear.append("path")
      .data([data])
      .attr("class", "energyline")
      .attr("d", valueline);

  // Add the X Axis
  svgYear.append("g")
      .attr("transform", "translate(0," + height + ")")
      .call(d3.axisBottom(x).ticks(12));

  // Add the Y Axis
  svgYear.append("g")
      .call(d3.axisLeft(y));

});
