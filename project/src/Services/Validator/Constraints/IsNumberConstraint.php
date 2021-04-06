<?php


namespace KCS\Services\Validator\Constraints;
use KCS\Exceptions\ValidationException;

class IsNumberConstraint implements ConstraintInterface
{
    public function isValid($fieldValue, $fieldName = ''): bool {
        if (!is_numeric($fieldValue)) {
            throw new ValidationException("field '$fieldName' must be a number");
        }
        return true;
    }
}