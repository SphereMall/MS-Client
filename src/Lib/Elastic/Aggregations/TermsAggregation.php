<?php
/**
 * Created by PhpStorm.
 * User: Davidych
 * Date: 25.02.19
 * Time: 11:57
 */

namespace SphereMall\MS\Lib\Elastic\Aggregations;


use SphereMall\MS\Lib\Elastic\Interfaces\ElasticBodyElement;

class TermsAggregation extends BasicAggregation implements ElasticBodyElement
{

    /**
     * Convert to array
     *
     * @return array
     */
    public function toArray(): array
    {
        // TODO: Implement toArray() method.
    }
}
