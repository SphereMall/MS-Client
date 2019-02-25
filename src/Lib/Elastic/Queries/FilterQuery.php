<?php
/**
 * Created by PhpStorm.
 * User: Davidych
 * Date: 22.02.19
 * Time: 19:06
 */

namespace SphereMall\MS\Lib\Elastic\Queries;

use SphereMall\MS\Lib\Elastic\Interfaces\ElasticBoolQueryInterface;
use SphereMall\MS\Lib\Elastic\Interfaces\ElasticBodyElement;

class FilterQuery extends BasicBoolQuery implements ElasticBoolQueryInterface, ElasticBodyElement
{
    protected $queryType = "filter";
}
