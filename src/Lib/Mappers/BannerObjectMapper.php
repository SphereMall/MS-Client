<?php
namespace SphereMall\MS\Lib\Mappers;

use SphereMall\MS\Entities\Objects\BannerObject;

class BannerObjectMapper extends Mapper
{
    /**
     * @param array $array
     *
     * @return CardObject
     */
    protected function doCreateObject(array $array)
    {
        return new BannerObject($array);
    }
}