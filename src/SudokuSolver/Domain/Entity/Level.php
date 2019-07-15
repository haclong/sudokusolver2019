<?php

namespace Sudoku\Domain\Entity ;

class Level
{
    const EASY = 'easy' ;
    const NORMAL = 'normal' ;
    const HARD = 'hard' ;
    const NIGHTMARE = 'nightmare' ;
    
    public static function value()
    {
        $values[self::EASY] = 'easy';
        $values[self::NORMAL] = 'normal';
        $values[self::HARD] = 'hard';
        $values[self::NIGHTMARE] = 'nightmare';
        
        return $values ;
    }
}

