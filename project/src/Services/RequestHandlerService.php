<?php

namespace KCS\Services;
use KCS\Model\ModelInterface;
use KCS\Dtos\DtoInterface;
//use KCS\Dtos\VisitorDto;

class RequestHandlerService {
    
    public function getModelDto(string $dto): DtoInterface
    {
        $requestPayload = $_POST;
        
        $dtoFields = get_class_vars($dto);

        $modelDto = new $dto();
        
        foreach ($dtoFields as $key => $value) {
            if (isset($requestPayload[$key])) {
                $modelDto->$key = $requestPayload[$key];
            }
        }
        
        return $modelDto;
    }
    
    
    
}
