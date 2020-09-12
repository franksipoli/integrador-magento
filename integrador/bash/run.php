#!/usr/bin/env php
<?php

// convert all the command line arguments into a URL
$argv           = $GLOBALS['argv'];
array_shift($GLOBALS['argv']);
$pathInfo       = '/' . implode('/', $argv);

$app = require '../app/bootstrap/start.php';
ini_set("DISPLAY_ERRORS",1);
error_reporting(E_ALL ^E_NOTICE);

// Set up the environment so that Slim can route
$app->environment = Slim\Environment::mock([
    'PATH_INFO'   => $pathInfo
]);


// run!
$app->run();

