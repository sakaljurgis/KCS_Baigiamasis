<?php

namespace KCS\Repository;

use Exception;
use KCS\DbConnect as DB;
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

    public function storeAndReturn($params): ModelInterface
    {
        $table = $this->getTableName();

        $status = $this->store($params, $table);

        if ($status) {
            return $this->getLastInsertedVisitor($table);
        }
        throw new RuntimeException('Gote some error when storing record');
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
    private function getLastInsertedVisitor(string $table)
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
}