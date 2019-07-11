<?php

namespace Sudoku\Infra\Controller;

use Exception;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;
use Sudoku\Infra\Entity\SudokuGridFileToSave;
use Sudoku\Infra\Entity\SudokuGridFromPost;
use Sudoku\Infra\Entity\SudokuGridToFileMapper;

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
        print_r($this->container->has('event'));

        // sample log message
        $this->container->get('logger')->info("create Grid") ;

        return $this->container->get('renderer')->render($response, 'grid/create.phtml', $args);
    }

    public function submitAction(Request $request, Response $response, array $args) {
        $this->container->get('logger')->info('submit Grid creation');

        $data = $request->getParsedBody() ;
        var_dump($data) ;
        return $this->container->get('renderer')->render($response, 'grid/submit.phtml', $args);
    }

    public function newAction(Request $request, Response $response, array $args) {
        // Sample log message
        $this->container->get('logger')->info("Sudoku Solver '/new' route");

        return $this->container->get('renderer')->render($response, 'new.phtml', $args);
    }

    public function saveAction(Request $request, Response $response, array $args) {
        // Sample log message
        $this->container->get('logger')->info("Sudoku Solver '/new' route");
    
        //    echo get_class($request->getParams()) ;
        $sudokuGrid = new SudokuGridFromPost($request->getParams()) ;
        $sudokuGridToFileMapper = new SudokuGridToFileMapper($sudokuGrid) ;
        new SudokuGridFileToSave('../datas/' .$sudokuGridToFileMapper->filepath, $sudokuGridToFileMapper->filecontent) ;

        return $response->withJson($request->getParam('size')) ;
        return $this->renderer->render($response, 'new.phtml', $args);
    }

}
