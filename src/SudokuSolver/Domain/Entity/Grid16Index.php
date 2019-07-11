<?php

namespace Sudoku\Domain\Entity;

use Sudoku\Domain\Exception\InvalidGridIndexException;

/**
 * Description of Grid16Index
 *
 * @author haclong
 */
class Grid16Index extends GridIndex {
    protected $size = 16 ;
    
    public function __construct($index, $gridSize)
    {
        $this->validateSize($gridSize) ;
        
        if($index > 15)
        {
            throw new InvalidGridIndexException() ;
        }
        $this->index = $index ;
    }
}
