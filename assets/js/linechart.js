function generateLineChart(data)
{
  $('#line-chart').html('');

  var tooltipLineChart = d3.select("#line-chart").append("div").attr("class", "tooltip").style("opacity", 0);

  var margin = {top: 20, right: 80, bottom: 30, left: 50},
      line_width = ( $('#line-chart').width() - 0 )  - margin.left - margin.right,
      line_height = $('#line-chart').height() - margin.top - margin.bottom;

  var parseDate = d3.time.format("%Y%m%d");

  var x = d3.time.scale()
      .range([0, line_width - 90]);

  var y = d3.scale.linear()
      .range([line_height, 0]);

  var color = d3.scale.category10();

//  var xAxis = d3.svg.axis()
//      .scale(x)
//      .orient("bottom")
//      .ticks(5);

  var xAxis = d3.svg.axis()
    .scale(x)
    .orient("bottom")
    .ticks(d3.time.months, 1).tickFormat(d3.time.format('%b'));

  var yAxis = d3.svg.axis()
      .scale(y)
      .orient("left")
      .ticks(5);

  var line = d3.svg.line()
      .x(function(d) { return x(d.tahun); })
      .y(function(d) { return y(d.jumlah); });

  var svg_line = d3.select("#line-chart").append("svg")
      .attr("width", line_width + margin.left + margin.right)
      .attr("height", line_height + margin.top + margin.bottom)
      .append("g")
      .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

    color.domain(d3.keys(data[0]).filter(function(key) { return key !== "tahun"; }));

    data.forEach(function(d) {
      d.tahun = parseDate.parse(d.tahun);
    });

    // multiple color line
    var layanan = color.domain().map(function(name) {
      return {
        name: name,
        values: data.map(function(d) {
          return {tahun: d.tahun, jumlah: +d[name]};
        })
      };
    });

    x.domain(d3.extent(data, function(d) { return d.tahun; }));

    y.domain([
      d3.min(layanan, function(c) { return d3.min(c.values, function(v) { return v.jumlah; }); }),
      d3.max(layanan, function(c) { return d3.max(c.values, function(v) { return v.jumlah; }); })
    ]);

    svg_line.append("g")
        .attr("class", "x axis")
        .attr("transform", "translate(0," + line_height + ")")
        .call(xAxis);

    svg_line.append("g")
        .attr("class", "y axis")
        .call(yAxis)
      .append("text")
        .attr("transform", "rotate(-90)")
        .attr("y", 6)
        .attr("dy", ".71em")
        .style("text-anchor", "end")
        .text("Jumlah");

    var individu = svg_line.selectAll(".layanan")
        .data(layanan)
        .enter().append("g")
        .attr("class", "layanan");

//    individu.append("path")
//        .attr("class", "line")
//        .attr("d", function(d) { return line(d.values); })
//        .attr("data-legend",function(d) { return d.name})
//        .style("stroke", function(d) { return color(d.name); });
   
    var path = individu.append("path")
        .attr("class", "line")
        .attr("d", function(d) { return line(d.values); })
        .attr("data-legend",function(d) { return d.name});

    path.on('click', function (d) {
        console.log('klik',d);
    });
    
    path.on('mouseover', showPathTooltipLineChart).on('mousemove',moveTooltip).on('mouseout',hideTooltip);

    path.style("stroke", function(d) { return color(d.name); }).style('cursor','pointer');
    
    individu.append("text")
      .datum(function(d) { return {name: d.name, value: d.values[d.values.length - 1]}; })
      .attr("transform", function(d) { return "translate(" + x(d.value.tahun) + "," + y(d.value.jumlah) + ")"; })
      .attr("x", 3)
      .attr("dy", ".35em")
      .text(function(d) { return d.name; });

    svg_line.selectAll("g.dot")
        .data(layanan)
        .enter().append("g")
        .attr("class", "dot")
        .selectAll("circle")
        .data(function(d) { return d.values; })
        .enter().append("circle")
        .attr("r", 2)
        .attr("cx", function(d,i) {  return x(d.tahun); })
        .attr("cy", function(d,i) { return y(d.jumlah); })
        .on("click",showAlert)
        .on("mouseover",showTooltipLineChart)  
        .on("mousemove",moveTooltip)
        .on("mouseout",hideTooltip);

    var line_legend = svg_line.append("g")
      .attr("class","line-legend")
      .attr("transform","translate(390,30)")
      .style("font-size","12px")
      .call(d3.legend);

    setTimeout(function() { 
      line_legend
        .style("font-size","20px")
        .attr("data-style-padding",10)
        .call(d3.legend)
    },1000);
}

function showAlert() {
    console.log('Oke');
}

function showTooltipLineChart(d) {
  moveTooltip();
  tooltip.style("display","block")
  .text("Jumlah = "+d.jumlah);
}

function showPathTooltipLineChart(d) {
  moveTooltip();
  tooltip.style("display","block")
  .text(d.name);
}