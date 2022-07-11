<?php

declare(strict_types=1);

namespace app\models;

use app\core\Model;

class User extends Model
{
    private int $age;
    private string $firstName;

    public function __construct(string $firstName, int $age, int $id = null)
    {
        parent:: __construct($id);
        $this->firstName = $firstName;
        $this->age = $age;
    }

    /**
     * @return int
     */
    public function getAge(): int
    {
        return $this->age;
    }

    /**
     * @param int $age
     */
    public function setAge(int $age): void
    {
        $this->age = $age;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }
}