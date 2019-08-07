<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class CloseDay extends Constraint
{
    /*
     * Any public properties become valid options for the annotation.
     * Then, use these in your validator class.
     */
    public $tuesday = 'Le musée est fermé les mardis.';
    public $closed = 'Le musée est fermé ce jour-là.';
    public $after14h = 'Vous ne pouvez pas acheter un billet journée après 14h00';
}
