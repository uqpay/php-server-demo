<?php
include "core/vendor/autoload.php";
$whoops = new \Whoops\Run;
$options = new \Whoops\Handler\PrettyPageHandler();
$whoops->pushHandler($options);
$whoops->register();
ini_set('display_errors', 'On');