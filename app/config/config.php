<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'pizzapalace');

define('APPROOT', dirname(dirname(__FILE__)));
define('ROOT', dirname(dirname(dirname(__FILE__))));


// Zet hier je virtualhostnaam. Let op dat er http:// voor staat anders werkt het niet
define('URLROOT', 'http://localhost/pizzapalacebackend/');



$var['pool'] = array('_', '_', 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
$var['rand'] = $var['pool'][rand(2, 63)] . $var['pool'][rand(2, 63)] . $var['pool'][rand(2, 63)] . $var['pool'][rand(2, 63)];

$var['timestamp'] = time();

$productType = [
    'pizza' => 'Pizza',
    'drink' => 'Drink',
    'coupon' => 'Coupon', 
    'custompizza' => 'Custompizza', 
    'snack' => 'Snack'
];

$vehicleType = [
    'bike' => 'Bike',
    'car' => 'Car',
    'scooter' => 'Scooter'
];

$orderStatus = [
    'success' => 'Success',
    'pending' => 'Pending',
    'failed' => 'Failed'
];

$orderState = [
    'progress' => 'In Progress',
    'delivered' => 'Delivered',
    'on the way' => 'On the way',
    'canceled' => 'Canceled',
    'picked up' => 'Picked Up'
];
