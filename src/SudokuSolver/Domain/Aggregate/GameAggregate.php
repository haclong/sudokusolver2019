<?php

namespace Sudoku\Domain\Aggregate;

use Sudoku\Infra\Dto\DTOinterface;

/**
 * Description of Game
 *
 * @author haclong
 */
class GameAggregate {
    private $dto ;
    private $id ;
    
    public function __construct(DTOinterface $dto)
    {
        $this->dto = $dto ;
    }
    
    public function dto()
    {
        return $this->dto ;
    }
    
    public function game()
    {
        return json_encode($this->dto->returnSelf($this->dto)) ;
    }
    
    public function init()
    {
        return $this->dto()->init() ;
    }
    
    public function id()
    {
        return $this->dto->id ;
    }
}