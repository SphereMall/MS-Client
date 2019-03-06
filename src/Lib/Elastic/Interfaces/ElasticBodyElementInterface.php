<?php
/**
 * Created by PhpStorm.
 * User: Davidych
 * Date: 25.02.19
 * Time: 9:13
 */

namespace SphereMall\MS\Lib\Elastic\Interfaces;


interface ElasticBodyElementInterface
{
    /**
     * Convert to array
     *
     * @return array
     */
    public function toArray(): array;
}
