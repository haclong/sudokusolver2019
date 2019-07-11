<?php

namespace Sudoku\Domain\Entity;

/**
 * Description of GridSize
 *
 * @author haclong
 */
class GridSize {
    protected $size ;
    
    public function __construct($size)
    {
        $this->size = $size ;
    }
    
    public function get()
    {
        return $this->size ;
    }
}
