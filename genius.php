<?php	//	Genius Room: Root
		//	Script: Genius Room common functions
		//	Revision: 1.1.2

$mysqli = new mysqli('localhost', 'root', 'universe', 'concierge');
if ($mysqli->connect_error)
{
    $error = [
        'MySQLi connect error (',
        $mysqli->connect_errno,
        '): ',
        $mysqli->connect_error
    ];
    throw new Exception(implode('', $error));
}

#	-----	Removes unwanted characters from text.
function clean_text( $str ) {
	$cleanup = array( ' ', '/', '-', '.', "'", '"', '(', ')' );
	return strtolower( str_replace( $cleanup, '', $str ) );
}

#	-----	Reformats a phone number into a pleasing display.
function phone_text($str)
{
    if (!empty($str))
    {
        $phone = str_split($str, 3);
        if (count($phone) == 4)
        {
            return '(' . $phone[0] . ') ' . $phone[1] . '-' . $phone[2] . $phone[3];
        }
        else
        {
            return $phone[0] . '-' . $phone[1] . $phone[2];
        }
    }
    else
    {
        return '???';
    }
}

#	-----	Splits the user agent text up and discovers what kind of device is being used.
function get_device() {
	$user_agent = explode( '/', $_SERVER['HTTP_USER_AGENT'] );
	$software = explode( ';', $user_agent[1] );
	$device = explode( '(', $software[0] );
	return $device[1];
}

#	-----	Determines the network being used based on the MAC address.
#			I'm quite proud of this one.
function get_domain() {
	$from = explode( ':', $_SERVER['SERVER_ADDR'] );
	if( $from[5] == '24c9' ) {
		if( $_SERVER['REMOTE_ADDR'] == 'fe80::61e:64ff:feec:346d' ) { return 'boh'; }
		else { return 'foh'; }
	}
	else { return 'boh'; }
}

#	-DOC-	This turns LDAP authentication into easy business:
#			if( $login = get_ldap( 'user', 'pass' ) ) { $auth = TRUE; }
#			I'm even more proud of this one.
function get_ldap( $uid, $pw ) {

// After connecting, you have to set the version to 3.
	$ldap = ldap_connect( 'geniusroom.local' );
	ldap_set_option( $ldap, LDAP_OPT_PROTOCOL_VERSION, 3 );

// Searches based on the entered username and then stores the user info.
// This works best if the UID passed is "cleaned" via the function above.
	$search = ldap_search( $ldap, 'cn=users,dc=geniusroom,dc=local', 'uid=' . clean_text( $uid ) );
	$info = ldap_get_entries( $ldap, $search );

// In order to bind properly, the "distinguished name" (DN) is needed.
// This gets the DN and then tries to bind with the supplied password.
// Getting the DN is redundant in *most* cases, but not all.
	$person = ldap_first_entry( $ldap, $search );
	$dn = ldap_get_dn( $ldap, $person );
	$bind = ldap_bind( $ldap, $dn, $pw );

// If the bind was successful, that means the user authenticated properly.
// The "relative distinguished name" (CN) is the employee's proper name.
// NOTE: The 'else' line below can be uncommented for guaranteed login.
	#if( $bind ) { return $info[0]['cn'][0]; }
	#else { return 'WYWO Developer'; }
	if( $bind ) { return $info; }

}

		// Copyright: 2010 by Michael V. Colianna ?>
