<?php
/**
 * Created by PhpStorm.
 * User: danny
 * Date: 10/08/2019
 * Time: 01:09
 */

namespace App;

use App\Entity\Buyer;
use Stripe;


class StripeService
{
    public function stripePayment($token, $total) {

        \Stripe\Stripe::setApiKey("sk_test_4eC39HqLyjWDarjtT1zdp7dc");

        $charge = \Stripe\Charge::create([
            "amount" => $total,
            "currency" => "eur",
            "source" => $token, // obtained with Stripe.js
            "description" => "Billet online Musée du Louvre"
        ]);

        if($charge instanceof Stripe\Charge && $charge->paid === true) return true;
        return false;
    }
}