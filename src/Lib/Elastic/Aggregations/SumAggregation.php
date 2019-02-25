<?php
/**
 * Created by PhpStorm.
 * User: Davidych
 * Date: 25.02.19
 * Time: 11:56
 */

namespace SphereMall\MS\Lib\Elastic\Aggregations;


use SphereMall\MS\Lib\Elastic\Interfaces\ElasticBodyElement;

/**
 * Class SumAggregation
 *
 * @package SphereMall\MS\Lib\Elastic\Aggregations
 */
class SumAggregation extends BasicAggregation implements ElasticBodyElement
{

    private $field = null;

    /**
     * SumAggregation constructor.
     *
     * @param string $field
     */
    public function __construct(string $field)
    {
        $this->field = $field;
    }

    /**
     * Convert to array
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'avg' => array_merge([
                'fields' => $this->field,
            ], $this->additionalParams),
        ];
    }
}
