<?php
/**
 * Created by PhpStorm.
 * User: Sergey
 * Date: 21.06.2019
 * Time: 15:38
 */

namespace SphereMall\MS\Lib\Mappers;

use SphereMall\MS\Entities\Objects\LocationObject;

/**
 * Class LocationObjectMapper
 * @package SphereMall\MS\Lib\Mappers
 */
class LocationObjectMapper extends Mapper
{
    /**
     * @param array $array
     *
     * @return LocationObject
     */
    protected function doCreateObject(array $array)
    {
        return new LocationObject($array);
    }
}