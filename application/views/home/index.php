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
		<?php $this->load->view('include/common_css');?>
	</head>
	<body>
		<div class="loader-block">
			<div class="pre-loader"></div>
			<div class="pre-loader-brand"><span class="blue-watercress">Watercress</span></div>
		</div>
		<?php $this->load->view('include/header');?>

		  <!-- first section - Home -->
		  <div id="home" class="home">
		    <div class="text-vcenter">
		      <h1><span class="blue-watercress">Watercress</span></h1>
		      <h3>We Speak your data out</h3>
		    </div>
		  </div>

  	   

		  <!-- third section - Services -->
		  <div id="services" class="pad-section">
		    <div class="container">
		      <h2 class="text-center">Our Services</h2> <hr />
		      <div class="row">
		      	<div class="text-center">
			        <div class="col-sm-3 col-xs-6">
			         	<div class="service-item">
							<a href="<?php echo site_url('data_visualization');?>" class="sv-icon"><i class="glyphicon glyphicon-stats"></i></a>
							<div class="sv-item-title">Data Visualization</div>
							<div class="sv-item-desc">We change the way you present your data by visualize your data</div>
						</div>
					</div>
					<div class="col-sm-3 col-xs-6">
			         	<div class="service-item">
							<a href="<?php echo site_url('photo_archive');?>" class="sv-icon"><i class="glyphicon glyphicon-globe"></i></a>
							<div class="sv-item-title">Photo Archive</div>
							<div class="sv-item-desc">Solutions for your photo archiving</div>
						</div>
					</div>
					<div class="col-sm-3 col-xs-6">
			         	<div class="service-item">
							<a href="<?php echo site_url('story_map');?>" class="sv-icon"><i class="glyphicon glyphicon-globe"></i></a>
							<div class="sv-item-title">Story Map</div>
							<div class="sv-item-desc">You can tell stories only with a map</div>
						</div>
					</div>
		        </div>          
		      </div>
		    </div>
		  </div>

	  	<div id="about" class="pad-section">
			<div class="container">
				<div class="row">
					<div class="col-sm-3"><i class="glyphicon glyphicon-leaf"></i></div>
					<div class="col-sm-9">
						<h2>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec in sem cras amet.</h2>
						<p class="lead">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed interdum metus et ligula venenatis, at rhoncus nisi molestie. Pellentesque porttitor elit suscipit massa laoreet metus.</p>
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
		
		<?php $this->load->view('include/common_js');?>
		<script type="text/javascript">
		$(function(){
			$(".loader-block").fadeOut();
		});
		</script>
	</body>
</html>