<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sudoku\Domain;

class Payload
{
    //Predefined keys for query payloads, see App\Api\Schema::queryPagination() for further information
    const SKIP = 'skip';
    const LIMIT = 'limit';
    
    const GRID_ID = 'id'; 
    const GRID_SIZE = 'size'; 
    const GRID_LEVEL = 'level';
    const GRID_DATAS = 'datas';
    
    const CASE_COLUMN = 'column';
    const CASE_ROW = 'row';
    const CASE_REGION = 'region';
    const CASE_VALUE = 'value';
}