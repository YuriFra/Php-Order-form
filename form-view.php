<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" type="text/css" rel="stylesheet"/>
    <title>Order food & drinks</title>
</head>
<body>
<div class="container">
    <header>
        <h1 class="text-center my-3">Order food @ "The Personal Ham Processors"</h1>
    </header>

    <nav>
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link active" href="/">Order food</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="?drinks">Order drinks</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="?both">Order food & drinks</a>
            </li>
        </ul>
    </nav>

    <main>
        <form method="post">
            <!-- error messages -->
            <?php foreach ($errors as $errorMsg => $error) {
            echo '<div class="alert alert-danger">'.$errors[$errorMsg].'</div>';
            } ?>
            <!-- confirm order message -->
            <?php if ($fullForm) {
                echo '<div class="alert alert-primary text-center my-3" role="alert">Your order is confirmed.<br>Total price: <strong>&euro; ' . $orderValue . '</strong><br>Expected delivery time: <strong>' . $deliTime . '</strong><br>A confirmation email was sent.</div>'; } ?>
            <!-- email -->.
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="email">E-mail <span class="text-danger">*</span></label>
                    <input type="text" id="email" name="email" value="<?= $_SESSION['email'] ?? '' ?>" class="form-control">
                </div>
            </div>
            <!-- Address -->
            <fieldset>
                <legend>Address</legend>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="street">Street <span class="text-danger">*</span></label>
                        <input type="text" name="street" value="<?= $_SESSION['street'] ?? '' ?>" id="street" class="form-control">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="streetnumber">Street number <span class="text-danger">*</span></label>
                        <input type="number" id="streetnumber" name="streetnumber" value="<?php echo $_SESSION['streetnumber'] ?? '' ?>" class="form-control">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="city">City <span class="text-danger">*</span></label>
                        <input type="text" id="city" name="city" value="<?= $_SESSION['city'] ?? '' ?>" class="form-control">
                    </div>
                    <br>
                    <div class="form-group col-md-6">
                        <label for="zipcode">Zipcode <span class="text-danger">*</span></label>
                        <input type="number" id="zipcode" name="zipcode" value="<?= $_SESSION['zipcode'] ?? '' ?>" class="form-control">
                    </div>
                </div>
            </fieldset>
            <p><span class="error text-danger">* required field</span></p>
            <!-- Products -->
            <fieldset>
                <legend>Products <span class="text-danger">*</span></legend>
                <?php if (!isset($_POST['products'])) {
                    echo '<div class="alert alert-danger">Choose a product</div>';
                } ?>
                <?php foreach ($products as $i => $product): ?>
                    <label>
                        <input type="checkbox" value="<?= number_format($product['price'], 2) ?>"
                               name="products[<?php echo $i ?>]"> <?= $product['name'] ?> -
                        &euro; <?= number_format($product['price'], 2) ?>
                    </label><br/>
                <?php endforeach; ?>
            </fieldset>
            <br>
            <!-- Delivery -->
            <fieldset>
                <legend>Delivery</legend>
                <label>
                    <input type="checkbox" name="express" value="5">
                    Express delivery (+ 5 EUR)
                </label>
                <br>
            </fieldset>
            <br>
            <!-- Order -->
            <button type="submit" class="btn btn-primary">Order!</button>
        </form>
    </main>
    <footer>
        <!-- Track order in cookie -->
        <div class="alert alert-primary text-center my-3" role="alert">
            You already ordered <strong>&euro; <?php echo $totalValue ?></strong> in food and drinks.
        </div>
    </footer>
</div>

</body>
</html>