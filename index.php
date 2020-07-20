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

$products = $food;
if (isset($_GET['food'])) {
    $products = $drinks;
}

$totalValue = 0;

/* Store form values in session var */
$errorMsg = '';
$errors = [];
$fields = [];
if( $_SERVER['REQUEST_METHOD'] === 'POST' ){
    foreach($_POST as $field => $value) {
        if (empty($field)) {
            $errors['$field'] = 'Fill out '.$field.'<br>';
            $errorMsg = $errors['$field'];
        } else {
            if (!is_string($value)) {
                $_SESSION['fields']['field'] = $value;
            } else {
                $_SESSION['fields']['field'] = testInput($value);
            }

        }
    }
}
// input testing trim (whitespace, tabs), strip lashes and html tags
function testInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
/* Function used in html - provides previous value or empty string */
function fieldvalue($field = false)
{
    return ($field && !empty($field) && isset($_SESSION['formfields']) && array_key_exists($field, $_SESSION['formfields'])) ? $_SESSION['formfields'][$field] : '';
}

    //calculate delivery time
    $now = new DateTime();
    if (isset($_POST['express-delivery'])) {
        $now->add(new DateInterval('PT45M'));
        $stamp = $now->format('Y-m-d H:i');
    } else {
        $now->add(new DateInterval('PT120M'));
        $stamp = $now->format('Y-m-d H:i');
    }






//validate input data

whatIsHappening();

//require 'fields.php';
require 'form-view.php';