<?php
declare(strict_types=1);

/* Store form values in session var */
$errorMsg = '';
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($_POST as $field => $value) {
        if (empty($field)) {
            $errorMsg = 'Fill out ' . $field . '<br>';
        }
        $_SESSION['formfields']['field'] = trim(stripslashes($value));
    }
    //calculate delivery time
    $now = new DateTime();
    if (isset($_GET['express-delivery'])) {
        $now->add(new DateInterval('PT45M'));
        $stamp = $now->format('Y-m-d H:i');
    } else {
        $now->add(new DateInterval('PT120M'));
        $stamp = $now->format('Y-m-d H:i');
    }
}

/* Function used in html - provides previous value or empty string */
function fieldvalue($field = false)
{
    return ($field && !empty($field) && isset($_SESSION['formfields']) && array_key_exists($field, $_SESSION['formfields'])) ? $_SESSION['formfields'][$field] : '';
}
