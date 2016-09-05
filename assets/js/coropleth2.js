var tooltip = d3.select("body").append("div").attr("class", "map-label");
var tooltipOffset = {x: 10, y: -30};

var coro_width = $("#peta_jakarta").width(),
        coro_height = $("#peta_jakarta").height(),
        coro_scale = 90823.3699297915 //72658.69594383324 //68108.29150469122,
coro_center_x = 106.8184017615508  //106.81840176155082 // 106.81840513524071,
coro_center_y = -6.232581157232587  //-6.232581157232587 //-6.232560959839282;

//Map projection
var projection = d3.geo.mercator()
        .scale(coro_scale)
        .center([coro_center_x, coro_center_y]) //projection center
        .translate([coro_width / 2, coro_height / 2]) //translate to center the map in view

//Generate paths based on projection
var path = d3.geo.path()
        .projection(projection);

var quantize = d3.scale.quantize()
        .domain([400000, 460000])
        .range(d3.range(9).map(function (i) {
            return "q" + i;
        }));

//Create an SVG
var svg_coropleth = d3.select("#peta_jakarta")
        .append("svg")
        .attr("width", coro_width)
        .attr("height", coro_height);

var jumlahByKecamatan = d3.map();

queue()
        .defer(d3.json, topojson_path)
        .defer(d3.json, base_url + '/choropleth')
        .await(ready);

function ready(error, jkt, kmt) {
    if (error)
        throw error;

    $.each(kmt, function (key, value) {
        jumlahByKecamatan.set(value.kecamatan, +value.jumlah);
    });

    svg_coropleth.append("g")
            .attr("class", "kecamatan")
            .selectAll("path")
            .data(topojson.feature(jkt, jkt.objects.collection).features)
            .enter().append("path")
            .attr("class", function (d) {
                return quantize(jumlahByKecamatan.get(d.properties.KECAMATAN));
            })
            .attr("d", path)
            .on("click", triggerOtherChart)
            .on("mouseover", showTooltipChoropleth)
            .on("mousemove", moveTooltip)
            .on("mouseout", hideTooltip);
}


function showTooltipBarChart(d) {
    moveTooltip();
    tooltip.style("display", "block")
            .text(d.value);
}

function showTooltipChoropleth(d) {
    moveTooltip();
    tooltip.style("display", "block")
            .text(d.properties.KECAMATAN);
}

function moveTooltip() {
    tooltip
            .style("top", (d3.event.pageY + tooltipOffset.y) + "px")
            .style("left", (d3.event.pageX + tooltipOffset.x) + "px");
}

function hideTooltip() {
    tooltip.style("display", "none");
}

function triggerOtherChart(d, i)
{
    $('#title-kecamatan').html(d.properties.KECAMATAN);

    $('select[name=inputkec').val(d.properties.KECAMATAN);
    $('.selectpicker').selectpicker('refresh');

    $.ajax({
        url: base_url + '/linechart2',
        data: {'kecamatan': d.properties.KECAMATAN},
        dataType: "json",
        type: "get",
        success: function (response) {
            generateLineChart(response);
            //$('#line-title').html(d.properties.KECAMATAN);
        }
    });

    $.ajax({
        url: base_url + '/groupedbarchart',
        data: {'kecamatan': d.properties.KECAMATAN},
        dataType: "json",
        type: "get",
        success: function (response) {
            generateGroupedBarChart(response);
            //$('#line-title').html(d.properties.KECAMATAN);
        }
    });

    $.ajax({
        url: base_url + '/barchart',
        data: {'kecamatan': d.properties.KECAMATAN},
        dataType: "json",
        type: "get",
        success: function (response) {
            barChart(response);
            //$('#line-title').html(d.properties.KECAMATAN);
        }
    });
}
