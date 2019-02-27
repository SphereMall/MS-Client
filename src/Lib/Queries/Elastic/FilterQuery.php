<?php
/**
 * Created by PhpStorm.
 * User: Davidych
 * Date: 22.02.19
 * Time: 19:06
 */

namespace SphereMall\MS\Lib\Queries\Elastic;


use SphereMall\MS\Lib\Queries\Interfaces\ElasticBoolQueryInterface;

class FilterQuery extends BasicBoolQuery implements ElasticBoolQueryInterface
{
    protected $queryType = "filter";
}
