<?php

use GuzzleHttp\Client;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Slim\App;
use Slim\Views\PhpRenderer;
use Sudoku\Domain\Aggregate\GameAggregate;
use Sudoku\Domain\Command\CreateGame;
use Sudoku\Domain\Entity\Grid;
use Sudoku\Domain\Entity\Tile;
use Sudoku\Domain\Event\GameCreated;
use Sudoku\Infra\Adapter\EventStoreAdapter;
use Sudoku\Infra\CommandHandler\GameCommandHandler;
use Sudoku\Infra\Dto\CreateGameDTO;
use Sudoku\Infra\Dto\GameAggregateDTO;
use Sudoku\Infra\Dto\GameCreatedDTO;
use Zend\EventManager\EventManager;

return function (App $app) {
    $container = $app->getContainer();

    // view renderer
    $container['renderer'] = function ($c) {
        $settings = $c->get('settings')['renderer'];
        $renderer = new PhpRenderer($settings['template_path']) ;
        $renderer->addAttribute('router', $c->get('router'));
        return $renderer ;
    };

    // monolog
    $container['logger'] = function ($c) {
        $settings = $c->get('settings')['logger'];
        $logger = new Logger($settings['name']);
        $logger->pushProcessor(new UidProcessor());
        $logger->pushHandler(new StreamHandler($settings['path'], $settings['level']));
        return $logger;
    };
    
    // filesystem (flysystem)
    $container['filesystem'] = function ($c) {
        $adapter = new Local(__DIR__.'/../datas/') ;
        return new Filesystem($adapter) ;
    };
    
    // persistance event store
    $container['eventstore'] = function ($c) {
        $client = new Client([
                        'base_uri' => 'http://127.0.0.1:2113/streams/',
                        'headers' => ['Accept' => 'application/json']
        ]) ;
        return new EventStoreAdapter($client) ;
    }; 
    
    // event manager (zend)
    $container['eventmanager'] = function ($c) {
        return new EventManager() ;
    };
    
    // command handlers
    $container['gamecommandhandler'] = function ($c) {
        $handler = new GameCommandHandler() ;
        $handler->attach($c->get('eventmanager')) ;
        $handler->setEventManager($c->get('eventmanager')) ;
        $handler->setAggregate($c->get('gameaggregate')) ;
        $handler->setEvents(['gamecreated' => $c->get('gamecreated')]) ;
        return $handler ;
    };
    
    // commands
    $container['creategame'] = function ($c) {
        $dto = new CreateGameDTO() ;
        return new CreateGame($dto) ;
    };
    
    // aggregate
    $container['gameaggregate'] = function ($c) {
        $dto = new GameAggregateDTO() ;
        return new GameAggregate($dto) ;
    };
    
    // event
    $container['gamecreated'] = function ($c) {
        $dto = new GameCreatedDTO() ;
        return new GameCreated($dto) ;
    } ;
    
    // entities
    $container['grid'] = function ($c) {
        return new Grid() ;
    } ;
    $container['tile'] = function ($c) {
        return new Tile() ;
    } ;
};
