<?php
/**
 * Created by PhpStorm.
 * User: danny
 * Date: 10/08/2019
 * Time: 01:09
 */

namespace App\Service;

use App\Entity\Buyer;
use Stripe;


class StripeService
{
    public function stripePayment($total, $token) {

        \Stripe\Stripe::setApiKey("sk_test_gmnVOhvq1HZO22IGBuRaCeqy00IRR2WwN0");

        $charge = \Stripe\Charge::create([

            "amount" => $total*100,
            "currency" => "eur",
            "source" => $token, // obtained with Stripe.js
            "description" => "Billet online Musée du Louvre",
        ]);


        if($charge instanceof Stripe\Charge && $charge->paid === true) return true;
        return false;
    }
}