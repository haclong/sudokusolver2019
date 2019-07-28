<?php

namespace Sudoku\Infra\Controller;

use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;
use Sudoku\Domain\Entity\Level;
use Sudoku\Domain\Entity\Size;

/**
 * Description of GameController
 *
 * @author haclong
 */
class GameController {

    public function __construct(ContainerInterface $container) {
        $this->container = $container ;
    }

    public function startAction(Request $request, Response $response, array $args) {
        // sample log message
        $this->container->get('logger')->info("start Game") ;
        
        $args['size'] = [] ;
        $args['level'] = [] ;
        $files = $this->container->get('filesystem')->listContents('', true) ;
        
        foreach($files as $value)
        {
            if($value['type'] == 'dir')
            {
                if($value['path'] == $value['filename'])
                {
                    $args['size'][$value['path']] = $value['path'] ;
                }
                else
                {
                    $args['level'][$value['filename']] = $value['filename'] ;
                }
            }
        }

        return $this->container->get('renderer')->render($response, 'game/start.phtml', $args);
    }

    public function loadAction(Request $request, Response $response, array $args) {
        $this->container->get('logger')->info('load Sudoku game');

        $data = $request->getParsedBody() ;

//        $this->container->get('creategridhandler') ;
        $files = $this->container->get('filesystem')->listContents('', true) ;

        $flag = true ;
        while($flag == true)
        {
            $key = array_rand($files) ;
            if( $files[$key]['type'] == 'file')
            {
                $flag = false ;
                $gridpath = $files[$key]['path'] ;
                echo $gridpath ;
                $t = include('../datas/' . $gridpath) ;
                var_dump($t) ;
            }
        }

        $args['size'] = $data["size"] ;
        $args['level'] = $data["level"] ;

        return $this->container->get('renderer')->render($response, 'game/load.phtml', $args);
    }

    public function saveAction(Request $request, Response $response, array $args) {
        // Sample log message
        $this->container->get('logger')->info("Sudoku Solver '/Grid/save' route");

        $data = $request->getParsedBody() ;
        
        $path = $data["size"] . '/' . $data["level"] . '/' . $data["id"] . '.php' ;
        $content = $this->mapToString($data["t"]);
        $this->container->get('filesystem')->write($path, $content) ;
        
        $url = $this->container->get('router')->pathFor('home') ;
        return $response->withStatus(302)->withHeader('Location', $url) ;

//        $command = $this->container->get('creategrid') ;
//        $command->dto()->id = uniqid() ;
//        $command->dto()->size = (int) $data["size"] ;
//        $command->dto()->level = $data["level"] ;
//        
//        $this->container->get('eventmanager')->trigger(Command::CREATE_GRID, $this, $command);
//        var_dump($command);
//        var_dump($command->payload()) ;

        
        

//        return $this->renderer->render($response, 'new.phtml', $args);
    }
}