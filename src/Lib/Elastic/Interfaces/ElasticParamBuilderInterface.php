<?php
/**
 * Created by PhpStorm.
 * User: Davidych
 * Date: 11.03.19
 * Time: 9:19
 */

namespace SphereMall\MS\Lib\Elastic\Interfaces;


interface ElasticParamBuilderInterface
{
    /**
     * @return array
     */
    public function createFilter(): array;
}
