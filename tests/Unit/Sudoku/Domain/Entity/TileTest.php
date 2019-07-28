<?php

namespace Tests\Unit\Sudoku\Domain\Entity ;

use PHPUnit\Framework\TestCase;
use Sudoku\Domain\Entity\Tile;

class TileTest extends TestCase
{
    public function testInitialTileEmpty()
    {
        $sut = new Tile() ;

        $this->assertNull($sut->row());
        $this->assertNull($sut->col());
        $this->assertNull($sut->region());
        $this->assertNull($sut->value());
    }

    public function testTileSet()
    {
        $sut = new Tile() ;
        $sut->set(4, 2, 2, 1) ;

        $this->assertSame(2, $sut->row());
        $this->assertSame(2, $sut->col());
        $this->assertSame(3, $sut->region());
        $this->assertSame(1, $sut->value());
    }    
}
