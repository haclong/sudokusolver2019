<?php

namespace Sudoku\Domain\Entity;

use Sudoku\Domain\Exception\GridIndexAndGridSizeNotMatchException;

/**
 * Description of GridIndex
 *
 * @author haclong
 */
class GridIndex {
    protected $index ;
    protected $size ;
    
    protected function validateSize($gridSize)
    {
        if($gridSize != $this->size)
        {
            throw new GridIndexAndGridSizeNotMatchException() ;
        }
    }
   
    public function __toString()
    {
        return $this->get() ;
    }

    public function get() {
        return $this->index ;
    }
}
