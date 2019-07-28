<?php

namespace Tests\Unit\Sudoku\Domain\Entity ;

use PHPUnit\Framework\TestCase;
use Sudoku\Domain\Entity\Grid;

class GridTest extends TestCase
{
    public function testInitialGridEmpty()
    {
        $sut = new Grid() ;

        $this->assertNull($sut->size());
        $this->assertNull($sut->level());
        $this->assertNull($sut->id());
        $this->assertNull($sut->tiles());
    }

    public function testGridCreated()
    {
        $id = uniqid() ;
        $tiles = [] ;
        
        $sut = new Grid() ;
        $sut->create(4, 'easy', $id, $tiles) ;

        $this->assertSame(4, $sut->size());
        $this->assertSame('easy', $sut->level());
        $this->assertSame($id, $sut->id());
        $this->assertIsArray($sut->tiles());
    }    
}

