<?php if(!defined("BASE_DS")) die(); ?>
<!DOCTYPE HTML>
<html lang = "fr">
<head>
		<meta charset="utf-8" />
		<title><?php echo $CONFIG['title']; ?></title>
		<meta content="IE=edge" http-equiv="X-UA-Compatible" />
		<meta content="width=device-width, initial-scale=1" name="viewport" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<link rel="shortcut icon" href="wp-content/themes/iconiac/favicon.ico" type="image/x-icon" />
		<link rel="stylesheet" type="text/css" href="css/reset.css" media="screen" />
		<link rel="stylesheet" type="text/css" href="fonts/fonts/icons.css" media="screen" />
		<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css" media="screen" />
		<link rel="stylesheet" type="text/css" href="css/dat-menu.css" media="screen" />
		<link rel="stylesheet" type="text/css" href="css/main-stylesheet.css" media="screen" />
		<link rel="stylesheet" type="text/css" href="css/responsive.css" media="screen" />
		<link rel="stylesheet" type="text/css" href="assets/css/jquery.simplyscroll.css" media="screen" />
		<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Open+Sans:400,600,700|Oswald:300,400,700|Source+Sans+Pro:300,400,600,700&amp;subset=latin,latin-ext" />
		<link rel='stylesheet' id='aot-webfonts-raleway-css'  href='http://fonts.googleapis.com/css?family=Raleway%3A300%2C400%2C600%2C700%2C900%2C300italic%2C400italic%2C600italic%2C700italic%2C900italic&#038;ver=4.2.2' type='text/css' media='all' />
		<script type='text/javascript' src='jscript/jquery-1.11.2.min.js'></script>
		<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
		<script type='text/javascript' src='images/bbcode.js'></script>
		<script src="assets/js/DataTableTheme.js"></script>
		<script src="assets/js/jquery.simplyscroll.js"></script>
		<!--[if lt IE 9 ]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
		<style>
			#featured-img-1 {
				background-image: url(images/photos/1.png);
			}
			#featured-img-2 {
				background-image: url(images/photos/4.png);
			}
			#featured-img-3 {
				background-image: url(images/photos/3.png);
			}
			#featured-img-4 {
				background-image: url(images/photos/2.png);
			}
		</style>
	</head>
	<!--<body class="no-slider">-->
	<body class="has-top-menu<?php if($page != 'accueil') echo ' no-slider'; ?>"><div id="bodyneigeanimOff">
	
	<div class="wrapper">
	<div id="fb-root"></div>
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/fr_FR/sdk.js#xfbml=1&version=v2.3&appId=281948501912672";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>
		<!-- BEGIN #slider-imgs -->
		<div id="slider-imgs" style="background-color:white;">
			<div class="featured-img-box">
				<div id="featured-img-1" class="featured-img"></div>
				<div id="featured-img-2" class="featured-img invisible"></div>
				<div id="featured-img-3" class="featured-img invisible"></div>
				<div id="featured-img-4" class="featured-img invisible"></div>
			</div>
		<!-- END #slider-imgs -->
		</div>
	</div>