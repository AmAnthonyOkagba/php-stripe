<?php
require_once('vendor/autoload.php');

$stripe_secret_key = 'sk_test_4eC39HqLyjWDarjtT1zdp7dc';

$YOUR_DOMAIN = 'http://localhost/php%20stripe';

\Stripe\Stripe::setApiKey($stripe_secret_key);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    // Create a new Stripe Checkout session
    $session = \Stripe\Checkout\Session::create([
        'payment_method_types' => ['card'],
        'line_items' => [
            [
                'price_data' => [
                    'currency' => 'usd',
                    'unit_amount' => 1999,
                    'product_data' => [
                        'name' => 'Your Product Name',
                    ],
                ],
                'quantity' => 1,
            ],
        ],
        'mode' => 'payment',
        'success_url' => $YOUR_DOMAIN . '/success.html',
        'cancel_url' => $YOUR_DOMAIN . '/cancel.html',
        'customer_email' => $email,
        'metadata' => [
            'name' => $name,
            'message' => $message,
        ],
    ]);

    // Redirect to the Stripe Checkout page
    header("Location: " . $session->url);
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Stripe Payment Form</title>
</head>
<body>
    <h1>Stripe Payment Form</h1>
    <form method="POST" action="">
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" required>
        
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>
        
        <label for="message">Message:</label>
        <textarea name="message" id="message" required></textarea>
        
        <input type="submit" value="Submit">
    </form>
</body>
</html>
