<?php
/**
 * Created by PhpStorm.
 * User: Davidych
 * Date: 25.02.19
 * Time: 11:56
 */

namespace SphereMall\MS\Lib\Elastic\Aggregations;


use SphereMall\MS\Lib\Elastic\Aggregations\Traits\MetricAggregation;
use SphereMall\MS\Lib\Elastic\Interfaces\ElasticBodyElement;

class MinAggregation extends BasicAggregation implements ElasticBodyElement
{
    use MetricAggregation;

    protected $type = 'min';
}
