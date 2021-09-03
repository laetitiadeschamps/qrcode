<?php 
namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class RepeatPasswordValidator extends ConstraintValidator
{
  
   
    public function validate($object, Constraint $constraint)
    {
        if (!$constraint instanceof RepeatPassword) {
            throw new UnexpectedTypeException($constraint, RepeatPassword::class);
        }
      
        // custom constraints should ignore null and empty values to allow
        // other constraints (NotBlank, NotNull, etc.) to take care of that
        if (null === $object || '' === $object) {
            return;
        }

      
        if ($object->getPassword() !== $object->getPasswordConfirm()) {
            // the argument must be a string or an object implementing __toString()
            $this->context->buildViolation($constraint->message)
                ->atPath('password')
                ->addViolation();
        }
    }
}
