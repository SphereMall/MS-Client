<?php
namespace SphereMall\MS\Lib\Mappers;

use SphereMall\MS\Entities\Objects\CardObject;

class CardObjectMapper extends Mapper
{
    /**
     * @param array $array
     *
     * @return CardObject
     */
    protected function doCreateObject(array $array)
    {
        return new CardObject($array);
    }
}