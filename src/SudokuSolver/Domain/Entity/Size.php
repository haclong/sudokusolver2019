<?php

namespace Sudoku\Domain\Entity ;

class Size
{
    const CARRE_2 = 4 ;
    const CARRE_3 = 9 ;
    const CARRE_4 = 16 ;
    const CARRE_5 = 25 ;
    
    public static function value()
    {
        $values[self::CARRE_2] = 4 ;
        $values[self::CARRE_3] = 9 ;
        $values[self::CARRE_4] = 16 ;
        $values[self::CARRE_5] = 25 ;
        
        return $values ;
    }
}

