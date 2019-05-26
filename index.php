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

$conn = new \Costaplus\ClassConn();
var_dump($conn);

$conf = new \Costaplus\ClassConfig();
/*
echo $conf::$db_server."<br>";
echo $conf::$db_name."<br>";
echo $conf::$db_user."\n";
*/

$engine1 = new \Costaplus\Inheritance\Engine('2000','100Hpr');
$engine2 = new \Costaplus\Inheritance\Engine('5000', '300Hpr');


// composition by constructor
$car = new \Costaplus\Inheritance\Car($engine1);

// composition by setter
$truck = new \Costaplus\Inheritance\Truck();
$truck->setEngine($engine2);

/**
 * @param \Costaplus\Inheritance\Automobile $automobile
 * @return string
 */
$playSound = function(\Costaplus\Inheritance\Automobile $automobile){
    echo get_class($automobile)."\n";
    return $automobile->playSound()."\n";
};

echo $playSound($car);
echo $playSound($truck);

echo $car->start()."\n";
echo $truck->start()."\n";
