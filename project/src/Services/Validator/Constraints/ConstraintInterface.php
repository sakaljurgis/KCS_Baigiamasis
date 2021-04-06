<?php

namespace KCS\Services\Validator\Constraints;

interface ConstraintInterface
{
    public function isValid($fieldValue, $fieldName): bool;
}
