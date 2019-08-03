<?php

namespace Sudoku\Infra\Controller;

use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

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
        $files = $this->container->get('filesystem')->listContents($data['size'].'/'.$data['level'].'/', true) ;

        $flag = true ;
        while($flag == true)
        {
            $key = array_rand($files) ;
            if( $files[$key]['type'] == 'file')
            {
                $flag = false ;
                $gridpath = $files[$key]['path'] ;
                $grid = $this->container->get('filesystem')->read($gridpath) ;
            }
        }

        $args['grid'] = $grid ;

        return $this->container->get('renderer')->render($response, 'game/load.phtml', $args);
    }
}