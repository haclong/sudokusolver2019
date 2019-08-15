<?php

namespace Sudoku\Infra\Controller;

use DateTime;
use DateTimeZone;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;
use Sudoku\Domain\Command\Command;

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
        
        $this->container->get('eventstore')->getEvents() ;
        
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

        $this->container->get('gamecommandhandler') ;
        
        $timezone = new DateTimeZone('UTC') ;
        $date = new DateTime("now", $timezone) ;
        
        $command = $this->container->get('creategame') ;
        $command->dto()->id = uniqid() ;
        $command->dto()->size = (int) $data["size"] ;
        $command->dto()->createTime = $date->format(DATE_RFC3339) ;
       
        $this->container->get('eventmanager')->trigger(Command::CREATE_GAME, $this, $command);
//        var_dump($command);
//        var_dump($command->payload()) ; 



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