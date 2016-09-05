<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
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
        <?php
        // put your code here
        echo 'HelloWorld!<br>';
        ?>

        <select id="inputkec" class="selectpicker" data-live-search="true">
            <?php
            foreach ($listkec as $row) {
                echo '<option data-tokens="' . trim($row['nama_kec']) . '">' . $row['nama_kec'] . '</option>';
            }
            ?>
        </select>

        <?php $this->load->view('include/common_js'); ?>
        <script src="<?php echo $this->config->item('js'); ?>bootstrap-select.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $('#inputkec').on('change', function () {
                    var selected = $(this).find("option:selected").val();
                    console.log('Event! Val: ' + selected);
                });
            });
        </script>
    </body>
</html>
