<?php

namespace KCS\Repository;

use KCS\Model\ProductModel;
use PDO;

class ProductsRepository extends BaseRepository
{
    public const MODEL = ProductModel::class;
}