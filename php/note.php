<?php	//	Genius Room: WYWO
		//	Script: Add a note to a call
		//	Revision: 3.0.6

#	-----	You shouldn't be here if you aren't logged in.
if (!isset($_COOKIE['wywo_user']))
{
    header('Location:./?area=crumbs');
    exit();
}

#	-DOC-	If a note was entered AND the call ID is valid
if (isset($_POST['add']) && isset($_GET['id']) && is_numeric($_GET['id']))
{

// Employee putting the note in.
	$employee = $mysqli->real_escape_string($_COOKIE['wywo_user']);
	$password = $_COOKIE['wywo_pass'];

// Get employee info to see if we update the call status.
	$user = get_ldap( $employee, $password );

// Call ID.
	$callid = $mysqli->real_escape_string($_GET['id']);

// Today.
	$timestamp = time();

// The note itself. MQ check.
	$content = $_POST['note'];

// Insert the note into the call.
	$mysqli->query("INSERT INTO `notes` (`call`, `timestamp`, `employee`, `content`) VALUES ('" . $callid . "', '" . $timestamp . "', '" . $employee . "', '" . $content . "')");

// If the person is a WYWO admin, update the status.
    if (strpos($user[0]['apple-user-printattribute'][0], 'ALL' ) != FALSE)
    {
        $mysqli->query("UPDATE `calls` SET `status`='old' WHERE `id`='" . $callid . "'");
    }

}

#	-----	Optimize tables and redirect.
$mysqli->query("OPTIMIZE TABLE `notes`");
$mysqli->query("OPTIMIZE TABLE `calls`");
header('Location:./');
exit();

		// Copyright: 2010 by Michael V. Colianna ?>