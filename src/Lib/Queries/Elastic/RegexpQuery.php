<?php
/**
 * Created by PhpStorm.
 * User: Davidych
 * Date: 22.02.19
 * Time: 16:27
 */

namespace SphereMall\MS\Lib\Queries\Elastic;


use SphereMall\MS\Lib\Queries\Interfaces\ElasticQueryInterface;

/**
 * Class RegexpFilter
 *
 * @package SphereMall\MS\Lib\Filters\Elastic
 */
class RegexpQuery extends BasicQuery implements ElasticQueryInterface
{
    private $value = null;
    private $field = null;

    /**
     * RegexpFilter constructor.
     *
     * @param string $field
     * @param string $value
     */
    public function __construct(string $field, string $value)
    {
        $this->value = $value;
        $this->field = $field;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'regexp' => [
                $this->field => array_merge(['value' => $this->value], $this->additionalParams),
            ],
        ];
    }
}
