<?php

namespace Sudoku\Domain\Command;

/**
 * Description of SetCase
 *
 * @author haclong
 */
class SetTile implements CommandInterface {
    public $payload ;
    
    public function __construct(GridIndex $row,
                                GridIndex $col,
                                $value)
    {
        $this->payload['row'] = $row ;
        $this->payload['col'] = $col ;
        $this->payload['value'] = $value ;
    }
}
