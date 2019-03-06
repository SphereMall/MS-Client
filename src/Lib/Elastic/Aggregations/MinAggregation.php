<?php
/**
 * Created by PhpStorm.
 * User: Davidych
 * Date: 25.02.19
 * Time: 11:56
 */

namespace SphereMall\MS\Lib\Elastic\Aggregations;


use SphereMall\MS\Lib\Elastic\Aggregations\Traits\MetricAggregation;
use SphereMall\MS\Lib\Elastic\Interfaces\ElasticBodyElementInterface;

class MinAggregation extends BasicAggregation implements ElasticBodyElementInterface
{
    use MetricAggregation;

    protected $type = 'min';
}
