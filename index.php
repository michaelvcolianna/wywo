<?php

define('ROOT_DIR', __DIR__);
require_once ROOT_DIR . '/vendor/autoload.php';

$loader = new \Twig\Loader\FilesystemLoader(ROOT_DIR . '/views/templates');
$twig = new \Twig\Environment($loader, [
    'auto_reload' => true,
    'cache' => ROOT_DIR . '/views/cache',
    'debug' => true,
]);
$twig->addExtension(new \Twig\Extension\DebugExtension());

// die('<pre>' . print_r($_SERVER, true) . '</pre>');

$vars = [
    'title' => 'All Calls',
    'all_calls' => 27,
    'genius_calls' => 15,
    'business_calls' => 8,
    'manager_calls' => 4,
    'page' => [],
    'logged_in' => false,
];

echo $twig->render('index.html.twig', $vars);

    	//	Genius Room: WYWO
		//	Script: Main index page
		//	Revision: 3.0.6

#	-----	Load functions common to all GR Server apps.
#			Then kick out front of house and mobile devices.
// require('genius.php');

#	-----	Load basic WYWO functions.
// require('php/basic.php');

#	-----	Load the requested area or redirect if it is fake.
// if (!file_exists('./php/' . $_GET['area'] . '.php'))
// {
//     header('Location:./?area=view');
//     exit();
// }
// require('php/' . $_GET['area'] . '.php');

        // Copyright: 2010 by Michael V. Colianna
