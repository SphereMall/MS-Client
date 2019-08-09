<?php
namespace SphereMall\MS\Lib\Mappers;

use SphereMall\MS\Entities\Objects\ListObject;

class ListObjectMapper extends Mapper
{
    protected function doCreateObject(array $array)
    {
        return new ListObject($array);
    }
}