<?php

namespace Sudoku\Infra\Entity;

use Sudoku\Infra\Entity\SudokuGridFromPost;

/**
 * Description of SudokuGridToFileMapper
 *
 * @author haclong
 */
class SudokuGridToFileMapper {
    public $filepath ;
    public $filecontent ;
    private $grid ;
    
    public function __construct(SudokuGridFromPost $grid) {
        $this->grid = $grid ;
        $this->getFilePath() ;
        $this->getContent() ;
    }
    
    private function getFilepath()
    {
        
        $this->filepath = $this->grid->getSize() . '/'. $this->grid->getLevel() . '/' . uniqid() . '.php' ;
    }
    
    private function getContent()
    {
        $this->filecontent = '<?php' . PHP_EOL ;
        $this->filecontent .= '$array = [] ;' .PHP_EOL ;
        foreach($this->grid->getArray() as $row => $rows) {
            foreach ($rows as $col => $value) {
                $this->filecontent .= '$array['.$row.']['.$col.'] = ' .$value. ' ;' .PHP_EOL ;
            }
        }
        $this->filecontent .= 'return $array ;' . PHP_EOL ;
    }
}
