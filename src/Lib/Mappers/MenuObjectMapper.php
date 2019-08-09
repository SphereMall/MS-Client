<?php
namespace SphereMall\MS\Lib\Mappers;

use SphereMall\MS\Entities\Objects\MenuObject;

class MenuObjectMapper extends Mapper
{
    protected function doCreateObject(array $array)
    {
        return new MenuObject($array);
    }
}