<?php
declare(strict_types=1);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

//we are going to use session variables so we need to enable sessions
session_start();

function whatIsHappening() {
    echo '<h2>$_GET</h2>';
    var_dump($_GET);
    echo '<h2>$_POST</h2>';
    var_dump($_POST);
    echo '<h2>$_COOKIE</h2>';
    var_dump($_COOKIE);
    echo '<h2>$_SESSION</h2>';
    var_dump($_SESSION);
}

//your products with their price.
$food = [
    ['name' => 'Club Ham', 'price' => 3.20],
    ['name' => 'Club Cheese', 'price' => 3],
    ['name' => 'Club Cheese & Ham', 'price' => 4],
    ['name' => 'Club Chicken', 'price' => 4],
    ['name' => 'Club Salmon', 'price' => 5]
];

$drinks = [
    ['name' => 'Cola', 'price' => 2],
    ['name' => 'Fanta', 'price' => 2],
    ['name' => 'Sprite', 'price' => 2],
    ['name' => 'Ice-tea', 'price' => 3],
];

//set pages for displaying food or drinks
$products = $food;
if ($_GET['food'] === '0') {
    $products = $drinks;
}

//Store form values in SESSION
$errorMsg = '';
$errors = [];
if( $_SERVER['REQUEST_METHOD'] === 'POST' ){
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Enter valid email';
    }
    foreach($_POST as $field => $value) {
        if (empty($_POST[$field])) {
            $errors[$field] = 'Fill out '.$field;
        } else if ($field !== 'products' && $field !== 'express') {
            $value = trim(htmlspecialchars($value));
            $_SESSION[$field] = $value;
        }
    }
}

//calculate delivery time
$stamp = 0;
$now = new DateTime();
if (isset($_POST['express'])) {
    $now->add(new DateInterval('PT45M'));
    $stamp = $now->format('H:i d-m-Y');
} else {
    $now->add(new DateInterval('PT120M'));
    $stamp = $now->format('H:i d-m-Y');
}

//calculate price of order
$totalValue = 0;
if (isset($_POST['products'])) {
    var_dump($_POST['products']);
    $orderIndexes = array_intersect_key(array_keys($_POST['products']), array_keys($products));

    foreach ($_POST['products'] as $i => $product) {

            $totalValue += (float)$product['price'];
            var_dump($totalValue);
        }
    }
    if (!empty($_POST['express'])) {
        $totalValue += (float)$_POST['express'];
    }
    var_dump($totalValue);


whatIsHappening();

//require 'fields.php';
require 'form-view.php';