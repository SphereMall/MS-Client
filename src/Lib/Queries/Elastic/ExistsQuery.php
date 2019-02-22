<?php
/**
 * Created by PhpStorm.
 * User: Davidych
 * Date: 22.02.19
 * Time: 16:46
 */

namespace SphereMall\MS\Lib\Queries\Elastic;


use SphereMall\MS\Lib\Filters\Interfaces\ElasticFilterInterface;

/**
 * Class ExistsFilter
 *
 * @package SphereMall\MS\Lib\Filters\Elastic
 */
class ExistsQuery extends BasicQuery implements ElasticFilterInterface
{
    private $field = null;

    /**
     * ExistsFilter constructor.
     *
     * @param string $field
     */
    public function __construct(string $field)
    {
        $this->field = $field;
    }

    /**
     * @return array
     */
    public function toArray():array
    {
        return [
            'exists' => [
                'field' => $this->field,
            ],
        ];
    }
}
