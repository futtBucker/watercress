<!doctype html>
<!--[if IE 9 ]><html class="ie9" lang="en"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html lang="en"><!--<![endif]-->
    <head>
        <title>Watercress</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <!--meta info-->
        <meta name="author" content="">
        <meta name="keywords" content="">
        <meta name="description" content="">
        <?php $this->load->view('include/common_css'); ?>
        <link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('css'); ?>bootstrap-select.css"/>
    </head>
    <body>
        <?php $this->load->view('include/header'); ?>
        <br/>
        <div class="pad-section">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6 col-xs-6">
                        <label for="inputkec">Kecamatan : </label>
                        <select name="inputkec" id="inputkec" class="selectpicker col-sm-10" data-live-search="true">
                            <?php
                            foreach ($listkec as $row) {
                                $selected = '';
                                if($row['nama_kec'] == 'TAMBORA') {
                                    $selected = 'selected';
                                }
                                echo '<option data-tokens="' . trim($row['nama_kec']) . '" '.$selected.'>' . $row['nama_kec'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>					
                </div>
                <div class="row">
                    <div class="col-sm-12 col-xs-12">
                        <h1 class="h1-wc">Data Layanan Puskesmas Kecamatan : <span id="title-kecamatan"></span></h1>
                    </div>					
                </div>
                <div class="row">
                    <div class="col-sm-6 col-xs-6">
                        <div class="map-kios" id="peta_jakarta"></div>
                    </div>
                    <div class="col-sm-6 col-xs-8">
                        <div class="row">
                            <div class="col-sm-12 col-xs-12">
                                <h1 class="h3-wc">Layanan Puskesmas Kecamatan : <span id="title-kecamatan"></span></h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-xs-12">
                                <div class="graph-chart" id="line-chart"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-xs-12">
                                <svg class="graph-chart chart" id="line-chart-legend"></svg>
                            </div>
                        </div><br />
                        <div class="row">
                            <div class="col-sm-12 col-xs-12">
                                <label for="inputsubvar">Populasi Kunci : </label>
                                <select name="inputsubvar" id="inputsubvar" class="selectpicker col-sm-8" data-live-search="true">
                                    <?php
                                    foreach ($listsubvar as $row) {
                                        $selected = '';
                                        if ($row['sub_sub_variabel'] == 'WPS') {
                                            $selected = 'selected';
                                        }
                                        echo '<option data-tokens="' . trim($row['sub_sub_variabel']) . '" ' . $selected . '>' . $row['sub_sub_variabel'] . '</option>';
                                    }
                                    ?>
                                </select>
                                <br/>
                                <div class="graph-chart" id="bar-subvar"></div>
                            </div>
                        </div><br />
                        <div class="row">
                            <div class="col-sm-12 col-xs-12">
                                <h3 class="h3-wc">Populasi Kunci : <span id="title-layanan">VCT</span></h3>
                                <svg class="graph-chart chart" id="bar-populasi-kunci"></svg>
                            </div>
                        </div><br />
                        <div class="row">
                            <div class="col-sm-12 col-xs-12">
                                <h3 class="h3-wc">Rentang Usia Populasi Kunci : <span id="title-layanan">PSK</span></h3>
                                <div class="graph-chart" id="bar-usia"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- fifth section -->
        <footer>
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 text-center">
                        &copy; 2015 Watercress
                    </div>
                </div>
            </div>
        </footer>
        <?php $this->load->view('include/common_js'); ?>
        <script src="<?php echo $this->config->item('js'); ?>bootstrap-select.js"></script>
        <script src="<?php echo $this->config->item('js'); ?>d3.v3.min.js"></script>
        <script src="<?php echo $this->config->item('js'); ?>queue.v1.min.js"></script>
        <script src="<?php echo $this->config->item('js'); ?>topojson.v1.min.js"></script>
        <script src="<?php echo $this->config->item('js'); ?>d3.legend.js"></script>
        <script type="text/javascript">
            var topojson_path = '<?php echo $topojson_path; ?>',
                    choropleth_path = '<?php echo $choropleth_path; ?>',
                    base_url = '<?php echo base_url("data_integration/ajax"); ?>';
        </script>
        <script src="<?php echo $this->config->item('js'); ?>coropleth2.js"></script>
        <script src="<?php echo $this->config->item('js'); ?>linechart2.js"></script>
        <script src="<?php echo $this->config->item('js'); ?>groupedBarChart.js"></script>
        <script src="<?php echo $this->config->item('js'); ?>barchart.js"></script>
        <script src="<?php echo $this->config->item('js'); ?>barchart2.js"></script>
        <script type="text/javascript">
            
            $(document).ready(function () {
                $('#inputkec').on('change', function () {
                    var selected = $(this).find("option:selected").val();
                    console.log('Event! Val: ' + selected);
                    var obj = {};
                    obj.properties = {KECAMATAN: selected};
                    triggerOtherChart(obj);
                });
            });
            
            $(function () {
                var obj = {};
                obj.properties = {KECAMATAN: "TAMBORA"};
                triggerOtherChart(obj);
            });
        </script>
    </body>
</html>