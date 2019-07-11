<?php

namespace Sudoku\Domain\Entity\In;

use Sudoku\Domain\Entity\Contrat\GridToSaveInterface;

/**
 * Description of NewGrid
 *
 * @author haclong
 */
class NewGridToSave implements GridToSaveInterface {
    private $grid ;
    private $size ;
    
    public function __construct(array $grid, int $size) {
        echo count($grid) ;
        $this->checkGridSize($grid, $size) ;
        $this->grid = $grid ;
        $this->size = $size ;
    }

    public function mapGrid() {
        return $this->grid ;
    }

    private function checkGridSize($grid, $size)
    {
        if(count($grid) != $size)
        {
            throw new GridToSaveSizeInvalidException() ;
        }
        else
        {
            foreach($grid as $row => $cols)
            {
                if(count($row) != $size)
                {
                    throw new GridToSaveSizeInvalidException() ;
                }
            }
        }
    }
}
