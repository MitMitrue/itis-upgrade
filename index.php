<?php
ini_set('display_errors',1);
ini_set('error_reporting',2047);
function dump($data) {
    echo "<pre>";
    var_dump($data);
    echo "</pre>"; 
    exit;
}


session_start();
require_once ('config/init.php');


$router = new Router();
$router->run();