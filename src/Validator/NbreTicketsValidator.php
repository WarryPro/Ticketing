<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use App\Repository\BuyerRepository;

class NbreTicketsValidator extends ConstraintValidator
{
    private $buyerRepository;

    public function __construct(BuyerRepository $buyerRepository)
    {
        $this -> buyerRepository = $buyerRepository;
    }

    public function validate($value, Constraint $constraint)
    {
        /* @var $constraint \App\Validator\NbreTickets */

        $dateVisite = $this->context->getObject()->getDateVisite();
        $nombreTicketsJourVisite = $this->buyerRepository->getNbrTickets($dateVisite);

        if (($value + $nombreTicketsJourVisite) > 1000) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $nombreTicketsJourVisite)
                ->addViolation();
        }
    }
}
