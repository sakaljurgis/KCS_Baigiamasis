<?php

namespace KCS\Manager;

use KCS\Model\ProductModel;
use KCS\Repository\ProductsRepository;
use KCS\Dtos\ProductDto;

class ProductManager
{

    private ProductsRepository $repository;

    public function __construct(ProductsRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAllProducts(): array
    {
        return $this->repository->all();
    }

    public function store(ProductDto $dto): ProductModel
    {
        return $this->repository->storeAndReturn($dto->toArray());
    }

    public function getProduct($id): ProductModel
    {
        return $this->repository->one($id);
    }

    public function update($id, ProductDto $dto): ProductModel
    {
        return $this->repository->updateAndReturn($id, $dto->toArray());
    }

    public function delete($id): bool
    {
        return $this->repository->delete($id);
    }

}