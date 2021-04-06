<?php

namespace KCS\Services\Validator\Constraints;
use KCS\Exceptions\ValidationException;


class IsStringConstraint implements ConstraintInterface
{
    public function isValid($fieldValue, $fieldName = ''): bool {
        if (!preg_match("/^[a-zA-Z-' ]*$/", $fieldValue)) {
            throw new ValidationException("field '$fieldName' must contain only a-Z symbols or spaces");
        }
        return true;
    }
}
