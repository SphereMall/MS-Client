<?php
/**
 * Created by PhpStorm.
 * User: Davidych
 * Date: 25.02.19
 * Time: 11:55
 */

namespace SphereMall\MS\Lib\Elastic\Aggregations;


use SphereMall\MS\Lib\Elastic\Aggregations\Traits\MetricAggregation;
use SphereMall\MS\Lib\Elastic\Interfaces\ElasticBodyElementInterface;

class MaxAggregation extends BasicAggregation implements ElasticBodyElementInterface
{
    use MetricAggregation;

    protected $type = 'max';
}
