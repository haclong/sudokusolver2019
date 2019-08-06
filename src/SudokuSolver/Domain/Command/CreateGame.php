<?php

namespace Sudoku\Domain\Command;

use Sudoku\Infra\Dto\DTOinterface;

/**
 * Description of CreateGame
 *
 * @author haclong
 */
//class CreateGrid implements CommandInterface {
class CreateGame {
    private $dto ;
    private $name = Command::CREATE_GAME ;
    
    public function __construct(DTOinterface $dto)
    {
        $this->dto = $dto ;
    }
    
    public function dto()
    {
        return $this->dto ;
    }
    
    public function payload()
    {
        return json_encode($this->dto->returnSelf($this->dto)) ;
    }
    
    public function name()
    {
        return $this->name ;
    }
}

