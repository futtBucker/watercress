<script src="<?php echo base_url('assets/js/jquery-1.12.3.min.js');?>"></script>
<script src="<?php echo base_url('assets/js/bootstrap.min.js');?>"></script>
<?php
if($need_data)
{
?>
<script src="<?php echo base_url('assets/js/d3.v3.min.js');?>"></script>
<script src="<?php echo base_url('assets/js/queue.v1.min.js');?>"></script>
<script src="<?php echo base_url('assets/js/topojson.v1.min.js');?>"></script>
<script src="<?php echo base_url('assets/js/nous.js');?>"></script>
<script>
	setTopojsonPath("<?php echo base_url('assets/'.$topojson_data);?>");
	setCoroplethData("<?php echo base_url('assets/'.$choropleth_data);?>");
	setBaseURL("<?php echo site_url('data_integration');?>");
</script>
<?php /*<script src="<?php echo base_url('assets/js/barchart.js');?>"></script> */ ?>
<script src="<?php echo base_url('assets/js/coropleth.js');?>"></script>
<script src="<?php echo base_url('assets/js/linechart.js');?>"></script>
<script src="<?php echo base_url('assets/js/piechart.js');?>"></script>
<?php
}

if(isset($insert) && !empty($insert))
{
	foreach($insert as $src)
	{
		echo '<script src="'.$src.'"></script>';
	}
}
?>