<?php

namespace Sudoku\Domain\Entity ;

class Tile implements \JsonSerializable
{
    protected $value ;
    protected $size ;
    protected $row ;
    protected $col ;
    protected $region ;
    
    public function set($size, $row, $col, $value)
    {
        $this->value = $value ;
        $this->row = $row ;
        $this->size = $size ;
        $this->col = $col ;
        $this->region = $this->calculateRegion() ;
    }

    public function value()
    {
        return $this->value ;
    }

    public function row()
    {
        return $this->row ;
    }

    public function col()
    {
        return $this->col ;
    }
    
    public function region()
    {
        return $this->region ;
    }
    
    private function calculateRegion()
    {
        $region = null ;
        
        if(!is_null($this->size))
        {
            $sqrt = sqrt($this->size) ;

            // Identify which part of the grid the row belong to
            $row_region = floor(($this->row / $this->size) * $sqrt) ;

            // Identify which part of the grid the column belongs to
            $col_region = floor(($this->col / $this->size) * $sqrt) ;

            // Identify region number
            $region = ($row_region * $sqrt) + $col_region ;
            settype($region, 'integer') ;
        }

        return $region ;
    }
    
    public function jsonSerialize()
    {
        return [
            "row" => $this->row,
            "col" => $this->col,
            "region" => $this->region,
            "value" => (int) $this->value
        ] ;
    }
}