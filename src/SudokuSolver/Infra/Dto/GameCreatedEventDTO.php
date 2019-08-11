<?php

namespace Sudoku\Infra\Dto ;

use Swaggest\JsonSchema\Constraint\Format;
use Swaggest\JsonSchema\Constraint\Properties;
use Swaggest\JsonSchema\Schema;
use Swaggest\JsonSchema\Structure\ClassStructure;

class GameCreatedEventDTO extends ClassStructure implements DTOinterface {
    /** @var string */
    public $id ;
    public $datetime ;
    public $name ;
    public $gamecreated ;
    
    /**
     * @param Properties|static $properties
     * @param Schema $schema
     */
    public static function setUpProperties($properties, Schema $schema)
    {
        $properties->id = Schema::string();
        $properties->name = Schema::string() ;
        $properties->datetime = Schema::string();
        $properties->datetime->format = Format::DATE_TIME ;
        $properties->gamecreated = GameCreatedDTO::schema() ;
    }
        
    public function returnSelf(ClassStructure $dto)
    {
        return GameCreatedWrapperDTO::export($dto) ;
    }
} 