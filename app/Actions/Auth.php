<?php

namespace Wywo\Actions;

class Auth
{
    public static function login ()
    {
        if ( !isset( $_COOKIE['wywo_user'], $_COOKIE['wywo_pass'] ) )
        {
    		setcookie( 'wywo_user', 'Developer' );
	    	setcookie( 'wywo_pass', 'password' );
        }
    }

    public static function logout ()
    {
        setcookie( 'wywo_user', '' );
        setcookie( 'wywo_pass', '' );
    }

    public static function getUsername ()
    {
        return ( isset( $_COOKIE['wywo_user'] ) ) ? $_COOKIE['wywo_user'] : null;
    }
}
