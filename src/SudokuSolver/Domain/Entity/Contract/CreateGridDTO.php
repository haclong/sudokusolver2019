<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sudoku\Domain\Entity\Contract ;

use Swaggest\JsonSchema\Constraint\Properties;
use Swaggest\JsonSchema\Schema;
use Swaggest\JsonSchema\Structure\ClassStructure;

class CreateGridDTO extends ClassStructure {
    /** @var int */
    public $size ;
    
    /** @var string */
    public $id ;
    public $level ;
    
    /**
     * @param Properties|static $properties
     * @param Schema $schema
     */
    public static function setUpProperties($properties, Schema $schema)
    {
        $properties->id = Schema::string();
        $properties->size = Schema::integer() ;
        $properties->size->enum = [4, 9, 16, 25];
        $properties->level = Schema::string() ;
        $properties->level->enum = ['easy', 'normal', 'hard', 'nightmare'] ;        
    }
} 