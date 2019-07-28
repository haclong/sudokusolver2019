<?php

namespace Sudoku\Domain\Entity ;

use JsonSerializable;

class Grid implements JsonSerializable
{
    protected $tiles ;
    protected $size ;
    protected $level ;
    protected $id ;
    
    public function create($size, $level, $id, $tiles)
    {
        $this->size = $size ;
        $this->level = $level ;
        $this->id = $id ;
        $this->tiles = $tiles ;
    }

    public function size()
    {
        return $this->size ;
    }

    public function level()
    {
        return $this->level ;
    }

    public function id()
    {
        return $this->id ;
    }
    
    public function tiles()
    {
        return $this->tiles ;
    }
    
    public function jsonSerialize()
    {
        return [
            "id" => $this->id,
            "size" => $this->size,
            "level" => $this->level,
            "tiles" => $this->tiles
        ] ;
    }
}