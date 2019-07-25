<?php
/**
 * Created by PhpStorm.
 * User: danny
 * Date: 23/07/2019
 * Time: 23:23
 */

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;


class TicketTypeValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        /* @var $constraint App\Validator\TicketType */
        // TODO: Implement validate() method.
        $dateVisite = $this->context->getObject()->getDateVisite();
        $dateReservation = $this->context->getObject()->getDateReservation();
        $dateVisite->setTime(14, 00); // L'heure dans laquelle on ne peut pas acheter ticket journée

//        si ticketType = Journée
        if($value === 0) {
            if($dateVisite->format('d-m-Y') === $dateReservation->format('d-m-Y')) {
                $this->context->buildViolation($constraint->message)->addViolation();
            }
        }
    }
}