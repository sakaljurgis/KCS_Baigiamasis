<?php


namespace KCS\Manager;


class ProductsManager
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

    public function store(ProductDto $dto): ModelInterface
    {
        return $this->repository->storeAndReturn($dto->toArray());
    }

    public function getProduct($id)
    {
        return $this->repository->one($id);
    }

}