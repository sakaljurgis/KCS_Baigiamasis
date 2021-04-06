<?php

namespace KCS\Services;

use KCS\ValidationRules\ValidationRulesInterface;
use KCS\Dtos\DtoInterface;
use KCS\Exceptions\ValidationException;
use KCS\Services\Validator\ConstraintFactory;

class RequestValidator
{
    private const REQUIRED_FIELD_NAME = 'required';
    public function validate(ValidationRulesInterface $validationRules): bool
    {

        $requestPayload = $_POST;
        
        $rules = $validationRules->getRules();
        $rules2 = $rules;
        $requiredFields = $this->extractRequiredFields($rules2);
        
        foreach ($requiredFields as $fieldName) {
            if (!isset($requestPayload[$fieldName])){
                throw new ValidationException("field '$fieldName' is mandatory");
            }
        }
        
        foreach ($rules2 as $fieldName => $fieldRules) {
            
            if (!isset($requestPayload[$fieldName])){
                continue;
            }
            
            $fieldValue = $requestPayload[$fieldName];
            
            foreach ($fieldRules as $rule) {
                ConstraintFactory::make($rule)->isValid($fieldValue, $fieldName);
            }
            
        }
        
        return true;
        
    }
    
    private function extractRequiredFields(array &$rules): array {
        
        $requiredFields = [];
        
        foreach ($rules as $fieldName => $fieldRules) {
            
            if (in_array(self::REQUIRED_FIELD_NAME, $fieldRules)) {
                $requiredFields[] = $fieldName;
                $index = array_search(self::REQUIRED_FIELD_NAME, $fieldRules);
                unset($rules[$fieldName][$index]);
            }
            
        }
        
        return $requiredFields;
        
    }
    
}
