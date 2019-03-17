<?php

mysql_connect( 'localhost', 'wywo', 'r122!wywo' );
mysql_select_db( 'wywo' );

function clean_text( $str ) {
	$cleanup = array( ' ', '/', '-', '.' );
	return strtolower( str_replace( $cleanup, '', $str ) );
}

function get_device() {
	$user_agent = explode( '/', $_SERVER['HTTP_USER_AGENT'] );
	$software = explode( ';', $user_agent[1] );
	$device = explode( '(', $software[0] );
	return $device[1];
}

function get_domain() {
	$from = explode( ':', $_SERVER['SERVER_ADDR'] );
	if( $from[5] == '24c9' ) {
		if( $_SERVER['REMOTE_ADDR'] == 'fe80::61e:64ff:feec:346d' ) { return 'boh'; }
		else { return 'foh'; }
	}
	else { return 'boh'; }
}

function get_ldap( $uid, $pw ) {
	$ldap = ldap_connect( 'geniusroom.local' );
	ldap_set_option( $ldap, LDAP_OPT_PROTOCOL_VERSION, 3 );
	$search = ldap_search( $ldap, 'cn=users,dc=geniusroom,dc=local', 'uid=' . clean_text( $uid ) );
	$person = ldap_first_entry( $ldap, $search );
	$dn = ldap_get_dn( $ldap, $person );
	$bind = ldap_bind( $ldap, $dn, $pw );
	$info = ldap_get_entries( $ldap, $search );
	if( $bind ) { echo( $info[0]['cn'][0] ); }
}

?>