<?php
/**
 * Created by PhpStorm.
 * User: Davidych
 * Date: 25.02.19
 * Time: 17:23
 */

namespace SphereMall\MS\Lib\Elastic\Aggregations\Traits;


trait MetricAggregation
{
    private   $field = null;

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
            $this->type => $this->script ? ['script' => $this->script] : array_merge(['field' => $this->field],$this->additionalParams)
        ];
    }
}
