<?php

namespace KCS\Repository;

use Exception;
use KCS\DbConnect as DB;
use KCS\Model\BaseModel;
use KCS\Model\ModelInterface;
use PDO;
use RuntimeException;

abstract class BaseRepository implements RepositoryInterface
{
    public const MODEL = null;

    private const DISABLED_WORDS = ['Repository'];

    public PDO $conn;

    public function __construct(DB $conn)
    {
        $this->conn = $conn->getConn();
    }

    public function all(): array
    {
        $table = $this->getTableName();
        $stmt = $this->conn->prepare("SELECT * FROM $table");
        $model = $this->getModelClass();
        $stmt->setFetchMode(PDO::FETCH_CLASS, $model);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function one($id): BaseModel
    {
        $table = $this->getTableName();
        $stmt = $this->conn->prepare("SELECT * FROM $table WHERE id = :id");
        $stmt->bindValue(":id", $id);
        $model = $this->getModelClass();
        $stmt->setFetchMode(PDO::FETCH_CLASS, $model);
        $stmt->execute();
        if ($stmt->rowCount()) {
            return $stmt->fetch();
        } else {
            throw new \Exception("Entry id '$id' not found");
        }
    }

    public function storeAndReturn($params): BaseModel
    {
        $table = $this->getTableName();

        $status = $this->store($params, $table);

        if ($status) {
            return $this->getLastInserted($table);
        }
        throw new RuntimeException('Got some error when storing record');
    }

    public function updateAndReturn($id, $params): BaseModel
    {
        $table = $this->getTableName();
        $status = $this->update($id, $params, $table);

        if ($status) {
            return $this->one($id);
        }
        throw new RuntimeException('Got some error when storing record');
    }

    protected function getTableName(): string
    {
        $nameSpace = get_class($this);

        if (defined($nameSpace.'::TABLE_NAME')) {
            return $nameSpace::TABLE_NAME;
        }

        $path = explode('\\', $nameSpace);
        $className = array_pop($path);
        $words = preg_split('/(?=[A-Z])/', $className);

        foreach ($words as $key => $word) {
            if (in_array($word, self::DISABLED_WORDS, true)) {
                unset($words[$key]);
            }
        }

        $loweredWords = array_map(
            static function ($string) {
                return strtolower($string);
            },
            $words
        );

        return substr(implode('_', $loweredWords), 1);
    }

    /**
     * @param  string  $table
     *
     * @return mixed
     * @throws Exception
     */
    private function getLastInserted(string $table)
    {
        $id = $this->conn->lastInsertId();
        $stmt = $this->conn->prepare("SELECT * FROM $table WHERE id = :id");
        $model = $this->getModelClass();
        $stmt->setFetchMode(PDO::FETCH_CLASS, $model);
        $stmt->bindParam('id', $id);
        $stmt->execute();

        return $stmt->fetch();
    }

    public function getModelClass(): string
    {
        $modelName = get_class($this)."::MODEL";
        if (defined($modelName) && !is_null(get_class($this)::MODEL)) {
            return get_class($this)::MODEL;
        }

        throw new Exception('Repository missing MODEL constant');
    }

    /**
     * @param          $params
     * @param  string  $table
     *
     * @return bool
     */
    public function store($params, string $table): bool
    {
        $paramNames = array_keys($params);

        $sql = "INSERT INTO $table(".implode(',', $paramNames).") VALUES(:".implode(', :', $paramNames).")";
        $stmt = $this->conn->prepare($sql);
        foreach ($params as $key => $value) {
            $stmt->bindValue(':'.$key, $value);
        }
        $status = $stmt->execute();
        return $status;
    }

    public function update($id, $params, string $table): bool
    {
        //$paramNames = array_keys($params);
        //$sql = "UPDATE products SET name = :name, sku = :sku WHERE id = :id;";
        $parameters = [];
        foreach ($params as $key => $value) {
            $parameters[] = "$key = :$key";
        }
        $sql = "UPDATE $table SET ". implode(", ", $parameters) ." WHERE id = :id;";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':id', $id);
        foreach ($params as $key => $value) {
            $stmt->bindValue(':'.$key, $value);
        }
        $status = $stmt->execute();
        return $status;
    }

    public function delete($id): bool
    {
        $table = $this->getTableName();
        $sql = "DELETE FROM `$table` WHERE id = :id;";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':id', $id);
        return $stmt->execute();
    }

}