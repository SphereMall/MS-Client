<?php
namespace SphereMall\MS\Lib\Mappers;

use SphereMall\MS\Entities\Objects\SliderObject;

class SliderObjectMapper extends Mapper
{
    protected function doCreateObject(array $array)
    {
        return new SliderObject($array);
    }
}