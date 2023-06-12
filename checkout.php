<?php

require_once 'vendor/autoload.php';
// require_once 'secrets.php';

$stripeSecretKey = 'sk_test_4eC39HqLyjWDarjtT1zdp7dc';

\Stripe\Stripe::setApiKey($stripeSecretKey);
header('Content-Type: application/json');

$YOUR_DOMAIN = 'http://localhost/php%20stripe';

$stripe = new \Stripe\StripeClient('sk_test_4eC39HqLyjWDarjtT1zdp7dc');

$stripe->paymentIntents->create([
    'amount' => 1099,
    'currency' => 'usd',
    'automatic_payment_methods' => ['enabled' => true],
]);
$checkout_session = \Stripe\Checkout\Session::create([
  'line_items' => [[
    # Provide the exact Price ID (e.g. pr_1234) of the product you want to sell
    'price' => '100',
    'quantity' => 1,
  ]],
  'mode' => 'payment',
  'success_url' => $YOUR_DOMAIN . '/success.html',
  'cancel_url' => $YOUR_DOMAIN . '/cancel.html',
]);

header("HTTP/1.1 303 See Other");
header("Location: " . $checkout_session->url);