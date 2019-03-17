<?php	//	Genius Room: WYWO
		//	Script: Add a call
		//	Revision: 3.0.6

#	-----	You shouldn't be here if you aren't logged in.
#			NOTE: Added a "go" command so after login it redirects here.
if( !$_COOKIE['wywo_user'] ) { die( header( 'Location:./?area=crumbs&go=add' ) ); }

#	-----	The title text.
$title = ' - Add a Call';

#	-DOC-	The call injection. Checks that "save" was pressed.
#			The check for Magic Quotes is there due to different runtime environments.
if( $_POST['save'] ) {

// Employee name.			
	$employee = mysql_real_escape_string( $_COOKIE['wywo_user'] );

// Type of call. MQ check.
	$type = ( get_magic_quotes_gpc() || get_magic_quotes_runtime() ) ? $_POST['type'] : mysql_real_escape_string( $_POST['type'] );

// Customer name. MQ check.
	$customer = ( get_magic_quotes_gpc() || get_magic_quotes_runtime() ) ? ucwords( strtolower( $_POST['customer'] ) ) : mysql_real_escape_string( ucwords( strtolower( $_POST['customer'] ) ) );

// Checks that the repair number is 8-10 characters, otherwise it doesn't put one. MQ check.
	if( strlen( $_POST['repair'] ) == 8 || strlen( $_POST['repair'] ) == 9 || strlen( $_POST['repair'] ) == 10 ) { $repair = ( get_magic_quotes_gpc() || get_magic_quotes_runtime() ) ? strtoupper( $_POST['repair'] ) : mysql_real_escape_string( strtoupper( $_POST['repair'] ) ); }

// Removes superfluous characters from the numbers if necessary. MQ check.
	$primary = ( get_magic_quotes_gpc() || get_magic_quotes_runtime() ) ? strtoupper( clean_text( $_POST['primary'] ) ) : mysql_real_escape_string( strtoupper( clean_text( $_POST['primary'] ) ) );
	$secondary = ( get_magic_quotes_gpc() || get_magic_quotes_runtime() ) ? strtoupper( clean_text( $_POST['secondary'] ) ) : mysql_real_escape_string( strtoupper( clean_text( $_POST['secondary'] ) ) );

// If the numbers are the right length, cuts 1s off the front of phone numbers. Otherwise unsets them.
// Yeah, this is harsh.
	if( strlen( $primary ) == 7 || strlen( $primary ) == 10 || strlen( $primary ) == 11 ) { if( $primary[0] == 1 ) { $primary = ltrim( $primary, '1' ); } }
	else { unset( $primary ); }
	if( strlen( $secondary ) == 7 || strlen( $secondary ) == 10 || strlen( $secondary ) == 11 ) { if( $secondary[0] == 1 ) { $secondary = ltrim( $secondary, '1' ); } }
	else { unset( $secondary ); }

// Today.
	$timestamp = time();

// The note the employee entered. MQ check.
	$content = ( get_magic_quotes_gpc() || get_magic_quotes_runtime() ) ? $_POST['note'] : mysql_real_escape_string( $_POST['note'] );

// Inserts the call, gets the ID of the new call, then puts the note in.
	mysql_query( "INSERT INTO `calls` (`type`, `timestamp`, `customer`, `repair`, `primary`, `secondary`, `status`) VALUES ('" . $type . "', '" . $timestamp . "', '" . $customer . "', '" . $repair . "', '" . $primary . "', '" . $secondary . "', 'new')" );
	$callid = mysql_insert_id();
	mysql_query( "INSERT INTO `notes` (`call`, `timestamp`, `employee`, `content`) VALUES ('" . $callid . "', '" . $timestamp . "', '" . $employee . "', '" . $content . "')" );

// Optimize tables and redirect.
	mysql_query( "OPTIMIZE TABLE `calls`" );
	mysql_query( "OPTIMIZE TABLE `notes`" );
	die( header( 'Location:./' ) );

}

#	-----	This is the HTML in the page buffer.
#			I am aware that PHP has an OB built in. I don't like it.
$page[] = '		<form action="./?area=add" id="add" method="post">';
$page[] = '			<div id="add_info">';
$page[] = '				<span id="search_text">Did you search the full list to see if a call already exists?</span>';
$page[] = '				<span id="add_text">Enter as much information as you can. If there is an extension for the number, add it as part of the notes.</span>';
$page[] = '			</div>';
$page[] = '			<div id="add_type">';
$page[] = '				<input checked="checked" id="type_genius" name="type" type="radio" value="genius" /> <label for="type_genius" id="label_genius">Genius</label>';
$page[] = '				<input id="type_business" name="type" type="radio" value="business" /> <label for="type_business" id="label_business">Business</label>';
$page[] = '				<input id="type_manager" name="type" type="radio" value="manager" /> <label for="type_manager" id="label_manager">Manager</label>';
$page[] = '			</div>';
$page[] = '			<div class="add_line" id="add_name">';
$page[] = '				<label for="customer" id="label_customer">Customer Name:</label>';
$page[] = '				<input id="customer" name="customer" placeholder="Required" type="text" />';
$page[] = '			</div>';
$page[] = '			<div class="add_line" id="add_repair">';
$page[] = '				<label for="repair" id="label_repair">Repair #:</label>';
$page[] = '				<input id="repair" name="repair" placeholder="Optional" type="text" />';
$page[] = '			</div>';
$page[] = '			<div class="add_line" id="add_name">';
$page[] = '				<label for="primary" id="label_primary">Primary Phone:</label>';
$page[] = '				<input id="primary" name="primary" placeholder="Required" type="text" />';
$page[] = '			</div>';
$page[] = '			<div class="add_line" id="add_name">';
$page[] = '				<label for="secondary" id="label_secondary">Secondary Phone:</label>';
$page[] = '				<input id="secondary" name="secondary" placeholder="Optional" type="text" />';
$page[] = '			</div>';
$page[] = '			<div id="add_note">';
$page[] = '				<label for="note" id="label_note">Notes:</label>';
$page[] = '				<textarea id="note" name="note" placeholder="Required"></textarea>';
$page[] = '			</div>';
$page[] = '			<div id="add_buttons">';
$page[] = '				<input class="button" id="save" name="save" type="submit" value="Save" />';
$page[] = '				<input class="button" id="cancel" name="cancel" type="reset" value="Cancel" />';
$page[] = '			</div>';
$page[] = '		</form>';

		// Copyright: 2010 by Michael V. Colianna ?>