<?php
namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

/**
 * @Annotation
 */
class RepeatPassword extends Constraint
{
    public $message = 'Les mots de passe ne correspondent pas';
    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
