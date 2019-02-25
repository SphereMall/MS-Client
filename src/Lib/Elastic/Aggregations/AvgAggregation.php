<?php
/**
 * Created by PhpStorm.
 * User: Davidych
 * Date: 25.02.19
 * Time: 11:55
 */

namespace SphereMall\MS\Lib\Elastic\Aggregations;


use SphereMall\MS\Lib\Elastic\Interfaces\ElasticBodyElement;

class AvgAggregation extends BasicAggregation implements ElasticBodyElement
{
    /**
     * Convert to array
     *
     * @return array
     */
    public function toArray(): array
    {

    }
}
