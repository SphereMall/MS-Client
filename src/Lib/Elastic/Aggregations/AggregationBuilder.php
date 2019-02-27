<?php
/**
 * Created by PhpStorm.
 * User: Davidych
 * Date: 26.02.19
 * Time: 9:17
 */

namespace SphereMall\MS\Lib\Elastic\Aggregations;

use SphereMall\MS\Lib\Elastic\Interfaces\ElasticAggregationInterface;
use SphereMall\MS\Lib\Elastic\Interfaces\ElasticBodyElement;

/**
 * Class AggregationBuilder
 *
 * @package SphereMall\MS\Lib\Elastic\Aggregations
 */
class AggregationBuilder implements ElasticBodyElement
{
    private $aggregations = [];

    /**
     * AggregationBuilder constructor.
     *
     * @param string                      $name
     * @param ElasticAggregationInterface $aggregation
     */
    public function __construct(string $name, ElasticAggregationInterface $aggregation)
    {

    }

    /**
     * Convert to array
     *
     * @return array
     */
    public function toArray(): array
    {

    }
}
