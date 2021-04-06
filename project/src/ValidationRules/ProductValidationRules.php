<?php


namespace KCS\ValidationRules;


class ProductValidationRules  implements ValidationRulesInterface
{
    public function getRules(): array
    {
        return [
            'name' => ['required', 'max:50'],
            'description' => ['max:255'],
            'price' => ['number'],
            'quantity' => ['number']
        ];
    }
}