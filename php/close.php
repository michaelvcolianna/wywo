<?php	//	Genius Room: WYWO
		//	Script: Close out a call
		//	Revision: 3.0.6

#	-----	You shouldn't be here if you aren't logged in.
if( !$_COOKIE['wywo_user'] ) { die( header( 'Location:./?area=crumbs' ) ); }

#	-DOC-	The removal script.
if( is_numeric( $_GET['id'] ) ) {

// The call ID.
	$call = mysql_fetch_assoc( mysql_query( "SELECT * FROM `calls` WHERE `id`='" . $_GET['id'] . "'" ) );

// Employee who closed the call.
	$employee = mysql_real_escape_string( $_COOKIE['wywo_user'] );
	$password = $_COOKIE['wywo_pass'];

// Get employee info to see if the person is allowed to remove calls.
	$user = get_ldap( $employee, $password );

// Don't let regular employees remove calls. This is a backup in case they traverse the URL.
	if( strpos( $user[0]['apple-user-printattribute'][0], 'ALL' ) == FALSE ) { die( header( 'Location:./' ) ); }

// Starts the 'info' block with the primary number.
	$info = mysql_real_escape_string( phone_text( $call['primary'] ) );

// Adds the secondary number if it's there.
	if( $call['secondary'] ) { $info.= ' / ' . mysql_real_escape_string( phone_text( $call['secondary'] ) ); }

// Adds the repair number if it's there.
	if( $call['repair'] ) { $info.= ' / ' . mysql_real_escape_string( $call['repair'] ); }

// Pulls the notes, loops through them, and puts them in a block.
	$notes_pull = mysql_query( "SELECT * FROM `notes` WHERE `call`='" . $call['id'] . "'" );
	while( $note = mysql_fetch_assoc( $notes_pull ) ) { $notes.= mysql_real_escape_string( date( 'm/d/Y', $note['timestamp'] ) ) . ' at ' . mysql_real_escape_string( date( 'g:ia', $note['timestamp'] ) ) . ' by ' . mysql_real_escape_string( $note['employee'] ) . ': ' . mysql_real_escape_string( str_replace( "\n", '', $note['content'] ) ) . "\n"; }

//	Insert the closed call into the archive, delete it, and delete all notes associated with it.
	mysql_query( "INSERT INTO `archive` (`opened`, `closed`, `employee`, `type`, `customer`, `info`, `notes`) VALUES ('" . $call['timestamp'] . "', '" . time() . "', '" . $employee . "', '" . mysql_real_escape_string( $call['type'] ) . "', '" . mysql_real_escape_string( $call['customer'] ) . "', '" . $info . "', '" . $notes . "')" );
	mysql_query( "DELETE FROM `calls` WHERE `id`='" . $call['id'] . "'" );
	mysql_query( "DELETE FROM `notes` WHERE `call`='" . $call['id'] . "'" );

}

#	-----	Optimize tables and redirect.
mysql_query( "OPTIMIZE TABLE `archive`" );
mysql_query( "OPTIMIZE TABLE `calls`" );
mysql_query( "OPTIMIZE TABLE `notes`" );
die( header( 'Location:./' ) );

		// Copyright: 2010 by Michael V. Colianna ?>