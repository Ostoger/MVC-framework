<?php

declare(strict_types=1);

namespace app\core;

class Collection
{
    private array $rows;
    private int $count;
    private Mapper $mapper;
    private array $objects = [];

    /**
     * @param array $rows
     * @param Mapper $mapperInstance
     */
    public function __construct(array $rows, Mapper $mapperInstance)
    {
        $this->rows = $rows;
        $this->count = count($rows);
        $this->mapper = $mapperInstance;
    }

    public function getNextRow(): \Generator
    {
        for ($i = 0; $i < $this->count; $i++) {
            $object = $this->getRow($i);
            yield $object;
        }
    }

    private function getRow(int $rowNumber): ?Model
    {
        if ($rowNumber > $this->count) {
            return null;
        }

        if (isset($this->objects[$rowNumber])) {
            return $this->objects[$rowNumber];
        }

        if (isset($this->rows[$rowNumber]))
            return $this->mapper->createObject($this->rows[$rowNumber]);

        return null;
    }
}