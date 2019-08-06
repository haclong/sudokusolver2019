<?php

use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Slim\App;
use Slim\Views\PhpRenderer;
use Sudoku\Domain\Command\CreateGame;
use Sudoku\Domain\Entity\Tile;
use Sudoku\Domain\Entity\Grid;
use Sudoku\Infra\CommandHandler\CreateGameHandler;
use Sudoku\Infra\Dto\CreateGameDTO;
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
    
    // event manager (zend)
    $container['eventmanager'] = function ($c) {
        return new EventManager() ;
    };
    
    // command handlers
    $container['creategamehandler'] = function ($c) {
        $handler = new CreateGameHandler() ;
        $handler->attach($c->get('eventmanager')) ;
        return $handler ;
    };
    
    // commands
    $container['creategame'] = function ($c) {
        $dto = new CreateGameDTO() ;
        return new CreateGame($dto) ;
    };
    
    // entities
    $container['grid'] = function ($c) {
        return new Grid() ;
    } ;
    $container['tile'] = function ($c) {
        return new Tile() ;
    } ;
};
