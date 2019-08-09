<?php
/**
 * Created by PhpStorm.
 * User: Sergey
 * Date: 21.06.2019
 * Time: 15:38
 */

namespace SphereMall\MS\Lib\Mappers;

use SphereMall\MS\Entities\Objects\RelationObject;

/**
 * Class RelationObjectMapper
 * @package SphereMall\MS\Lib\Mappers
 */
class RelationObjectMapper extends Mapper
{
    /**
     * @param array $array
     *
     * @return RelationObject
     */
    protected function doCreateObject(array $array)
    {
        return new RelationObject($array);
    }
}