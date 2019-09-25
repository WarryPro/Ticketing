<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class NbreTickets extends Constraint
{
    /*
     * Any public properties become valid options for the annotation.
     * Then, use these in your validator class.
     */
    public $message = 'Vous ne pouvez pas réserver "{{ value }}" ticket(s) pour le jour selectionné car le nombre de tickets valables pour ce jour serait dépassé.';
}
