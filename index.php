<?php

define('ROOT_DIR', __DIR__);
require_once ROOT_DIR . '/vendor/autoload.php';

$Wywo = new \Wywo\Core();
$Wywo->handleActions();
$Wywo->setTemplate();
$Wywo->setVariables();

echo $Wywo->render();
