<?php

declare(strict_types=1);

namespace app\Mappers;

use app\core\Mapper;
use app\core\Model;
use app\models\User;

class UserMapper extends Mapper
{
    private \PDOStatement|false $update;
    private \PDOStatement|false $delete;
    private \PDOStatement|false $insert;
    private \PDOStatement|false $select;
    private \PDOStatement|false $selectAll;

    public function __construct()
    {
        parent:: __construct();
        $this->update = $this->getPdo()->prepare("UPDATE usr SET first_name = :first_name, age = :age WHERE id = :id");
        $this->delete = $this->getPdo()->prepare("DELETE FROM usr WHERE id = :id");
        $insertSql = "INSERT INTO usr (first_name, age) VALUES (:first_name, :age)";
        $this->insert = $this->getPdo()->prepare($insertSql);
        $this->select = $this->getPdo()->prepare("SELECT * FROM usr WHERE id = :id");
        $this->selectAll = $this->getPdo()->prepare("SELECT * FROM usr");
    }

    protected function doInsert(Model $object): Model
    {
        $this->insert->execute(
            [
                'first_name' => $object->getFirstName(),
                'age' => $object->getAge()
            ]
        );


        $rowId = $this->getPdo()->lastInsertId();
        $object->setId((int) $rowId);
        return $object;
    }

    protected function doUpdate(Model $object): void
    {
        try {
            $this->update->execute(
                [
                    'id' => $object->getId(),
                    'first_name' => $object->getFirstName(),
                    'age' => $object->getAge()
                ]
            );
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

    protected function doDelete(Model $object): void
    {
        $this->delete->execute(['id' => $object->getId()]);
    }

    protected function doCreateObject(array $object): Model
    {
        return new User($object['first_name'], (int) $object['age'], $object['id']);
    }

    protected function select(): \PDOStatement
    {
        return $this->select;
    }

    protected function selectAll(): \PDOStatement
    {
        return $this->selectAll;
    }

    protected function getMapperInstance(): Mapper
    {
        return $this;
    }
}