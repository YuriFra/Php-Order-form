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
if (isset($_GET['drinks'])) {
    $products = $drinks;
}
if (isset($_GET['both'])) {
    $products = array_merge($food, $drinks);
}

//store valid form values in SESSION
$errors = [];
if( $_SERVER['REQUEST_METHOD'] === 'POST' ){
    foreach($_POST as $field => $value) {
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Enter valid email';
            $_POST['email'] = '';
        }
        if (empty($_POST[$field])) {
            $errors[$field] = 'Fill out '.$field;
        } else if ($field !== 'products' && $field !== 'express') {
            $value = trim(htmlspecialchars($value));
            $_SESSION[$field] = $value;
        }
    }
}

//calculate delivery time
$deliTime = 0;
$now = new DateTime();
if (isset($_POST['express'])) {
    $now->add(new DateInterval('PT45M'));
} else {
    $now->add(new DateInterval('PT120M'));
}
$deliTime = $now->format('H:i d-m-Y');

//calculate price of order
$orderValue = 0;
if (isset($_POST['products'])) {
    foreach ($_POST['products'] as $i => $product) {
        $orderValue += (float)$product;
    }
}
if (!empty($_POST['express'])) {
    $orderValue += (float)$_POST['express'];
}

//calculate total price of orders, store in COOKIE
$totalValue = 0;
$cookie_name = 'orders';
$cookie_value = $totalValue;
if (isset($_COOKIE['orders'])) {
    $totalValue = $_COOKIE['orders'];
    $totalValue += $orderValue;
}
setcookie($cookie_name, (string)$totalValue, time() + (60), "/");  //cookie expires after 1 month (86400 * 30)

if (isset($_COOKIE['orders'])) {
    unset($_COOKIE['orders']);
    setcookie('orders', '', time() - 3600, '/'); // empty value and old timestamp
}

$fullForm = !empty($_SESSION['email']) & !empty($_SESSION['street']) & !empty($_SESSION['streetnumber']) & !empty($_SESSION['city']) & !empty($_SESSION['zipcode']) & isset($_POST['products']);

whatIsHappening();

require 'form-view.php';
//require 'mail.php';