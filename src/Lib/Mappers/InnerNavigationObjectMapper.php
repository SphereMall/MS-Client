<?php
namespace SphereMall\MS\Lib\Mappers;

use SphereMall\MS\Entities\Objects\InnerNavigationObject;

class InnerNavigationObjectMapper extends Mapper
{
    protected function doCreateObject(array $array)
    {
        return new InnerNavigationObject($array);
    }
}