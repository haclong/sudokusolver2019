<?php

namespace Sudoku\Domain\Entity;

/**
 *
 * @author haclong
 */
interface ReloadInterface {
    public function reload(Grid $grid) ;
}
