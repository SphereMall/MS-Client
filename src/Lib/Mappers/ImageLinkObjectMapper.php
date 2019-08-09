<?php
namespace SphereMall\MS\Lib\Mappers;

use SphereMall\MS\Entities\Objects\ImageLinkObject;

class ImageLinkObjectMapper extends Mapper
{
    protected function doCreateObject(array $array)
    {
        return new ImageLinkObject($array);
    }
}