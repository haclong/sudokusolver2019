<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sudoku\Infra\Dto ;

use Swaggest\JsonSchema\Structure\ClassStructure;

interface DTOinterface
{
    public function returnSelf(ClassStructure $dto) ;
}