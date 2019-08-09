<?php
namespace SphereMall\MS\Lib\Mappers;

use SphereMall\MS\Entities\Objects\SubscribeObject;

class SubscribeObjectMapper extends Mapper
{
    protected function doCreateObject(array $array)
    {
        return new SubscribeObject($array);
    }
}