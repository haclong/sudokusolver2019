<?php

namespace Tests\Functional;

class CreateGridPageTest extends BaseTestCase
{
    /**
     * Test that the index route returns a rendered response containing the text 'SlimFramework' but not a greeting
     */
    public function testGetCreateGridPage()
    {
        $response = $this->runApp('GET', '/Grid');

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('4', (string)$response->getBody());
        $this->assertStringContainsString('normal', (string)$response->getBody());
        $this->assertStringContainsString('Create', (string)$response->getBody());
        $this->assertStringNotContainsString('11', (string)$response->getBody());
    }

    /**
     * Test that the we can post the creation of a grid
     */
    public function testPostCreateGridPage()
    {
        $grid['id'] = uniqid() ;
        $grid['size'] = '4' ;
        $grid['level'] = 'easy' ;
        
        $response = $this->runApp('POST', '/Grid', $grid);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('Save', (string)$response->getBody());
        
        return $grid ;
    }
    

    /**
     * Test that the we can post the creation of a grid
     * @depends testPostCreateGridPage
     */
    public function testPostSaveGridPage(array $grid)
    {
        $grid['t'][0][0] = 1 ;
        $grid['t'][1][0] = 2 ;
        $grid['t'][2][0] = 3 ;
        $grid['t'][3][0] = 4 ;
        $path = $grid['size']. '/' .$grid['level']. '/' .$grid['id']. '.json' ;
        $response = $this->runApp('POST', '/Grid/save', $grid);

        $expectedJson = '{"id":"'.$grid['id'].'","size":"4","level":"easy","tiles":[{"row":0,"col":0,"region":0,"value":1},{"row":1,"col":0,"region":0,"value":2},{"row":2,"col":0,"region":2,"value":3},{"row":3,"col":0,"region":2,"value":4}]}' ;
        
        $this->assertTrue($this->getContainer()->get('filesystem')->has($path)) ;
        $this->assertFileExists('datas/' . $path) ;
        $this->assertJsonStringEqualsJsonFile('datas/' . $path, $expectedJson) ;
        $this->assertEquals(302, $response->getStatusCode());
        $this->assertContains('/', $response->getHeader('Location')) ;
        
        $this->getContainer()->get('filesystem')->delete($path) ;
    }
}
