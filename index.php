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
if (!file_exists('./php/' . $_GET['area'] . '.php'))
{
    header('Location:./?area=view');
    exit();
}
require('php/' . $_GET['area'] . '.php');

		// Copyright: 2010 by Michael V. Colianna ?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, viewport-fit=cover">
        <title>While You Were Out<?= $title; ?></title>
        <link rel="stylsheet" href="/ui/dist/styles/app.css">
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
                <a href="/" id="link_main">Main WYWO Page</a>
            </div>
            <div id="info">
                <span id="info_text">&copy; 2009 - 2010 by Michael V. Colianna - <a href="./?area=archive" id="link_archive">Call Archive</a></span>
            </div>
        </div>

        <script src="/ui/dist/scripts/app.js"></script>
    </body>
</html>
