<?php
/**
 * Created by PhpStorm.
 * User: Davidych
 * Date: 22.02.19
 * Time: 17:24
 */

namespace SphereMall\MS\Lib\Queries\Elastic;


use SphereMall\MS\Lib\Queries\Interfaces\ElasticQueryInterface;

/**
 * Class WildCardQuery
 *
 * @package SphereMall\MS\Lib\Queries\Elastic
 */
class WildCardQuery extends BasicQuery implements ElasticQueryInterface
{
    private $field = null;
    private $value = null;

    /**
     * WildCardQuery constructor.
     *
     * @param string $field
     * @param string $value
     */
    public function __construct(string $field, string $value)
    {
        $this->field = $field;
        $this->value = $value;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'wildcard' => [
                $this->field => array_merge([
                    'value' => $this->value,
                ], $this->additionalParams),
            ],
        ];
    }
}
