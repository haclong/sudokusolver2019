<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

return function (App $app) {
    $container = $app->getContainer();

    $app->get('/Game', Sudoku\Infra\Controller\GameController::class . ':startAction')->setName('game.start');

    $app->post('/Game', Sudoku\Infra\Controller\GameController::class . ':loadAction')->setName('game.load');
    
    $app->get('/Grid', Sudoku\Infra\Controller\GridController::class . ':createAction')->setName('grid.create');

    $app->post('/Grid', Sudoku\Infra\Controller\GridController::class . ':composeAction')->setName('grid.compose') ;

    $app->post('/Grid/save', Sudoku\Infra\Controller\GridController::class . ':saveAction')->setName('grid.save') ;


    $app->get('/', function (Request $request, Response $response, array $args) use ($container) {
        // Sample log message
        $container->get('logger')->info("Slim-Skeleton '/' route");

        // Render index view
        return $container->get('renderer')->render($response, 'index.phtml', $args);
    })->setName('home');


//
//    $app->get('/[{name}]', function (Request $request, Response $response, array $args) use ($container) {
//        // Sample log message
//        $container->get('logger')->info("Slim-Skeleton '/' route");
//
//        // Render index view
//        return $container->get('renderer')->render($response, 'index.phtml', $args);
//    });


};




// // Routes

// $app->get('/debug', function (Request $request, Response $response, array $args) {
//     // Sample log message
//     $this->logger->info("Slim-Skeleton '/debug' route");

//     // Render index view
//     $grid = ['grid' => 'konichiwa'] ;

//     return $response->withJson($grid) ;
// //    return $this->renderer->render($grid, 'debug.phtml', $args);
// });

// $app->get('/new', Sudoku\Infra\Controller\SaveNewGridController::class . ':newAction');

// $app->post('/new', Sudoku\Infra\Controller\SaveNewGridController::class . ':saveAction');



