<?php	//	Genius Room: WYWO
		//	Script: Authentication page
		//	Revision: 3.0.6

#	-----	Log out if already logged in.
if (isset($_COOKIE['wywo_user']))
{
	setcookie('wywo_user', '');
    header('Location:./');
    exit();
}

#	-----	The title text.
$title = ' - Log In';

#	-----	This is to account for redirecting to the add page.
$add = ( $_GET['go'] == 'add' ) ? '&go=add' : '';

#	-DOC-	If the AJAX check worked, actually log in.
if (isset($_POST['login']))
{

// Check login again so the cookie can be made.
    if ($login = get_ldap(clean_text($_POST['username']), $_POST['password']))
    {

	// Account for the redirect.
		$go = ( $_GET['go'] == 'add' ) ? '?area=add' : '';

	// Log 'em in and redirect accordingly.
		setcookie( 'wywo_user', $login );
		setcookie( 'wywo_pass', $_POST['password'] );
        header('Location:./' . $go);
        exit();

// Redirect otherwise.
    }
    else
    {
        header('./?area=crumbs' . $add);
        exit();
    }

}

#	-----	This is the HTML in the page buffer.
#			I am aware that PHP has an OB built in. I don't like it.
$page[] = '		<form action="./?area=crumbs' . $add . '" id="login" method="post">';
$page[] = '			<div id="login_information">';
$page[] = '				<span id="information_text">Logging in requires you to have made your server account. If you haven\'t done this, please see one of the managers or a member of the Genius team.</span>';
$page[] = '			</div>';
$page[] = '			<div id="login_username">';
$page[] = '				<label for="username" id="label_username">Username:</label>';
$page[] = '				<input id="username" name="username" placeholder="Required" type="text" />';
$page[] = '			</div>';
$page[] = '			<div id="login_password">';
$page[] = '				<label for="password" id="label_password">Password:</label>';
$page[] = '				<input id="password" name="password" placeholder="Required" type="password" />';
$page[] = '			</div>';
$page[] = '			<div id="login_go">';
$page[] = '				<input class="button" id="login_button" name="login" type="submit" value="Log In" />';
$page[] = '			</div>';
$page[] = '		</form>';

		// Copyright: 2010 by Michael V. Colianna ?>