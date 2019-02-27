<?php
/**
 * Created by PhpStorm.
 * User: Davidych
 * Date: 22.02.19
 * Time: 18:55
 */

namespace SphereMall\MS\Lib\Queries\Elastic;


use SphereMall\MS\Lib\Queries\Interfaces\ElasticBoolQueryInterface;

/**
 * Class ShouldQuery
 *
 * @package SphereMall\MS\Lib\Queries\Elastic
 */
class ShouldQuery extends BasicBoolQuery implements ElasticBoolQueryInterface
{
    protected $queryType = "should";
}
