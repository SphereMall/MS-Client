<?php
/**
 * Created by PhpStorm.
 * User: Davidych
 * Date: 25.02.19
 * Time: 11:57
 */

namespace SphereMall\MS\Lib\Elastic\Aggregations;


use SphereMall\MS\Lib\Elastic\Interfaces\ElasticBodyElementInterface;

/**
 * Class TermsAggregation
 *
 * @package SphereMall\MS\Lib\Elastic\Aggregations
 */
class TermsAggregation extends BasicAggregation implements ElasticBodyElementInterface
{
    private $field = null;
    private $size  = null;

    /**
     * TermsAggregation constructor.
     *
     * @param string $field
     * @param int    $size
     */
    public function __construct(string $field, int $size = 10)
    {
        $this->field = $field;
        $this->size  = $size;
    }

    /**
     * Convert to array
     *
     * @return array
     */
    public function toArray(): array
    {
        $result = [
            'terms' => array_merge([
                'field' => $this->field,
                'size'  => $this->size,
            ], $this->additionalParams),
        ];

        if ($this->subAggregations) {
            $result['aggs'] = $this->subAggregations;
        }
        return $result;
    }
}
