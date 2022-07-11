<?php

declare(strict_types=1);

namespace app\core;

abstract class Mapper
{
    private \PDO $pdo;

    public function __construct()
    {
        $this->pdo = Application::$app->db->pdo;
    }

    public function insert(Model $object): Model
    {
        return $this->doInsert($object);
    }

    public function update(Model $object): void
    {
        $this->doUpdate($object);
    }

    public function delete(Model $object): void
    {
        $this->doDelete($object);
    }

    public function find(int $id): ?Model
    {
        $this->select()->execute(['id' => $id]);
        $row = $this->select()->fetch();

        if (!is_array($row)) {
            return null;
        }

        if (!isset($row['id'])) {
            return null;
        }

        return $this->doCreateObject($row);
    }

    public function findAll(): Collection
    {
        $this->selectAll()->execute();
        $rows = $this->selectAll()->fetchAll();

        return new Collection($rows, $this->getMapperInstance());
    }


    public function createObject(array $object): Model
    {
        return $this->doCreateObject($object);
    }

    /**
     * @return \PDO
     */
    public function getPdo(): \PDO
    {
        return $this->pdo;
    }

    /**
     * @param \PDO $pdo
     */
    public function setPdo(\PDO $pdo): void
    {
        $this->pdo = $pdo;
    }

    abstract protected function doInsert(Model $object): Model;
    abstract protected function doUpdate(Model $object): void;
    abstract protected function doDelete(Model $object): void;
    abstract protected function doCreateObject(array $object): Model;
    abstract protected function select(): \PDOStatement;
    abstract protected function selectAll(): \PDOStatement;
    abstract protected function getMapperInstance(): Mapper;

}