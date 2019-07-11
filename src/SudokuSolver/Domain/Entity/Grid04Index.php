<?php

namespace Sudoku\Domain\Entity;

use Sudoku\Domain\Exception\InvalidGridIndexException;

/**
 * Description of Grid4Index
 *
 * @author haclong
 */
class Grid04Index extends GridIndex {
    protected $size = 4 ;
    
    public function __construct($index, $gridSize)
    {
        $this->validateSize($gridSize) ;
        
        if($index > 3)
        {
            throw new InvalidGridIndexException () ;
        }
        $this->index = $index ;
    }
}
