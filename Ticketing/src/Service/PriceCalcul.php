<?php
/**
 * Created by PhpStorm.
 * User: danny
 * Date: 15/08/2019
 * Time: 23:50
 */

namespace App\Service;

use App\Entity\Buyer;
use App\Entity\Price;


class PriceCalcul
{
    /**
     * @param Buyer $reservation
     * @return int
     * @throws \Exception
     */
    public function priceCalcul(Buyer $reservation) {

        $tarifTotal = 0;

        foreach ($reservation -> getTickets() as $ticket) {
            $age = $ticket -> getDateNaissance() -> diff(new \DateTime()) -> format('%Y');
            $reduction = $ticket -> getReduction();

            $tarif = 0;

            if($age >= 4) {
                if($age < 12) {
                    $tarif = 8;
                }elseif ($reduction === true) {
                    $tarif = 10;
                }elseif ($age > 60) {
                    $tarif = 12;
                }else {
                    $tarif = 16;
                }
            }
            $ticket -> setTarif($tarif);
            $tarifTotal += $tarif;
        }
        dump( $tarifTotal);
        return $tarifTotal;
    }


}