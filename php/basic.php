<?php	//	Genius Room: WYWO
		//	Script: WYWO common functions
		//	Revision: 3.0.6

#	-----	Cache control for Snow Leopard server.
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');

#	-----	Gets the tallies for the types of calls.
$all_calls = mysqli_num_rows($mysqli->query("SELECT * FROM `calls`"));
$genius_calls = mysqli_num_rows($mysqli->query("SELECT * FROM `calls` WHERE `type`='genius'"));
$business_calls = mysqli_num_rows($mysqli->query("SELECT * FROM `calls` WHERE `type`='business'"));
$manager_calls = mysqli_num_rows($mysqli->query("SELECT * FROM `calls` WHERE `type`='manager'"));

#	-----	The text for the "login/logout" link.
if (isset($_COOKIE['wywo_user']))
{
    $crumbs = 'Log Out (' . $_COOKIE['wywo_user'] . ')';
}
else
{
    $crumbs = 'Log In';
}

		// Copyright: 2010 by Michael V. Colianna ?>