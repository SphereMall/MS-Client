<?php
/**
 * Created by PhpStorm.
 * User: Davidych
 * Date: 25.02.19
 * Time: 13:31
 */

namespace SphereMall\MS\Lib\Elastic\Sort;


use SphereMall\MS\Lib\Elastic\Interfaces\ElasticBodyElement;

/**
 * Class SortElement
 *
 * @package SphereMall\MS\Lib\Elastic\Sort
 */
class SortElement implements ElasticBodyElement
{
    private $field      = null;
    private $order      = null;
    private $additional = [];

    /**
     * SortElement constructor.
     *
     * @param string $field
     * @param string $order
     * @param array  $additional
     */
    public function __construct(string $field, string $order = "asc", array $additional = [])
    {
        $this->field      = $field;
        $this->order      = $order;
        $this->additional = $additional;
    }

    /**
     * Convert to array
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            $this->field => array_merge([
                'order' => $this->order,
            ], $this->additional),
        ];
    }
}
