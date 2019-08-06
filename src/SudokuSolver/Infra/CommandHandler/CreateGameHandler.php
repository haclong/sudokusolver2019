<?php

namespace Sudoku\Infra\CommandHandler ;

use Sudoku\Domain\Command\Command;
use Zend\EventManager\EventInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;

/* 
 */

class CreateGameHandler implements ListenerAggregateInterface
{
    private $listeners = [] ;
    
    public function attach(EventManagerInterface $events, $priority=1)
    {
        $this->listeners[] = $events->attach(Command::CREATE_GAME, [$this, 'createGame'], $priority) ;
    }
    
    public function detach(EventManagerInterface $events)
    {
        foreach($this->listeners as $index => $listener) {
            $events->detach($listener) ;
            unset($this->listeners[$index]);
        }
    }
    
    public function createGame(EventInterface $e)
    {
        $event  = $e->getName();
        $params = $e->getParams();
//        var_dump($params) ;
        printf(
            'Handled event "%s" on target '.__CLASS__.', with parameters %s',
            $event,
            $params->payload()
        );
    }
}