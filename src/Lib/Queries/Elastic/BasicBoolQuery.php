<?php
/**
 * Created by PhpStorm.
 * User: Davidych
 * Date: 22.02.19
 * Time: 18:45
 */

namespace SphereMall\MS\Lib\Queries\Elastic;

/**
 * Class BasicBoolQuery
 *
 * @package SphereMall\MS\Lib\Queries\Elastic
 */
abstract class BasicBoolQuery
{
    protected $elements  = [];
    protected $queryType = null;

    /**
     * BasicBoolQuery constructor.
     *
     * @param array $elements
     */
    public function __construct(array $elements)
    {
        $this->elements = $elements;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $queries = [];

        foreach ($this->elements as $element) {
            $queries[] = $element->toArray();
        }

        return [
            'bool' => [
                $this->queryType => $queries
            ],
        ];
    }
}
