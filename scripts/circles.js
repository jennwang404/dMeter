
     d3.csv('data.csv', function (data) {

   // Variables
   w =600
   h =300

   // Scales
     var colorScale = d3.scale.linear()
                              .domain([-1, 0, 1])
                              .range(['#2D3E50', '#FFFFFF', '#E64C66'])

   // SVG
     var svg = d3.select('#circles').append('svg')
       .attr('height', h)
       .attr('width', w)
       .append('g')


   // Circles

   var circles = svg.selectAll('circle')
                    .data(data)
                    .enter()
                    .append('circle')
                    .attr('r', function (d) { return 1.6*Math.sqrt(d.usage) })
                    .attr('fill', '#FFFFFF')
                    .each(function () { d3.select(this)
                    .attr('cx', function (d) { return Math.floor(Math.random()*(w-(w/10.0) - (w/10.0) + 1) + (w/10.0))})
                    .attr('cy', function (d) { return Math.floor(Math.random()*(h-(h/10.0) - (h/10.0) + 1) + (h/10.0))})
                    .attr('fill', colorScale((Math.random()*Math.round(Math.random()) * 2 - 1)))})

                    .on('mouseover', function () { d3.select(this)
                                                     .transition()
                                                     .duration(500)
                                                     .attr('r', function (d) { return 2.5*Math.sqrt(d.usage) }) })
                    .on('mouseout', function () { d3.select(this)
                                                    .transition()
                                                    .duration(500)
                                                    .attr('r', function (d) { return 1.6*Math.sqrt(d.usage) })

     })
         .append('title') // Tooltip
           .text(function (d) { return 'Energy Usage: ' + d.usage + 'KWg'})


     svg.append('circle')
     .attr('cx', w/2.0)
     .attr('cy', h/2.0)
     .attr('r', '10')
     .attr('fill', '#1BBC9B')
    .on('mouseover', function () { d3.select(this)
                                                       .transition()
                                                       .duration(500)
                                                       .attr('r', '15') })
                      .on('mouseout', function () { d3.select(this)
                                                      .transition()
                                                      .duration(500)
                                                      .attr('r', '10')      })


       .append('title') // Tooltip
       .text(function (d) { return 'Energy Usage: ' + '10KWh'})

   })
