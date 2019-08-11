<?php

namespace Sudoku\Infra\CommandHandler ;

use DateTime;
use DateTimeZone;
use League\Flysystem\FilesystemInterface;
use Sudoku\Domain\Aggregate\GameAggregate;
use Sudoku\Domain\Command\Command;
use Sudoku\Domain\Event\Event;
use Zend\EventManager\EventInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;

class GameCommandHandler implements ListenerAggregateInterface
{
    private $eventStore ;
    protected $aggregate ;
    protected $eventManager ;
    private $listeners = [] ;
    private $events = [] ;
    
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
        // vérifier qu'un Game avec le même id n'existe pas déjà
        if($this->aggregateExists($e->getParams()->dto()->id))
        {
            var_dump("aggregate already exist") ;
        }
        else
        {
            // créer un nouvel game aggregat identifier par son id
            $this->aggregate->init() ;
            
            // créer l'événement
            $event = $this->events['gamecreated'] ;
            
            $event->dto()->id = $e->getParams()->dto()->id ;
            $event->dto()->size = $e->getParams()->dto()->size ;
            $event->dto()->createTime = $e->getParams()->dto()->createTime ;
            $event->generateEvent() ;
            
            $this->eventManager->trigger(Event::GAME_CREATED, $this, $event);
        }
    }
    
    public function setEventManager(EventManagerInterface $eventmanager)
    {
        $this->eventManager = $eventmanager ;
    }

    public function setAggregate(GameAggregate $aggregate)
    {
        $this->aggregate = $aggregate ;
    }

    public function setEventStore(FilesystemInterface $eventStore)
    {
        $this->eventStore = $eventStore ;
    }

    public function getEventStore()
    {
        return $this->eventStore ;
    }
    
    public function aggregateExists($id)
    {
        return $this->eventStore->has($id) ;
    }
    
    public function findAggregateById($id)
    {
        return $this->eventStore->read($id) ;
    }
    
    public function setEvents($events)
    {
        $this->events = $events ;
    }
}