<?php

namespace Sudoku\Infra\Controller;

use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;
use Sudoku\Domain\Entity\Level;
use Sudoku\Domain\Entity\Size;

/**
 * Description of GridController
 *
 * @author haclong
 */
class GridController {

    public function __construct(ContainerInterface $container) {
        $this->container = $container ;
    }

    public function createAction(Request $request, Response $response, array $args) {
        // sample log message
        $this->container->get('logger')->info("create Grid") ;
        
        $args['size'] = Size::value() ;
        $args['level'] = Level::value() ;

        return $this->container->get('renderer')->render($response, 'grid/create.phtml', $args);
    }

    public function composeAction(Request $request, Response $response, array $args) {
        $this->container->get('logger')->info('submit Grid creation');

        $data = $request->getParsedBody() ;

        $args['id'] = $data["id"] ;
        $args['size'] = $data["size"] ;
        $args['level'] = $data["level"] ;

        return $this->container->get('renderer')->render($response, 'grid/compose.phtml', $args);
    }

    public function saveAction(Request $request, Response $response, array $args) {
        // Sample log message
        $this->container->get('logger')->info("Sudoku Solver '/Grid/save' route");

        $data = $request->getParsedBody() ;
        
        $path = $data["size"] . '/' . $data["level"] . '/' . $data["id"] . '.json' ;
        
        $grid = $this->mapToGrid($data);
        $content = json_encode($grid) ;

        $this->container->get('filesystem')->write($path, $content) ;
        
        $url = $this->container->get('router')->pathFor('home') ;
        return $response->withStatus(302)->withHeader('Location', $url) ;
    }
    
    
    private function mapToGrid($datas)
    {
        $tiles = [] ;
        $tileEntity = $this->container->get('tile') ;
        
        foreach($datas['t'] as $row => $cols)
        {
            foreach($cols as $col => $value)
            {
                if(!empty($value))
                {
                    $tile = clone $tileEntity ;
                    $tile->set($datas['size'], $row, $col, $value) ;
                    $tiles[] = $tile ;
                }
            }
        }

        $grid = $this->container->get('grid') ;
        $grid->create($datas['size'], $datas['level'], $datas['id'], $tiles) ;

        return $grid ;
    }    
}