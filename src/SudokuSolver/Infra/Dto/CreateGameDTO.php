<?php

namespace Sudoku\Infra\Dto ;

use Sudoku\Domain\Entity\Size;
use Swaggest\JsonSchema\Constraint\Format;
use Swaggest\JsonSchema\Constraint\Properties;
use Swaggest\JsonSchema\Schema;
use Swaggest\JsonSchema\Structure\ClassStructure;

class CreateGameDTO extends ClassStructure implements DTOinterface {
    /** @var int */
    public $size ;
    
    /** @var string */
    public $id ;
    public $createTime ;
    
    /**
     * @param Properties|static $properties
     * @param Schema $schema
     */
    public static function setUpProperties($properties, Schema $schema)
    {
        $properties->id = Schema::string();
        $properties->size = Schema::integer() ;
        $properties->size->enum = Size::value() ;
        $properties->createTime = Schema::string();
        $properties->createTime->format = Format::DATE_TIME ;
    }
    
    public function returnSelf(ClassStructure $dto)
    {
        return CreateGameDTO::export($dto) ;
    }
} 