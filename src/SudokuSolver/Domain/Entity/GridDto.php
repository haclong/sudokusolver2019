<?php

namespace Sudoku\Domain\Entity;

/**
 * Description of GridDto
 *
 * @author haclong
 */
class GridDto {
    protected $grid ;
    
    public function __construct($grid)
    {
        $this->grid ;
    }
    
    public function get()
    {
        return [
                '0' => [
                    '0' => 0,
                    '1' => 1,
                    '2' => 2,
                    '3' => 3
                ],
                '1' => [
                    '0' => '',
                    '1' => 0,
                    '2' => 3,
                    '3' => 1,
                ]
            
        ];
        return $this->grid ;
    }
}
