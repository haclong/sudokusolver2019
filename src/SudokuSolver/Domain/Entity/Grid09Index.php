<?php

namespace Sudoku\Domain\Entity;

use Sudoku\Domain\Exception\InvalidGridIndexException;

/**
 * Description of Grid9Index
 *
 * @author haclong
 */
class Grid09Index extends GridIndex {
    protected $size = 9 ;
    
    public function __construct($index, $gridSize)
    {
        $this->validateSize($gridSize) ;
        
        if($index > 8)
        {
            throw new InvalidGridIndexException() ;
        }
        $this->index = $index ;
    }
}
