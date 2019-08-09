<?php
namespace SphereMall\MS\Lib\Mappers;

use SphereMall\MS\Entities\Objects\SearchObject;

class SearchObjectMapper extends Mapper
{
    protected function doCreateObject(array $array)
    {
        return new SearchObject($array);
    }
}