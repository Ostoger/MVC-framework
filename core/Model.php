<?php

declare(strict_types=1);

namespace app\core;

abstract class Model
{
    private int $id;

    /**
     * @param int|null $id
     */
    public function __construct(int $id = null)
    {
        if ($id !== null) {
            $this->id = $id;
        }
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }
}