<?php

namespace Tests\Unit\Sudoku\Domain\Infra\Controller ;

use PHPUnit\Framework\TestCase;
use Slim\Http\Request;
use Slim\Http\Response;
use stdClass;
use Sudoku\Infra\Controller\GridController;
use Slim\Container;

class GridControllerTest extends TestCase
{
    protected function setUp():void
    {
        $this->renderer = $this->getMockBuilder(stdClass::class)
                               ->setMethods(['render'])
                               ->getMock();
        $this->logger = $this->getMockBuilder(stdClass::class)
                             ->setMethods(['info'])
                             ->getMock();
        $this->filesystem = $this->getMockBuilder(stdClass::class)
                             ->setMethods(['write'])
                             ->getMock();
        $this->router = $this->getMockBuilder(stdClass::class)
                             ->setMethods(['pathFor'])
                             ->getMock();

        $this->container = $this->getMockBuilder(Container::class)
                                ->setMethods(['get'])
                                ->getMock();
        $this->container->method('get')
                        ->will($this->onConsecutiveCalls($this->logger, $this->renderer)) ;

        $this->request = $this->createMock(Request::class) ;
        $this->response = $this->createMock(Response::class) ;
    }

    public function testCreateAction() {
        
        $sut = new GridController($this->container) ;

        $args['size'] = '4' ;
        $args['level'] = 'easy' ;

        $this->container->expects($this->exactly(2))
                        ->method('get')
                        ->withConsecutive(
                            ['logger'],
                            ['renderer']
                        );
        $sut->createAction($this->request, $this->response, $args) ;
    }

    public function testComposeAction() {
        
        $request = $this->getMockBuilder(Request::class)
                        ->disableOriginalConstructor()
                        ->setMethods(['getParsedBody'])
                        ->getMock();

        $sut = new GridController($this->container) ;

        $args['id'] = uniqid() ;
        $args['size'] = '4' ;
        $args['level'] = 'easy' ;
        
        $request->expects($this->once())
                ->method('getParsedBody') ;

        $this->container->expects($this->exactly(2))
                        ->method('get')
                        ->withConsecutive(
                            ['logger'],
                            ['renderer']
                        );
        $sut->composeAction($request, $this->response, $args) ;
    }

    public function testSaveAction() {
        
        $request = $this->getMockBuilder(Request::class)
                        ->disableOriginalConstructor()
                        ->setMethods(['getParsedBody'])
                        ->getMock();
        $response = $this->getMockBuilder(Response::class)
                         ->disableOriginalConstructor()
                         ->setMethods(['withStatus', 'withHeader'])
                         ->getMock();
        $this->tile = $this->getMockBuilder(stdClass::class)
                               ->setMethods(['set'])
                               ->getMock();
        $this->grid = $this->getMockBuilder(stdClass::class)
                               ->setMethods(['create'])
                               ->getMock();

        $container = $this->getMockBuilder(Container::class)
                          ->setMethods(['get'])
                          ->getMock();
        $container->method('get')
                   ->will($this->onConsecutiveCalls($this->logger,
                                                    $this->tile,
                                                    $this->grid,
                                                    $this->filesystem, 
                                                    $this->router)) ;

        $sut = new GridController($container) ;

        $args['id'] = uniqid() ;
        $args['size'] = '4' ;
        $args['level'] = 'easy' ;
        $args['t'][1][3] = 2 ;
        $args['t'][2][0] = 1 ;
        $args['t'][2][2] = 4 ;
        
        $request->expects($this->once())
                ->method('getParsedBody')
                ->willReturn($args) ;
        
        $response->expects($this->once())
                 ->method('withStatus')
                 ->willReturnSelf() ;

        $container->expects($this->exactly(5))
                        ->method('get')
                        ->withConsecutive(
                            ['logger'],
                            ['tile'],
                            ['grid'],
                            ['filesystem'],
                            ['router']
                        );
        $sut->saveAction($request, $response, $args) ;
    }
}
