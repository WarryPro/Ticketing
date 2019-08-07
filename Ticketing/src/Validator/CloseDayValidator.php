<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;


class CloseDayValidator extends ConstraintValidator
{
    public function validate($date, Constraint $constraint)
    {
        /* @var $constraint \App\Validator\CloseDay */
//        $util = new \Checkdomain\Holiday\Util();
////        La date en châine de characteres
//        $date = date_format($date, 'd-m-Y');
//
//
//        //Jours fériés
//        $holiday = $util->getHoliday('FR', $date);


        $dateVisite = $date->format('d-m');

        $reservationDate = new \DateTime();
        $reservationHour = $reservationDate->format('H-i');

        // Jour de la semaine
        $day = date("l", $date->getTimestamp());

        $closedDays = ['01-05', '01-11', '25-12'];


        if($day === "Tuesday") {
            $this->context->addViolation($constraint->tuesday);
        }
        if (in_array($dateVisite, $closedDays)) {
            $this->context->addViolation($constraint->closed);
        }
        if ($reservationDate->format('d-m') === $date->format('d-m') && $reservationHour > '13-59') {

            $this->context->addViolation($constraint->after14h);
        }


    }
}
