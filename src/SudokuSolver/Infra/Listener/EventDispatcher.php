<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class EventDispatcher implements ListenerAggregateInterface
{
    private $listeners = [] ;
    
    public function setCreateGridHandler($handler)
    {
        $this->createGridHandler = $handler ;
    }
    
    public function attach(EventManagerInterface $events, $priority=1)
    {
        $this->listeners[] = $events->attach(Command::CREATE_GRID, [$this->createGridHandler, 'createGrid'], $priority) ;
    }
    
    public function detach(EventManagerInterface $events)
    {
        foreach($this->listeners as $index => $listener) {
            $events->detach($listener) ;
            unset($this->listeners[$index]);
        }
    }
}