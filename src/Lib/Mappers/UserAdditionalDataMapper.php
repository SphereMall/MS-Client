<?php
/**
 * Created by PhpStorm.
 * User: Oleksandr Rokytskyi
 * Date: 07.11.2018
 * Time: 12:26
 */

namespace SphereMall\MS\Lib\Mappers;


use SphereMall\MS\Entities\UserAdditionalData;

class UserAdditionalDataMapper extends Mapper
{

    protected function doCreateObject(array $array)
    {
        return new UserAdditionalData($array);
    }
}