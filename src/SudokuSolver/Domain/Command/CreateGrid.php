<?php

namespace Sudoku\Domain\Command;

use Sudoku\Infra\Dto\DTOinterface;

/**
 * Description of CreateGrid
 *
 * @author haclong
 */
//class CreateGrid implements CommandInterface {
class CreateGrid {
    private $dto ;
    private $name = 'CreateGrid' ;
    
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
        return $this->dto->returnSelf($this->dto) ;
    }
}

