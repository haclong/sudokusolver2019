<?php

declare(strict_types=1);

namespace Sudoku\Domain\Repository;

interface GridRepositoryInterface
{
    public function save(Grid $grid): void;
    public function get(string $id): ?Grid;
}