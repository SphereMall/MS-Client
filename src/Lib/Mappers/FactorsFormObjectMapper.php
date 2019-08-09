<?php
namespace SphereMall\MS\Lib\Mappers;

use SphereMall\MS\Entities\Objects\FactorsFormObject;

class FactorsFormObjectMapper extends Mapper
{
    protected function doCreateObject(array $array)
    {
        return new FactorsFormObject($array);
    }
}