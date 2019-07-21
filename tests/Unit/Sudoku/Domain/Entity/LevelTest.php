<?php

namespace Tests\Unit\Sudoku\Domain\Entity ;

use PHPUnit\Framework\TestCase;
use Sudoku\Domain\Entity\Level;

class LevelTest extends TestCase
{
    public function testValue()
    {
        $level = new Level() ;
        $values = $level->value() ;
        

        $this->assertStringContainsString('easy', (string)$values['easy']);
        $this->assertStringContainsString('normal', (string)$values['normal']);
        $this->assertStringContainsString('hard', (string)$values['hard']);
        $this->assertStringContainsString('nightmare', (string)$values['nightmare']);
    }
}
