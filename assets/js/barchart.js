function barChart(data)
{
    var bar_usia = $('#bar-usia');
    bar_usia.html('');

    var margin = {top: 20, right: 20, bottom: 30, left: 40},
    bar_width = bar_usia.width() - margin.left - margin.right,
    bar_height = bar_usia.height() - margin.top - margin.bottom;


  var x0 = d3.scale.ordinal()
      .rangeRoundBands([0, bar_width - 70], .1);

  var x1 = d3.scale.ordinal();

  var y = d3.scale.linear()
      .range([bar_height, 0]);

  var color = d3.scale.ordinal()
    .range(["#1f77b4", "#d62728", "#ff7f0e", "#2ca02c"]);

  var xAxis = d3.svg.axis()
      .scale(x0)
      .orient("bottom");

  var yAxis = d3.svg.axis()
      .scale(y)
      .orient("left")
      .tickFormat(d3.format(".2s"));

  var svg_bar = d3.select("#bar-usia").append("svg")
      .attr("width", bar_width + margin.left + margin.right)
      .attr("height", bar_height + margin.top + margin.bottom)
      .append("g")
      .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

  var g = svg_bar.append("g");

  var ageNames = d3.keys(data[0]).filter(function(key) { return key !== "tahun"; });


  data.forEach(function(d) {
    d.ages = ageNames.map(function(name) { return {name: name, value: +d[name]}; });
  });

  x0.domain(data.map(function(d) { return d.tahun; }));
  x1.domain(ageNames).rangeRoundBands([0, x0.rangeBand()]);
  y.domain([0, d3.max(data, function(d) { return d3.max(d.ages, function(d) { return d.value; }); })]);

  svg_bar.append("g")
      .attr("class", "x axis")
      .attr("transform", "translate(0," + bar_height + ")")
      .call(xAxis);

  svg_bar.append("g")
      .attr("class", "y axis")
      .call(yAxis)
      .append("text")
      .attr("transform", "rotate(-90)")
      .attr("y", 6)
      .attr("dy", ".71em")
      .style("text-anchor", "end")
      .text("Jumlah");

  var tipe = svg_bar.selectAll(".tipe")
      .data(data)
      .enter().append("g")
      .attr("class", "tipe")
      .attr("transform", function(d) {  return "translate(" + x0(d.tahun) + ",0)"; });
  tipe.selectAll(".bar")
      .data(function(d) { return d.ages; })
      .enter().append("rect")
      .attr("class", "bar")
      .attr("width", x1.rangeBand())
      .attr("x", function(d) { return x1(d.name); })
      .attr("y", function(d) { return y(d.value); })
      .attr("height", function(d) { return bar_height - y(d.value); })
      .style("fill", function(d) { return color(d.name); })
       .on("mouseover",showTooltipBarChart)
      .on("mousemove",moveTooltip)
      .on("mouseout",hideTooltip);

  var legend = svg_bar.selectAll(".legend")
      .data(ageNames.slice())
    .enter().append("g")
      .attr("class", "legend-items")
      .attr("transform", function(d, i) { return "translate(0," + i * 20 + ")"; });

  legend.append("rect")
      .attr("x", bar_width - 18)
      .attr("width", 18)
      .attr("height", 18)
      .style("fill", color);

  legend.append("text")
      .attr("x", bar_width - 24)
      .attr("y", 9)
      .attr("dy", ".35em")
      .style("text-anchor", "end")
      .text(function(d) { return d; });

}