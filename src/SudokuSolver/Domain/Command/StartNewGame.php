<?php

namespace Sudoku\Domain\Command;

/**
 * Description of StartNewGame
 *
 * @author haclong
 */
class StartNewGame implements CommandInterface {
    public function __construct($guid, $gridSize)
    {
        $this->payload['guid'] = $guid ;
        $this->payload['gridSize'] = $gridSize ;
    }
}
