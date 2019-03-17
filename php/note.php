<?php	//	Genius Room: WYWO
		//	Script: Add a note to a call
		//	Revision: 3.0.6

#	-----	You shouldn't be here if you aren't logged in.
if( !$_COOKIE['wywo_user'] ) { die( header( 'Location:./?area=crumbs' ) ); }

#	-DOC-	If a note was entered AND the call ID is valid
if( $_POST['add'] && is_numeric( $_GET['id'] ) ) {

// Employee putting the note in.
	$employee = mysql_real_escape_string( $_COOKIE['wywo_user'] );
	$password = $_COOKIE['wywo_pass'];

// Get employee info to see if we update the call status.
	$user = get_ldap( $employee, $password );

// Call ID.
	$callid = mysql_real_escape_string( $_GET['id'] );

// Today.
	$timestamp = time();

// The note itself. MQ check.
	$content = ( get_magic_quotes_gpc() || get_magic_quotes_runtime() ) ? $_POST['note'] : mysql_real_escape_string( $_POST['note'] );

// Insert the note into the call.
	mysql_query( "INSERT INTO `notes` (`call`, `timestamp`, `employee`, `content`) VALUES ('" . $callid . "', '" . $timestamp . "', '" . $employee . "', '" . $content . "')" );

// If the person is a WYWO admin, update the status.
	if( strpos( $user[0]['apple-user-printattribute'][0], 'ALL' ) != FALSE ) { mysql_query( "UPDATE `calls` SET `status`='old' WHERE `id`='" . $callid . "'" ); }

}

#	-----	Optimize tables and redirect.
mysql_query( "OPTIMIZE TABLE `notes`" );
mysql_query( "OPTIMIZE TABLE `calls`" );
die( header( 'Location:./' ) );

		// Copyright: 2010 by Michael V. Colianna ?>