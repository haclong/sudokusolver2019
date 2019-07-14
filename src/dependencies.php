<?php

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Slim\App;
use Slim\Views\PhpRenderer;
use Sudoku\Domain\Command\CreateGrid;
use Sudoku\Domain\Command\Handler\CreateGridHandler;
use Sudoku\Infra\Dto\CreateGridDTO;
use Sudoku\Infra\Manager\SudokuEventManager;
use Zend\EventManager\EventManager;

return function (App $app) {
    $container = $app->getContainer();

    // view renderer
    $container['renderer'] = function ($c) {
        $settings = $c->get('settings')['renderer'];
        return new PhpRenderer($settings['template_path']);
    };

    // monolog
    $container['logger'] = function ($c) {
        $settings = $c->get('settings')['logger'];
        $logger = new Logger($settings['name']);
        $logger->pushProcessor(new UidProcessor());
        $logger->pushHandler(new StreamHandler($settings['path'], $settings['level']));
        return $logger;
    };
    
    // event manager (zend)
    $container['eventmanager'] = function ($c) {
        return new SudokuEventManager() ;
    };
    
    // command handlers
    $container['creategridhandler'] = function ($c) {
        $handler = new CreateGridHandler() ;
        $handler->attach($c->get('eventmanager')) ;
        return $handler ;
    };
    
    // commands
    $container['creategrid'] = function ($c) {
        $dto = new CreateGridDTO() ;
        return new CreateGrid($dto) ;
    };
    
};
