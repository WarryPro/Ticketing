<?php
/**
 * Created by PhpStorm.
 * User: danny
 * Date: 23/07/2019
 * Time: 23:17
 */

namespace App\Validator;

use Symfony\Component\Validator\Constraint;


/**
 * @Annotation
 */
class TicketType extends Constraint
{
    /*
     * Any public properties become valid options for the annotation.
     * Then, use these in your validator class.
    */
    public $message = "Vous ne pouvez pas réserver un billet Journée après 14h00";
}