<?php

namespace Sudoku\Infra\Entity;

use SplFileObject;

/**
 * Description of SudokuGridFileToSave
 *
 * @author haclong
 */
class SudokuGridFileToSave {
    public function __construct($filepath, $filecontent) {
        if(!file_exists(dirname($filepath))) {
            $oldumask = umask(0) ;
            mkdir(dirname($filepath), 0777, true);
            umask($oldumask) ;
        }
        $file = new SplFileObject($filepath, 'w') ;
        $file->fwrite($filecontent) ;
    }
}
