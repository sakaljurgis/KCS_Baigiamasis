<?php
namespace KCS\Controller;

use KCS\Dtos\ProductDto;
use KCS\Manager\ProductManager;
use KCS\Model\ProductModel;
use KCS\Services\RequestHandlerService;
use KCS\Services\RequestValidator;
use KCS\ValidationRules\ProductValidationRules;

class ProductController extends BaseController
{
    private ProductManager $manager;

    public function __construct(ProductManager $manager, RequestHandlerService $requestHandler, RequestValidator $requestValidator)
    {
        parent::__construct($requestHandler, $requestValidator);
        $this->manager = $manager;
    }

    public function index(): array
    {
        return $this->manager->getAllProducts();
    }

    public function show($args): ProductModel
    {
        $id = $args[0];
        return $this->manager->getProduct($id);
    }

    public function store()
    {
        $this->requestValidator->validate(new ProductValidationRules());
        $productDTO = $this->requestHandler->getModelDto(ProductDto::class);

        return $this->manager->store($productDTO);

        //$lankytojas = $this->manager->store($productDTO);
        //$addressDto = $this->requestHandler->getModelDto(AddressDto::class);
        //$address = $this->addressManager->getOrCreate($addressDto);
        //$lankytojas->setAddressId($address->getId());
        //$lankytojas = $this->manager->update($lankytojas);

    }

    public function update($args)
    {
        $productDTO = $this->requestHandler->getModelDto(ProductDto::class);
        $this->requestValidator->validate(new ProductValidationRules());
        $id = $args[0];
        return $this->manager->update($id, $productDTO);
    }

    public function delete($args): bool
    {
        $id = $args[0];
        return $this->manager->delete($id);
    }

}