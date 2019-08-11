<?php

namespace Sudoku\Infra\Dto ;

use Swaggest\JsonSchema\Constraint\Format;
use Swaggest\JsonSchema\Constraint\Properties;
use Swaggest\JsonSchema\Schema;
use Swaggest\JsonSchema\Structure\ClassStructure;

class GameCreatedDTO extends ClassStructure implements DTOinterface {
    /** @var int */
    public $size ;

    /** @var string */
    public $id ;
    public $createdTime ;
    
    /**
     * @param Properties|static $properties
     * @param Schema $schema
     */
    public static function setUpProperties($properties, Schema $schema)
    {
        $properties->id = Schema::string();
        $properties->size = Schema::integer() ;
        $properties->createdTime = Schema::string();
        $properties->createdTime->format = Format::DATE_TIME ;
    }
    
    public function returnSelf(ClassStructure $dto)
    {
        return GameCreatedDTO::export($dto) ;
    }
} 