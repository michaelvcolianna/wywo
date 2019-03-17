<?php	//	Genius Room: WYWO
		//	Script: WYWO common functions
		//	Revision: 3.0.6

#	-----	Connection to the SQL database.
mysql_connect( 'localhost', 'wywo', 'r122!wywo' );
mysql_select_db( 'wywo' );

#	-----	Cache control for Snow Leopard server.
header( 'Cache-Control: no-cache, must-revalidate' );
header( 'Expires: Sat, 26 Jul 1997 05:00:00 GMT');

#	-----	Gets the tallies for the types of calls.
$all_calls = mysql_num_rows( mysql_query( "SELECT * FROM `calls`" ) );
$genius_calls = mysql_num_rows( mysql_query( "SELECT * FROM `calls` WHERE `type`='genius'" ) );
$business_calls = mysql_num_rows( mysql_query( "SELECT * FROM `calls` WHERE `type`='business'" ) );
$manager_calls = mysql_num_rows( mysql_query( "SELECT * FROM `calls` WHERE `type`='manager'" ) );

#	-----	The text for the "login/logout" link.
if( $_COOKIE['wywo_user'] ) { $crumbs = 'Log Out (' . $_COOKIE['wywo_user'] . ')'; }
else { $crumbs = 'Log In'; }

		// Copyright: 2010 by Michael V. Colianna ?>