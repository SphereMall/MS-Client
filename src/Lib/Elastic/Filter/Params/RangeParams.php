<?php
/**
 * Created by PhpStorm.
 * User: ddis
 * Date: 09.03.19
 * Time: 12:03
 */

namespace SphereMall\MS\Lib\Elastic\Filter\Params;


use SphereMall\MS\Lib\Elastic\Interfaces\ElasticBodyElementInterface;
use SphereMall\MS\Lib\Elastic\Interfaces\ElasticParamBuilderInterface;
use SphereMall\MS\Lib\Elastic\Interfaces\ElasticParamElementInterface;
use SphereMall\MS\Lib\Elastic\Queries\RangeQuery;

/**
 * Class RangeParams
 *
 * @package SphereMall\MS\Lib\Elastic\Filter\Params
 */
class RangeParams implements ElasticParamElementInterface, ElasticParamBuilderInterface
{
    private $type   = null;
    private $field  = null;
    private $params = [];

    /**
     * RangeParams constructor.
     *
     * @param string $type
     * @param string $field
     * @param array  $params
     */
    public function __construct(string $type, string $field, array $params)
    {
        $this->type   = $type;
        $this->field  = $field;
        $this->params = $params;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return [
            'range' => [
                $this->type => [
                    $this->field => $this->params,
                ],
            ],
        ];
    }

    /**
     * @return ElasticBodyElementInterface
     */
    public function createFilter(): ElasticBodyElementInterface
    {
        if ($this->type == 'attributes') {
            $field = $this->field . "_attr.attributeValue.int";
        } else {
            $field = $this->field;
        }

        return new RangeQuery($field, $this->params);
    }
}
