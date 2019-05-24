<?php
/*
 Inizio progetto
*/

/*
require_once('autoload.php');

$conf = new core\lib\class_config();


echo $conf::$db_server."<br>";
echo $conf::$db_name."<br>";
echo $conf::$db_user."<br>";

*/

$loader = require __DIR__."/vendor/autoload.php";

$conn = new \Costa\class_conn();
var_dump($conn);

$conf = new \Costa\class_config();

echo $conf::$db_server."<br>";
echo $conf::$db_name."<br>";
echo $conf::$db_user."<br>";