<?php

namespace Sudoku\Infra\Entity;

use Sudoku\Infra\Exception\ArrayExpected;
use Sudoku\Infra\Exception\ArrayKeyNotFound;
use Sudoku\Infra\Exception\ArraySizeNotMatching;
use Sudoku\Infra\Exception\IntExpected;
use Sudoku\Infra\Exception\InvalidFigureCount;
use Sudoku\Infra\Exception\InvalidLevelValue;
use Sudoku\Infra\Exception\WrongGridSize;

/**
 * Description of SudokuGridFromPost
 *
 * @author haclong
 */
class SudokuGridFromPost {
    protected $array ;
    protected $size ;
    protected $level ;
    protected $values = [] ;
    
    public function __construct(array $requestParam)
    {
        if(!array_key_exists('t', $requestParam))
        {
            throw new ArrayKeyNotFound('t') ;
        }
        if(!array_key_exists('size', $requestParam))
        {
            throw new ArrayKeyNotFound('size') ;
        }
        if(!array_key_exists('level', $requestParam))
        {
            throw new ArrayKeyNotFound('level') ;
        }
        $this->checkT($requestParam) ;
        $this->checkSize($requestParam) ;
        $this->checkValues($requestParam) ;
        $this->checkLevel($requestParam) ;
        $this->mapT($requestParam) ;
    }

    public function getSize()
    {
        return $this->size ;
    }
    
    public function getArray()
    {
        return $this->array ;
    }
    public function getLevel()
    {
        return $this->level ;
    }
    
    private function mapT($requestParam)
    {
        $this->size  = $requestParam['size'] ;
        $this->level = $requestParam['level'] ;
        $this->array = [] ;
        foreach($requestParam['t'] as $row => $cols)
        {
            foreach($cols as $col => $value)
            {
                if(!empty($value))
                {
                    $this->array[$row][$col] = $value ;
                }
            }
        }
    }
    
    private function checkT($requestParam)
    {
        if(!is_array($requestParam['t']))
        {
            throw new ArrayExpected('t') ;
        }

        if(count($requestParam['t']) != $requestParam['size'])
        {
            throw new ArraySizeNotMatching('t') ;
        }
        foreach($requestParam['t'] as $k => $v)
        {
            if(count($requestParam['t'][$k]) != $requestParam['size'])
            {
                throw new ArraySizeNotMatching($k) ;
            }
        }
    }

    private function checkSize($requestParam)
    {
        if(!is_numeric($requestParam['size']))
        {
            throw new IntExpected('size') ;
        }
        elseif(!($requestParam['size'] == 4
           || $requestParam['size'] == 9
           || $requestParam['size'] == 16
           || $requestParam['size'] == 25))
        {
            throw new WrongGridSize($requestParam['size']) ;
        }
    }
    
    private function checkValues($requestParam)
    {
        foreach($requestParam['t'] as $row => $cols)
        {
            foreach($cols as $col => $value)
            {
                if(!empty($value))
                {
                    $this->countNewValue($value, $requestParam['size']) ;
                }
            }
        }
    }
    
    private function checkLevel($requestParam)
    {
        if(!in_array($requestParam['level'], ['easy', 'normal', 'hard', 'crazy']))
        {
            throw new InvalidLevelValue($requestParam['level']) ;
        }
    }
    
    private function countNewValue($value, $size)
    {
        if(!in_array($value, $this->values))
        {
            if(count($this->values) >= $size )
            {
                throw new InvalidFigureCount('Maximum allowed figure number reached : ' .$this->size) ;
            }
            $this->values[] = $value ;
        }    
    }
}
