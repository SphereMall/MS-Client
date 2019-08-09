<?php
namespace SphereMall\MS\Lib\Mappers;

use SphereMall\MS\Entities\Objects\HTMLObject;

class HTMLObjectMapper extends Mapper
{
    protected function doCreateObject(array $array)
    {
        return new HTMLObject($array);
    }
}