<?php

namespace Tests\Unit\Sudoku\Domain\Entity ;

use PHPUnit\Framework\TestCase;
use Sudoku\Domain\Entity\Size;

class SizeTest extends TestCase
{
    public function testValue()
    {
        $sut = new Size() ;
        $values = $sut->value() ;
        

        $this->assertStringContainsString('4', (string)$values['4']);
        $this->assertStringContainsString('9', (string)$values['9']);
        $this->assertStringContainsString('16', (string)$values['16']);
        $this->assertStringContainsString('25', (string)$values['25']);
    }
}
