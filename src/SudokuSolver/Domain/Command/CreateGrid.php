<?php

namespace Sudoku\Domain\Command;

use Sudoku\Domain\Entity\Contract\CreateGridDTO;

/**
 * Description of CreateGrid
 *
 * @author haclong
 */
//class CreateGrid implements CommandInterface {
class CreateGrid {
    private $dto ;
    private $name = 'CreateGrid' ;
    private $payload ;
    
    public function __construct(CreateGridDTO $dto)
    {
        $this->dto = $dto ;
    }
    
    public function dto()
    {
        return $this->dto ;
    }
        
    public function payload()
    {
        return CreateGridDTO::export($this->dto) ; 
    }
}

