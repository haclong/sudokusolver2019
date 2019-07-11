<?php

namespace Sudoku\Domain\Entity;

use Sudoku\Domain\Exception\InvalidGridIndexException;

/**
 * Description of Grid25Index
 *
 * @author haclong
 */
class Grid25Index extends GridIndex {
    protected $size = 25 ;
    
    public function __construct($index, $gridSize)
    {
        $this->validateSize($gridSize) ;
        
        if($index > 24)
        {
            throw new InvalidGridIndexException() ;
        }
        $this->index = $index ;
    }
}
