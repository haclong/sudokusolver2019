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

        $this->container->get('creategridhandler') ;

        $args['id'] = uniqid() ;
        $args['size'] = $data["size"] ;
        $args['level'] = $data["level"] ;

        return $this->container->get('renderer')->render($response, 'grid/compose.phtml', $args);
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
    }

    private function mapToString($array)
    {
        $string = '<?php' . "\r\n" ;
        
        foreach($array as $row => $cols)
        {
            foreach($cols as $col => $value)
            {
                if(!empty($value))
                {
                    $string .= '$array['.$row.']['.$col.'] = '.$value.' ;'."\r\n" ;
                }
            }
        }

        $string .= 'return $array ;' ;
        
        return $string ;
    }    
}
