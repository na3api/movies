<?php 
    error_reporting(E_ALL | E_STRICT);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);

function p($arr, $die = false) {
    echo '<pre>';
    print_r($arr);
    echo '</pre>';
    if ($die)
        die('die');
}

try{
    require __DIR__ . "/../core/app.php";
    require __DIR__ . "/../vendor/autoload.php";
    App::getInstance()->start();
} catch (Exception $ex) {
    throw new Exception($ex->getFile() . ':' . $ex->getLine() . ': '. $ex->getMessage());        
}