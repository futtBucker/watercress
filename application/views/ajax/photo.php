<?php
if($num_rows > 0)
{
	foreach($rs as $row)
	{
?>


		<div class="col-md-12">
			<div class="row">
				<div class="map-photo">
					<div class="col-md-7 map-photo-title"><?php echo stripslashes($row->title);?></div>
					<div class="col-md-5 map-photo-coordinate"><?php echo stripslashes($row->coordinate);?></div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-7 col-md-offset-2"><img src="<?php echo $this->config->item('image_path') ;?><?php echo stripslashes($row->path)."/".stripslashes($row->filename);?>" width="100%" /></div>
			</div>
			<div class="row">
				<div class="col-md-12 map-photo-desc"><?php echo stripslashes($row->description);?></div>
			</div>
		</div>
	

<?php
	}
}
else
{
?>
<div class="col-md-12">
	<div class="row">
		<div class="map-photo">
			<div class="col-md-7 map-photo-title"></div>
			<div class="col-md-5 map-photo-coordinate"></div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12"></div>
	</div>
	<div class="row">
		<div class="col-md-12 map-photo-desc">On progress...</div>
	</div>
</div>
<?php
}
?>

