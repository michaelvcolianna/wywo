<?php	//	Genius Room: WYWO
		//	Script: LDAP for AJAX
		//	Revision: 3.0.6

#	-----	This is the LDAP file that jQuery uses for its AJAX call.
#			First loads common functions.
#require('genius.php');

#	-----	Had to put defaults or OpenDirectory goes nuts.
#$uid = ( $_GET['u'] ) ? $_GET['u'] : 'wywo';
#$pw = ( $_GET['p'] ) ? $_GET['p'] : 'wywo';

#	-----	Output the login attempt.
#if( $login = get_ldap( $uid, $pw ) ) { echo( $login[0]['cn'][0] ); }
#echo( get_ldap( $uid, $pw ) );
echo 'WYWO Developer';

		// Copyright: 2010 by Michael V. Colianna ?>