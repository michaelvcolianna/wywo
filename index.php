<?php	//	Genius Room: WYWO
		//	Script: Main index page
		//	Revision: 3.0.6
ini_set('display_errors', true);
#	-----	Load functions common to all GR Server apps.
#			Then kick out front of house and mobile devices.
require('genius.php');

#	-----	Load basic WYWO functions.
require('php/basic.php');

#	-----	Load the requested area or redirect if it is fake.
if( !file_exists( './php/' . $_GET['area'] . '.php' ) ) { die( header( 'Location:./?area=view' ) ); }
require('php/' . $_GET['area'] . '.php');

		// Copyright: 2010 by Michael V. Colianna ?>
<!DOCTYPE html PUBLIC "-//W3C//TD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<link href="./css/wywo.css" rel="stylesheet" type="text/css" />
	<link href="./css/<?php echo( $_GET['area'] ); ?>.css" rel="stylesheet" type="text/css" />
	<meta content="text/html; charset=utf-8" http-equiv="content-type" />
	<script src="./js/jquery.js" type="text/javascript"></script>
	<script src="./js/gr.js" type="text/javascript"></script>
	<title>While You Were Out<?php /* Adds the title text. */ echo( $title ); ?></title>
</head>
<body>

<div id="wrapper">
	<div id="title">
		<span id="title_text">While You Were Out<?php /* Adds the title text. */ echo( $title ); ?></span>
	</div>
	<div id="navigation">
		<a href="./?area=view" id="link_all">View All (<?php echo( $all_calls ); ?>)</a>
		<a href="./?area=view&view=genius" id="link_genius">View Genius (<?php echo( $genius_calls ); ?>)</a>
		<a href="./?area=view&view=business" id="link_business">View Business (<?php echo( $business_calls ); ?>)</a>
		<a href="./?area=view&view=manager" id="link_manager">View Manager (<?php echo( $manager_calls ); ?>)</a>
		<a href="./?area=add" id="link_add">Add a Call</a>
	</div>
	<div id="body">
<?php /* Loops through the page buffer and outputs it. */ foreach( $page as $value ) { echo( $value . "\n" ); } ?>
	</div>
	<div id="links">
		<a href="./?area=crumbs" id="link_crumbs"><?php /* Outputs the text for the crumbs page. */ echo( $crumbs ); ?></a>
		<a href="../" id="link_return">Back to Genius Room</a>
		<a href="./" id="link_main">Main WYWO Page</a>
	</div>
	<div id="info">
		<span id="info_text">&copy; 2009 - 2010 by Michael V. Colianna - <a href="./?area=archive" id="link_archive">Call Archive</a></span>
	</div>
</div>

</body>
</html>