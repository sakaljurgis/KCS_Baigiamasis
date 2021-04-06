<?php

namespace KCS\Model;

abstract class BaseModel implements ModelInterface
{
    protected int $id;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}