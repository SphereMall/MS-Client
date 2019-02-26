<?php
/**
 * Created by PhpStorm.
 * User: Davidych
 * Date: 25.02.19
 * Time: 17:23
 */

namespace SphereMall\MS\Lib\Elastic\Aggregations\Traits;

/**
 * Trait MetricAggregation
 *
 * @package SphereMall\MS\Lib\Elastic\Aggregations\Traits
 */
trait MetricAggregation
{
    private $field = null;

    /**
     * MetricAggregation constructor.
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
        $result = [
            $this->type => $this->script ? ['script' => $this->script] : array_merge(['field' => $this->field], $this->additionalParams),
        ];

        if ($this->subAggregations) {
            $result['aggs'] = $this->subAggregations;
        }

        return $result;
    }
}
