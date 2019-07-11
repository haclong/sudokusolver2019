<?php

namespace Sudoku\Domain\Entity\Contrat;

/**
 * Description of GridToSaveInterface
 *
 * @author haclong
 */
interface GridToSaveInterface {
    public function __construct(array $grid, int $size) ;
    public function mapGrid() ;
}
