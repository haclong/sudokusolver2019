<?php

namespace Sudoku\Domain\Event;

use DateTime;
use DateTimeZone;
use Sudoku\Infra\Dto\DTOinterface;

/**
 * Description of GameCreated
 *
 * @author haclong
 */
class GameCreated {
    private $dto ;
    private $name = Event::GAME_CREATED ;
    private $id ;
    private $datetime ;
    
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
    
    public function id()
    {
        return $this->id ;
    }
    
    public function datetime()
    {
        return $this->datetime ;
    }
    
    public function generateEvent()
    {
        $timezone = new DateTimeZone('UTC') ;
        $date = new DateTime("now", $timezone) ;
        $this->datetime = $date ;
        $this->id = uniqid() ;

        return $this ;
    }
    
}

