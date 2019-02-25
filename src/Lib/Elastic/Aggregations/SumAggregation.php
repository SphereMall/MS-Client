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

/**
 * Class SumAggregation
 *
 * @package SphereMall\MS\Lib\Elastic\Aggregations
 */
class SumAggregation extends BasicAggregation implements ElasticBodyElement
{
    use MetricAggregation;

    protected $type = 'sum';
}
