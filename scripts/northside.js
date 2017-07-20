

    d3.csv('data.csv', function (data) {

    // Variables
      var body = d3.select('body')
      var margin = { top: 50, right: 50, bottom: 50, left: 50 }
      var h = 500 - margin.top - margin.bottom
      var w = 500 - margin.left - margin.right
      var formatPercent = d3.format('.2%')

    // Scales
      var colorScale = d3.scale.linear()
                               .domain([0, 1])
                               .range(['#1BBC9B', '#FFFFFF', '#E64C66'])

      var xScale = d3.scale.linear().domain([0,1]).range([0,w])

      var yScale = d3.scale.linear().domain([0,1]).range([h,0])

    // SVG
      var svg = d3.select('body').append('svg')
        .attr('height', h + margin.top + margin.bottom)
        .attr('width', w + margin.left + margin.right)
        .append('g')
        .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

        svg.append('rect')
           .attr('width', '100%')
           .attr('height', '100%')
           .attr('fill', '#AEAEAE');

    // Circles
    svg.append('circle')
    .attr('cx', 225)
    .attr('cy', 225)
    .attr('r', '25')
    .attr('fill', '#1BBC9B')
	.on('mouseover', function () { d3.select(this)
                                                      .transition()
                                                      .duration(500)
                                                      .attr('r', function (d) { return 4*Math.sqrt(25) }) })
                     .on('mouseout', function () { d3.select(this)
                                                     .transition()
                                                     .duration(500)
                                                     .attr('r', function (d) { return 3*Math.sqrt(25) })      })


    .append('title') // Tooltip
      .text(function (d) { return 'Energy Usage: ' + 25})

    var circles = svg.selectAll('circle')
                     .data(data)
                     .enter()
                     .append('circle')
                     .attr('cx', function (d) { return w*(d.randomx) })
                     .attr('cy', function (d) { return h*(d.randomy) })
                     .attr('r', function (d) { return 3*Math.sqrt(d.usage) })
                     .attr('fill', '#FFFFFF')
                     .on('mouseover', function () { d3.select(this)
                                                      .transition()
                                                      .duration(500)
                                                      .attr('r', function (d) { return 4*Math.sqrt(d.usage) }) })
                     .on('mouseout', function () { d3.select(this)
                                                     .transition()
                                                     .duration(500)
                                                     .attr('r', function (d) { return 3*Math.sqrt(d.usage) })
      })


    .append('title') // Tooltip
      .text(function (d) { return 'Energy Usage: ' + d.usage});

    })