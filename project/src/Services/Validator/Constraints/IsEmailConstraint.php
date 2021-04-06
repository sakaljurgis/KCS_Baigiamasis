<?php

namespace KCS\Services\Validator\Constraints;
use KCS\Exceptions\ValidationException;

class IsEmailConstraint implements ConstraintInterface
{
    public function isValid($fieldValue, $fieldName = ''): bool {
        if (!filter_var($fieldValue, FILTER_VALIDATE_EMAIL)) {
            throw new ValidationException("field '$fieldName' must be a valid email address");
        }
        return true;
    }
}
