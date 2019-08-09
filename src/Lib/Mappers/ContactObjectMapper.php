<?php
namespace SphereMall\MS\Lib\Mappers;

use SphereMall\MS\Entities\Objects\ContactObject;

/**
 * Class ContactObjectMapper
 * @package SphereMall\MS\Lib\Mappers
 */
class ContactObjectMapper extends Mapper
{
    /**
     * @param array $array
     *
     * @return ContactObject
     */
    protected function doCreateObject(array $array)
    {
        return new ContactObject($array);
    }
}
